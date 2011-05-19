<?php
/*======================================================================*\
||              Cybershade CMS - Your CMS, Your Way                     ||
\*======================================================================*/
if(!defined('INDEX_CHECK')){ die('Error: Cannot access directly.'); }

//make sure we have a db connection before we continue
if(defined('NO_DB')){ return; }
#echo dump($config);
    //set hourly cron to exec, run every 1 hour
    $hourly_cron = false;
    if(time()-$config['cron']['hourly_cron'] > $objCore->config('statistics', 'hourly_cron')){
        $objSQL->updateRow('statistics', array('value' => time()), 'variable = "hourly_cron"');
        $hourly_cron = true;
    }

    //set daily cron to exec, run every 24 hours
    $daily_cron = false;
    if(time()-$config['cron']['daily_cron'] > $objCore->config('statistics', 'daily_cron')){
        $objSQL->updateRow('statistics', array('value' => time()), 'variable = "daily_cron"');
        $daily_cron = true;
    }

    //set weekly cron to exec, run every 6 days
    $weekly_cron = false;
    if(time()-$config['cron']['weekly_cron'] > $objCore->config('statistics', 'weekly_cron')){
        $objSQL->updateRow('statistics', array('value' => time()), 'variable = "weekly_cron"');
        $weekly_cron = true;
    }

//
//--Start the CRONs
//
	//regenerate the statistics cache if any of them are run
	if($hourly_cron || $daily_cron || $weekly_cron){
		$objCache->generate_statistics_cache();
	}


	//do hourly cron
	if($hourly_cron){
		$objSQL->recordMessage('Hourly CRON is running', 'INFO');


		//update the user table with last active timestamp from online table
		$objSQL->query($objSQL->prepare(
			'UPDATE `$Pusers` u SET u.last_active =
				(SELECT o.timestamp
					FROM `$Ponline` o
					WHERE o.uid = u.id)
			WHERE EXISTS
				(SELECT oo.timestamp
					FROM `$Ponline` oo
					WHERE oo.uid = u.id)'
		));

		//remove the inactive ones..atm 20 mins == inactive
	    $objSQL->deleteRow('online', 'timestamp < '.$objTime->mod_time(time(), 0, 20, 0, 'TAKE'));


		$objPlugins->hook('CMSCron_hourly');
	}

	//do daily cron
	if($daily_cron){
		$objSQL->recordMessage('Daily CRON is running', 'INFO');

		$objPlugins->hook('CMSCron_daily');
	}

	//do weekly cron
	if($weekly_cron){
		$objSQL->recordMessage('Weekly CRON is running', 'INFO');

		$objPlugins->hook('CMSCron_weekly');
	}

?>