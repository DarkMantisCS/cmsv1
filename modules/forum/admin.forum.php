<?php
/*======================================================================*\
||              Cybershade CMS - Your CMS, Your Way                     ||
\*======================================================================*/
if(!defined('INDEX_CHECK')){ die('Error: Cannot access directly.'); }

class forum extends Module{

	public function doAction($action){
        $this->objPage->addPagecrumb(array(
			array('url' => '/'.root().'admin/forum/', 'name' => langVar('B_FORUM_ADMIN')),
        ));
		$this->autoLoadModule('forum', $this->objForum);

        if(preg_match('_setup/edit_i', $action)){ $action = 'modifyCat'; }
        if(preg_match('_setup_i', $action)){ $action = 'setup'; }
        if(preg_match('_config_i', $action)){ $action = 'config'; }
		if(is_empty($action)){ $action = 'index'; }

		switch(strtolower($action)){
			case 'index':
				$this->showIndex();
			break;

            case 'config':
                $this->configForum();
            break;

            case 'setup':
                $this->categoryManagement();
            break;

            case 'modifyCat':
                $this->categoryModify();
            break;

			default:
			case 404:
				$this->throwHTTP(404);
			break;
		}
	}

    public function showIndex(){
		$counter = 0; $columns = 2;
		$links = array(
			array('url'=>'/'.root().'admin/forum/config/',           'name' => langVar('L_CONFIG')),
			array('url'=>'/'.root().'admin/forum/setup/',            'name' => langVar('L_CAT_MANAGE')),
			array('url'=>'/'.root().'admin/forum/group/?mode=group', 'name' => langVar('L_GROUP_PERMS')),
			array('url'=>'/'.root().'admin/forum/group/?mode=user',  'name' => langVar('L_USER_PERMS')),
		);

		$this->objTPL->set_filenames(array(
			'body' => 'modules/core/template/admin/defaultIndex.tpl'
		));
		include 'cfg.php';
		$this->objTPL->assign_var('MODULE', $mod_name);
		foreach($links as $l){
			$this->objTPL->assign_block_vars('view', array(
				'URL'       => $l['url'],
                'COLOR'     => ($counter%2==0 ? 'row_color1' : 'row_color2'),
				'COUNTER'   => $counter,

				'CATNAME'   => $l['name'],
			));

			if($counter != 0 && ($counter % $columns == 0)){
				$this->objTPL->assign_block_vars('view.rowSplitter', array());
			}
			$counter++;
		}
		$this->objTPL->parse('body', false);
    }

    public function configForum(){
        $this->objPage->addPagecrumb(array(
			array('url' => '/'.root().'admin/forum/config/', 'name' => langVar('L_CONFIG')),
        ));

		$this->objTPL->set_filenames(array(
			'body' => 'modules/core/template/panels/panel.settings.tpl'
		));

        $yn = array(1 => langVar('L_ENABLED'), 0 => langVar('L_DISABLED'));

        if(!HTTP_POST){
			$this->objForm->outputForm(array(
				'FORM_START' 	=> $this->objForm->start('panel', array('method' => 'POST', 'action' => '?save')),
				'FORM_END'	 	=> $this->objForm->finish(),

				'FORM_TITLE' 	=> langVar('L_CONFIG'),
				'FORM_SUBMIT'	=> $this->objForm->button('submit', 'Submit'),
				'FORM_RESET' 	=> $this->objForm->button('reset', 'Reset'),
			),
			array(
				'field' => array(
		            langVar('L_NEWS_CAT') => $this->objForum->buildJumpBox('news_category', $this->objForum->buildJumpBoxArray(), $this->config('forum', 'news_category'), false),
		            langVar('L_SORTABLES') => $this->objForm->radio('sortables', $yn, $this->config('forum', 'sortable_categories')),
				),
				'desc' => array(
		            langVar('L_NEWS_CAT') => langVar('L_NEWS_CAT_DESC'),
		            langVar('L_SORTABLES') => langVar('L_SORTABLES_DESC'),
				),
				'errors' => $_SESSION['site']['panel']['error'],
			),
			array(
				'header' => '<h4>%s</h4>',
				'dedicatedHeader' => true,
				'parseDesc' => true,
			));
       	}else{
            $update = array();

            $forum = $this->objForum->getForumInfo($_POST['news_category']);
			if(doArgs('news_category', false, $_POST)!=$this->config('forum', 'news_category') && $forum!==false){
				$update['news_category'] = $_POST['news_category'];
			}

			if(doArgs('sortables', false, $_POST)!=$this->config('forum', 'sortable_categories')){
				$update['sortable_categories'] = $_POST['sortables'];
			}

			//make sure we have somethign to update
			if(is_empty($update)){
                $this->objPage->redirect(str_replace('?save', '', $this->config('global', 'url')), 3);
    			hmsgDie('FAIL', langVar('L_NO_CHANGES'));
				break;
			}

            //run through and run the update routine
            $failed = array();
            foreach($update as $setting => $value){
                $update = $this->objSQL->updateRow('config', array('value' => $value), array('var = "%s"', $setting));
                if(is_empty($update)){
                    $failed[$setting] = $this->objSQL->error();
                }
            }

            //make sure the update went as planned
            if(!is_empty($failed) || count($failed)){
                $msg = null;
                foreach($failed as $setting => $error){
                    $msg .= $setting.': '.$error.'<br />';
                }
                $this->objPage->redirect(str_replace('?save', '', $this->config('global', 'url')), 3);
    			hmsgDie('FAIL', 'Error: Some settings were not saved.<br />'.$msg.'<br />Redirecting you back in 3 seconds.');
				$this->objTPL->parse('body', false); break;
            }
        	$this->objCache->regenerateCache('config');
            $this->objPage->redirect(str_replace('?save', '', $this->config('global', 'url')), 3);
    		hmsgDie('INFO', 'Successfully updated settings. Returning you to the panel.');
		}
		$this->objTPL->parse('body', false);
   	}

	public function categoryManagement(){
        $this->objPage->addPagecrumb(array(
			array('url' => '/'.root().'admin/forum/setup/', 'name' => langVar('L_CAT_MANAGE')),
        ));

        $this->objTPL->set_filenames(array(
        	'body' => 'modules/forum/template/admin/panel.category_management.tpl'
        ));

        $this->objTPL->assign_vars(array(
            'JB_TITLE'			    => langVar('L_CAT_MANAGE'),
            'JUMPBOX'               => $this->objForum->buildJumpBox('id', $this->objForum->buildJumpBoxArray()),
			'JB_FORM_START' 		=> $this->objForm->start('admin', array('method' => 'GET', 'action' => '/'.root().'admin/forum/setup/edit/')),
			'JB_FORM_END'			=> $this->objForm->finish(),
			'JB_EDIT'				=> $this->objForm->button('submit', langVar('L_EDIT'), array('name'=>'mode')),
			'JB_DELETE'				=> $this->objForm->button('submit', langVar('L_DELETE'), array('name'=>'mode')),

            'HID_INPUT'             => $this->objForm->inputbox('id', 'hidden', '0'),
			'ADD_FORM_START' 		=> $this->objForm->start('admin', array('method' => 'GET', 'action' => '/'.root().'admin/forum/setup/edit/')),
			'ADD_FORM_END'			=> $this->objForm->finish(),
			'ADD_SUBMIT'			=> $this->objForm->button('submit', langVar('L_NEW_CAT')),
		));

		$this->objTPL->parse('body', false);
	}

	public function categoryModify(){
		//grab the ID, if its set to 0 then we want to add a category
		$id = doArgs('id', -1, $_GET, 'is_number');
            if($id == -1){ hmsgDie('FAIL', 'Error: Invalid ID passed.'); }

		//grab the forum category
        if($id != 0){
            $cat = $this->objForum->getForumInfo($id);
                if(!$cat){ hmsgDie('FAIL', 'Error: Could not find category by ID'); }
        }else{
            $cat = array(
                'title' 		=> '',
                'parent_id' 	=> 0,
                'desc' 			=> '',
                'auth_view'		=> 0,
                'auth_read'		=> 0,
                'auth_post'		=> 0,
                'auth_reply'	=> 0,
                'auth_edit' 	=> 0,
                'auth_del' 		=> 0,
                'auth_move' 	=> 0,
                'auth_special'	=> 0,
                'auth_mod' 		=> 0,
            );
        }

        $this->objPage->setTitle(langVar($id!=0 ? 'L_EDIT_CAT' : 'L_ADD_CAT'));
        $this->objPage->addPagecrumb(array(
			array('url' => '/'.root().'admin/forum/setup/', 'name' => 'Category Management'),
			array('url' => $_url, 'name' => langVar($id!=0 ? 'L_EDIT_CAT' : 'L_ADD_CAT')),
        ));



	}

}

?>