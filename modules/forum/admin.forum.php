<?php
/*======================================================================*\
||              Cybershade CMS - Your CMS, Your Way                     ||
*======================================================================*/
if (!defined('INDEX_CHECK')) die("INDEX_CHECK not defined.");

class forum extends Module{
    
    function doAction($action){
        $this->objPage->addPagecrumb(array(
			array('url' => '/'.root().'admin/forum/', 'name' => 'Forum Administration'),
        ));

        if(preg_match('/auth/i', $action) || preg_match('/auth\/([0-9]*)/i', $action, $forumId)){
            $action = 'forumAuth';
        }
        
        if(preg_match('/group/i', $action) || preg_match('/group\/([0-9]*)/i', $action, $groupId)){
            $action = 'groupAuth';
        }
                
        if(preg_match('/setup\/edit\//i', $action)){ $action = 'modifyCat'; }
        if(preg_match('_setup_i', $action)){ $action = 'setup'; }
        if(preg_match('_postcounts_i', $action)){ $action = 'resync'; }
        if(preg_match('_config_i', $action)){ $action = 'config'; }
        
        
        
        switch($action){
            case 'forumAuth':
                $this->forumAuth(isset($forumId) ? $forumId[1] : 0);
            break;
            
            case 'groupAuth':
                $this->groupAuth(isset($groupId) ? $groupId[1] : 0);
            break;
            
            case 'setup':
                $this->setup();
            break;
            
            case 'modifyCat':
                $this->modifyCat();
            break;
            
            case 'resync':
                $this->resync();
            break;
            
            case 'config':
                $this->config();
            break;
            
            default:
                $this->showIndex();
            break;
        }
    }
    
    function showIndex(){
       $counter = 0; $columns = 3;
       $links = array( 
                       array('url'=>'/'.root().'admin/forum/config/',           'name' => 'Configuration'),
                       array('url'=>'/'.root().'admin/forum/setup/',            'name' => 'Category Management'),
                       array('url'=>'/'.root().'admin/forum/group/?mode=group', 'name' => 'Group Permissions'),
                       array('url'=>'/'.root().'admin/forum/group/?mode=user',  'name' => 'User Permissions'),
                       array('url'=>'/'.root().'admin/forum/postcounts/',       'name' => 'Resync Post Counts'),
                    );

        $this->objTPL->set_filenames(array(
        	'body' => 'modules/core/template/admin/defaultIndex.tpl'
        ));
        include 'cfg.php';
        $this->objTPL->assign_var('MODULE', $mod_name);
        foreach($links as $l){
            $this->objTPL->assign_block_vars('view', array(
                'URL'       => $l['url'],
                'MOAR'      => effHighlightRow($counter, $vars['row_color1']),
                'COLOR'     => $vars['row_color2'],
                'COUNTER'   => $counter,
                
                'CATNAME'   => $l['name'],
            ));
            
            if($counter != 0 && ($counter % $columns == 0)){
                $this->objTPL->assign_block_vars('view.rowTester', array());
            }
            $counter++;
        }
        $this->objTPL->pparse('body', false);
    }
    
    function config(){
        global $objCache;
        $this->objTPL->set_filenames(array(
	       'body'         => 'modules/core/template/panels/panel.settings.tpl',
        ));

        if(HTTP_POST){
            unset($update); //dont want anyone setting something in malicously before we get here..
            
            if(!HTTP_POST){
                $this->objPage->redirect($_url, 0, 3);
    			$this->objTPL->assign_block_vars('msg', array(
                    'MSG' => msg('FAIL', 'Error: Need to access this page via POST.', 'return'),
                ));
                $this->objTPL->pparse('body', false); return;
            }
            
            $yn = array(1, 0);
            
            $forums = $this->objSQL->getTable('SELECT * FROM '.$this->objSQL->prefix().'forum_cats');
                if(!$forums){
                    $this->objPage->redirect($_url, 0, 3);
        			$this->objTPL->assign_block_vars('msg', array(
                        'MSG' => msg('FAIL', 'Error: Could not obtain forum category list.', 'return'),
                    ));
                    $this->objTPL->pparse('body', false); return;
                }
            
            $cats = array();
            foreach($forums as $f){ $cats[] = $f['id']; }
            $settings['news_cat']       = array('forum', $cats);
        
            $settings['sortables']      = array('forum', $yn);
            $settings['quick_replys']   = array('site', $yn);
            //run through each of the select settings and make sure we have a valid selection
            foreach($settings as $setting => $val){
                $update[$setting] = (in_array($_POST[$setting], $val[1]) && $_POST[$setting]!=$this->objPage->getSetting($val[0], $setting) 
                                        ? $_POST[$setting] 
                                        : NULL);
            }

            //run through and run the update routine
            $failed = array();
            foreach($update as $setting => $value){
                if($value!==NULL){
                    $update = $this->objSQL->updateRow('config', array('value' => $value), 'var = "'.$setting.'"');
                    if($update===false || $update===NULL){
                        $failed[$setting] = $this->objSQL->error();
                    }
                } 
            }
    
            #echo dump($failed);
            if(!is_empty($failed) || count($failed)){
                $msg = NULL;
                foreach($failed as $setting => $error){
                    $msg .= $setting.': '.$error.'<br />';
                }
                $this->objPage->redirect($_url, 0, 3);
    			$this->objTPL->assign_block_vars('msg', array(
                    'MSG' => msg('FAIL', 'Error: Some settings wer not saved.<br />'.$msg.'<br />Redirecting you back in 3 seconds.', 'return'),
                )); break;
            }
        	$objCache->rmCache('config');
            $this->objPage->redirect($_url, 0, 2);
    		$this->objTPL->assign_block_vars('msg', array(
                'MSG' => msg('INFO', 'Successfully updated settings. Returning you to the panel.', 'return'),
            ));
        }else{
    		$this->objTPL->assign_vars(array(
                'ADMIN_MODE'			=> 'Forum Settings',
    			'FORM_START' 			=> $this->objForm->start('admin', 'POST', $_saveUrl),
    			'FORM_END'				=> $this->objForm->finish(),
    			
    			'SUBMIT'				=> $this->objForm->button('Save', 'submit'),
    			'RESET'					=> $this->objForm->button('Reset', 'reset'),
    		));
    
            $yn = array(1 => langVar('YES'), 0 => langVar('NO'));
            
            $this->objPage->autoLoadModule('forum', $objForum);
            
            $gName = 'Settings';                
                #$desc[$gName] = '';
            		$vars[$gName][] = array(
                        'NAME'      => 'News Category',
                        'SETTING'   => $objForum->fselect('news_cat', $objForum->buildJumpBox(), $this->objPage->getSetting('forum', 'news_cat'), false),
                        'DESC'      => 'Change this to whatever forum you want to feed News to the Homepage from. You can also use this as a Blog type thing too. It is also a good idea to make sure only MODs plus can create threads in this group.'
                    );

            		$vars[$gName][] = array(
                        'NAME'      => 'Forum Sortables',
                        'SETTING'   => $this->objForm->radio($yn, 'sortables', $this->objPage->getSetting('forum', 'sortables')),
                        'DESC'      => 'If enabled, users can drag and drop forum groups to better suit the ones they visit more often. '
                    );
                        
            		$vars[$gName][] = array(
                        'NAME'      => 'Quick Replies',
                        'SETTING'   => $this->objForm->radio($yn, 'quick_replys', $this->objPage->getSetting('forum', 'quick_replys')),
                        'DESC'      => NULL
                    );
                        

            $tplVars = $this->objPage->getVar('tplVars');
            foreach($vars as $name => $group){
    			$this->objTPL->assign_block_vars('group', array(
                    'NAME' => $name, 
                    'name' => strtolower($name),
                    'MSG'  => isset($desc[$name]) ? msg('INFO', secureMe($desc[$name], 'langVar'), 'return') : NULL,
                )); $i=0;
                foreach($group as $var){
        			$this->objTPL->assign_block_vars('group.settings', array(
        				'VALUE'				=> $var['NAME'],
        				'SETTING'			=> $var['SETTING'],
        				'DESC'			    => isset($var['DESC'])&&$var['DESC']!==NULL ? contentParse($var['DESC']) : NULL,
                        'ROW'               => ($i++%2 ? $tplVars['row_color2'] : $tplVars['row_color1']),
        			));
                }
            }
        }
        $this->objTPL->pparse('body', false);        
    }
    
    function resync(){
        $p = $this->objSQL->prefix();
        
		$sql = 'SELECT COUNT(p.id) AS postCount,u.id
                    FROM '.$this->objSQL->prefix().'users u
                    LEFT JOIN '.$p.'forum_posts p ON ( u.id = p.author )
                    GROUP BY u.id';
        $postCounts = $this->objSQL->getTable($sql);
		$sql = 'SELECT COUNT(t.id) as topicCount, u.id
        			FROM '.$this->objSQL->prefix().'users u
        			LEFT JOIN '.$p.'forum_threads t ON (u.id = t.author)
        			GROUP BY u.id';
        $topicCounts = $this->objSQL->getTable($sql);
        
        $userUpdate = array();
        foreach($postCounts as $pC){
            if($pC['postCount']!=0)
                $userUpdate[$pC['id']]['postcount'] = $pC['postCount'];
        }
        
        foreach($topicCounts as $tC){
            if($tC['topicCount']!=0)
                $userUpdate[$tC['id']]['topiccount'] = $tC['topicCount'];
        }

        $finished = array();
        foreach($userUpdate as $uid => $info){
            unset($update);
            $update['posts'] = isset($info['postcount']) ? $info['postcount'] : '0';
            $update['threads'] = isset($info['topiccount']) ? $info['topiccount'] : '0';
            $update['postcount'] = ($info['postcount']+$info['topiccount']);

            $up = $this->objSQL->updateRow('users', $update, 'id = '.$uid);

            if(mysql_affected_rows()===FALSE){
                $finished[] = $this->objUser->profile($uid).' : <font color="red">FAILED</font>'.'('.$update['postcount'].')';
            }else{
                $finished[] = $this->objUser->profile($uid).' : <font color="lime">OK</font>'.'('.$update['postcount'].')';
            }
            
        }
        $this->objPage->showHeader();
        echo 'Updating post counts:<br />';
        echo implode('<br />', $finished);
        $this->objPage->showFooter();
        exit;
    }
    
    function setup(){
        $this->objPage->addPagecrumb(array(
			array('url' => '/'.root().'admin/forum/setup/', 'name' => 'Category Management'),
        ));
        
        //load in the main module class, we need some functions outta there :)
        $this->objPage->autoLoadModule('forum', $objForum);
        
        $this->objTPL->set_filenames(array(
        	'body' => 'modules/forum/template/admin/panel.category_management.tpl'
        ));
        
        $this->objTPL->assign_vars(array(
            'JB_TITLE'			    => 'Forum Settings',
            'JUMPBOX'               => $objForum->fselect('id', $objForum->buildJumpBox()),
			'JB_FORM_START' 		=> $this->objForm->start('admin', 'GET', '/'.root().'admin/forum/setup/edit/'),
			'JB_FORM_END'			=> $this->objForm->finish(),
			'JB_SUBMIT'				=> $this->objForm->button('Edit', 'submit'),
            
            'HID_INPUT'             => $this->objForm->inputbox('hidden', '0', 'id'),
			'ADD_FORM_START' 		=> $this->objForm->start('admin', 'GET', '/'.root().'admin/forum/setup/edit/'),
			'ADD_FORM_END'			=> $this->objForm->finish(),
			'ADD_SUBMIT'			=> $this->objForm->button('Add New Category', 'submit'),
		));

        $this->objTPL->pparse('body', false);
    }

    function modifyCat(){
        $id = isset($_GET['id'])&&is_number($_GET['id']) ? $_GET['id'] : -1;
            if($id==-1){ hmsgDie('FAIL', 'Error: Invalid ID passed.'); }

        if($id!=0){
            $cat = $this->objSQL->getLine('SELECT * FROM '.$this->objSQL->prefix().'forum_cats WHERE id = '.$id.'');
                if(!$cat){ hmsgDie('FAIL', 'Error: Could not find category by ID'); }
        }else{
            $cat = array(
                'title'         => '', 
                'parentid'      => 0, 
                'desc'          => '', 
                'auth_view'     => 0, 
                'auth_read'     => 0, 
                'auth_post'     => 0, 
                'auth_reply'    => 0, 
                'auth_edit'     => 0, 
                'auth_del'      => 0, 
                'auth_move'     => 0, 
                'auth_special'  => 0, 
                'auth_mod'      => 0,
            );
        }

        $this->objPage->setTitle('Edit Category');
        $this->objPage->addPagecrumb(array(
			array('url' => '/'.root().'admin/forum/setup/', 'name' => 'Category Management'),
			array('url' => $_url, 'name' => langVar($id!=0 ? 'L_EDIT_CAT' : 'L_ADD_CAT')),
        ));

        //load the core forum module up
        $this->objPage->autoLoadModule('forum', $objForum);

        if(!HTTP_POST){
            $this->objPage->addJS('/'.root().'modules/forum/scripts/admin_catEdit.js');
            $this->objTPL->set_filenames(array(
            	'body' => 'modules/forum/template/admin/panel.edit_category.tpl'
            ));      

                $permList = array();
                $permList['0'] = 'Everyone';
                $permList['1'] = 'Registered Only';
                $permList['2'] = 'With Permission';
                $permList['3'] = 'Moderators Only';
                $permList['5'] = 'Admin Only';
                
                $field_names = array(
                    'auth_view'     => array('View',    'Determine whether it is visible on listings.'),
                    'auth_read'     => array('Read',    'Determine whether this categories contents are readable.'),
                    'auth_post'     => array('Post',    'Determine if this category can be posted to.'),
                    'auth_reply'    => array('Reply',   'Determine if the threads in this category can be replied to.'),
                    'auth_edit'     => array('Edit',    'Deternine if the threads in this category can be editable.'),
                    'auth_del'      => array('Delete',  'Deternine if the threads in this category can be deleted.'),
                    'auth_move'     => array('Move',    'Deternine if the threads in this category can be moved.'),
                    'auth_special'  => array('Special', 'Determine who has the ability to add special items(attachments, polls, etc) to a thread/post.'),
                    'auth_mod'      => array('Moderate','Determine who gets to moderate this category.')
                );

                $perms = NULL;$j =0;
                $extra = ' js="changeMe"';
                $img = '/'.root().'images/bbcode/help.png';
                foreach($cat as $k=>$v){
                    $match = preg_match('/auth_([a-zA-Z]*)/is', $k, $m);
                        if(!$match){ continue; }

                    $perms .= '<td><div class="float-left"><img src="'.$img.'" alt="'.$field_names[$m[0]][1].'" title="'.$field_names[$m[0]][1].'" />'.
                                $field_names[$m[0]][0].':</div>'.
                                '<div class="float-right">'.$this->objForm->select($m[0], $permList, $v, false, $extra).'</div></td>';
                    if($j++ == 4){ $j=0; $perms.='</tr><tr>'; }
                }
                
                //this var handles the quick permission select box, this determines 
                    //  View      Read          Post        Reply       Edit        Delete          Move      Special       Moderate
                $simple_auth_array = array(
                '01'=>'Change Me',
                
                    AUTH_ALL.','.AUTH_ALL.','.AUTH_ALL.','.AUTH_ALL.','.AUTH_REG.','.AUTH_REG.','.AUTH_MOD.','.AUTH_MOD.','.AUTH_MOD 
                        => 'Everyone',
                        
                    AUTH_ALL.','.AUTH_ALL.','.AUTH_REG.','.AUTH_REG.','.AUTH_REG.','.AUTH_REG.','.AUTH_MOD.','.AUTH_MOD.','.AUTH_MOD 
                        => 'Registered',
                    
                    AUTH_REG.','.AUTH_REG.','.AUTH_REG.','.AUTH_REG.','.AUTH_REG.','.AUTH_REG.','.AUTH_MOD.','.AUTH_MOD.','.AUTH_MOD 
                        => 'Registered [ Hidden ]',  
                                     
                    AUTH_ALL.','.AUTH_ACL.','.AUTH_ACL.','.AUTH_ACL.','.AUTH_ACL.','.AUTH_ACL.','.AUTH_MOD.','.AUTH_MOD.','.AUTH_MOD 
                        => 'With Permission',  
                                     
                    AUTH_ACL.','.AUTH_ACL.','.AUTH_ACL.','.AUTH_ACL.','.AUTH_ACL.','.AUTH_ACL.','.AUTH_MOD.','.AUTH_MOD.','.AUTH_MOD 
                        => 'With Permission [ Hidden ]',  
                                     
                    AUTH_ALL.','.AUTH_MOD.','.AUTH_MOD.','.AUTH_MOD.','.AUTH_MOD.','.AUTH_MOD.','.AUTH_MOD.','.AUTH_MOD.','.AUTH_MOD 
                        => 'Moderators',  
                                     
                    AUTH_MOD.','.AUTH_MOD.','.AUTH_MOD.','.AUTH_MOD.','.AUTH_MOD.','.AUTH_MOD.','.AUTH_MOD.','.AUTH_MOD.','.AUTH_MOD 
                        => 'Moderators [ Hidden ]',   
                
                '02'=>'---',
                
                    AUTH_ALL.','.AUTH_ALL.','.AUTH_MOD.','.AUTH_REG.','.AUTH_REG.','.AUTH_MOD.','.AUTH_MOD.','.AUTH_MOD.','.AUTH_MOD 
                        => 'News Category',

                );

                $this->objTPL->assign_vars(array(
        			'L_EDITING_CAT'     => langVar(($id!=0 ? 'L_EDIT_CAT' : 'L_ADD_CAT')),
        			'FORM_START' 	    => $this->objForm->start('admin', 'POST', '/'.root().'admin/forum/setup/edit/?action=save&id='.$id),
        			'FORM_END'		    => $this->objForm->finish(),

                    'L_CAT_NAME'        => 'Category Name',
                    'CAT_NAME'          => $this->objForm->inputbox('input', $cat['title'], 'title', array('extra'=>'style="width:99%"')),
                    
                    'L_CAT_DESC'        => 'Category Desc',
                    'CAT_DESC'          => $this->objForm->textarea($cat['desc'], 'desc', array('extra'=>'style="width:99%"','rows'=>'3')),
                    
                    'L_CAT_ATTACH'      => 'Attach Forum To',
                    'CAT_ATTACH'        => $objForum->fselect('parentid', $objForum->buildJumpBox(array('id'=>0,'title'=>'Master Group')), $cat['parentid']),
                    
                    'L_CAT_PERMS'       => 'Category Default Permissions',
                    'CAT_PERMS'         => $perms,
                    
                    'L_QUICK_PERMS'     => 'Quick Swap Perms',
                    'QUICK_PERMS'       => $this->objForm->select('quick_perms', $simple_auth_array, 0),

        			'SUBMIT'			=> $this->objForm->button('Save', 'submit'),
        			'RESET'			    => $this->objForm->button('Reset', 'reset'),
        		));
        
            $this->objTPL->pparse('body', false);            
        }else{

            
            $cats = $this->objSQL->getTable('SELECT id FROM '.$this->objSQL->prefix().'forum_cats');
                #if(!$cats){ hmsgDie('FAIL', 'Error: Could not request forum categories.'); }
            $catRange = array(0); //set a default of 0, for the new "Master Cat"
                if($cats){ foreach($cats as $cat){ $catRange[] = $cat['id']; } }
            
            $authRange = range(0,5);
            $needed = array(
                'title'         => 'string', 
                'parentid'      => $catRange, 
                'desc'          => 'string', 
                'auth_view'     => $authRange, 
                'auth_read'     => $authRange, 
                'auth_post'     => $authRange, 
                'auth_reply'    => $authRange, 
                'auth_edit'     => $authRange, 
                'auth_del'      => $authRange, 
                'auth_move'     => $authRange, 
                'auth_special'  => $authRange, 
                'auth_mod'      => $authRange,
            );
            
            unset($update);
            foreach($needed as $field => $vals){
                //if what we need aint there, just continue
                    if(!isset($_POST[$field])){ continue; }
                //now check if its not an array, then we want to check if its empty
                    if(!is_array($vals) && empty($_POST[$field])){ continue; }
                //its an array, so check if the value from the post, is in the acceptable array
                    if(is_array($vals) && !in_array($_POST[$field], $vals)){ continue; }
                
                $update[$field] = $_POST[$field];
            }

            if($id!=0){
                $update = $this->objSQL->updateRow('forum_cats', $update, 'id = '.$id, 0, 'Forum: Updated category - '.$update['title']);
                $this->objPage->redirect('/'.root().'admin/forum/setup/edit/?id='.$id, 0, 2);
                    if(!$update){ hmsgDie('FAIL', 'Error: Update Failed.'); }

                hmsgDie('INFO', 'Update Successful.');
            }else{
                $AI = $this->objSQL->getAI('forum_cats');
                $update = $this->objSQL->insertRow('forum_cats', $update, 0, 'Forum: Added new category - '.$update['title']);
                $this->objPage->redirect('/'.root().'admin/forum/setup/edit/?id='.$AI, 0, 2);
                    if(!$update){ hmsgDie('FAIL', 'Error: Adding new category Failed.'); }
                
                hmsgDie('INFO', 'New Category Added.');
            }
        }           
    }

    function forumAuth($id){
        
        $p = $this->objSQL->prefix();
        //                View      Read      Post      Reply     Edit     Delete     Move     Special
        $simple_auth_array = array(
        	0  => array(AUTH_ALL, AUTH_ALL, AUTH_ALL, AUTH_ALL, AUTH_REG, AUTH_REG, AUTH_MOD, AUTH_MOD),
        	1  => array(AUTH_ALL, AUTH_ALL, AUTH_REG, AUTH_REG, AUTH_REG, AUTH_REG, AUTH_MOD, AUTH_MOD),
        	2  => array(AUTH_REG, AUTH_REG, AUTH_REG, AUTH_REG, AUTH_REG, AUTH_REG, AUTH_MOD, AUTH_MOD),
        	3  => array(AUTH_ALL, AUTH_ACL, AUTH_ACL, AUTH_ACL, AUTH_ACL, AUTH_ACL, AUTH_MOD, AUTH_MOD),
        	4  => array(AUTH_ACL, AUTH_ACL, AUTH_ACL, AUTH_ACL, AUTH_ACL, AUTH_ACL, AUTH_MOD, AUTH_MOD),
        	5  => array(AUTH_ALL, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD),
        	6  => array(AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD),
        );

        $simple_auth_types = array(
                                    'Everyone', 
                                    'Registered',       'Registered [ Hidden ]',
                                    'With Permission',  'With Permission [ Hidden ]',
                                    'Moderators',       'Moderators [ Hidden ]'
                                   );
                                   
        $forum_auth_fields = array('auth_view', 'auth_read', 'auth_post', 'auth_reply', 'auth_edit', 'auth_del', 'auth_move', 'auth_special');
        
        $field_names = array(
                                'auth_view'     => 'View',
                                'auth_read'     => 'Read',
                                'auth_post'     => 'Post',
                                'auth_reply'    => 'Reply',
                                'auth_edit'     => 'Edit',
                                'auth_del'      => 'Delete',
                                'auth_move'     => 'Move',
                                'auth_special'  => 'Special'
                            );
        $forum_auth_levels =    array( 'ALL',    'REG',  'PRIVATE',  'MOD',    'ADMIN');
        $forum_auth_const  =    array(AUTH_ALL, AUTH_REG, AUTH_ACL, AUTH_MOD, AUTH_ADMIN);

        if(!isset($_GET['f']) && !isset($_POST['f'])){
        	$forum_sql = '';
       	}else{
        	$forum_id = isset($_POST['f']) ? (int)$_POST['f'] : (int)$_GET['f'];
        	$forum_sql = 'WHERE id = '.$forum_id;
       	}

        $adv = isset($_GET['adv']) ? intval($_GET['adv']) : false;
        
        $lang['Forum_ALL']      = 'Everyone';
        $lang['Forum_REG']      = 'Registered Only';
        $lang['Forum_PRIVATE']  = 'With Permission';
        $lang['Forum_MOD']      = 'Moderators Only';
        $lang['Forum_ADMIN']    = 'Admin Only';
        
        $lang['View']   = 'View';
        $lang['Read']   = 'Read';
        $lang['Post']   = 'Post';
        $lang['Reply']  = 'Reply';
        $lang['Edit']   = 'Edit';
        $lang['Delete'] = 'Delete';

        if(isset($_POST['submit'])){
        	$sql = '';
        
        	if(!empty($forum_id)){
                if(isset($_POST['simpleauth'])){
                    $simple_array = $simple_auth_array[intval($_POST['simpleauth'])];
                    
                    for($i = 0; $i < count($simple_array); $i++){
                        $sql .= (($sql != '') ? ', ' : '').$forum_auth_fields[$i].' = '.$simple_array[$i];
                    }
                    
                    if(is_array($simple_array)){
                        $sql = 'UPDATE '.$p.'forum_cats SET '.$sql.' WHERE id = '.$forum_id;
                    }
                }else{                
                    for($i = 0; $i < count($forum_auth_fields); $i++){
                        $value = intval($_POST[$forum_auth_fields[$i]]);
                        if($forum_auth_fields[$i] == 'auth_vote'){
                            if($_POST['auth_vote'] == AUTH_ALL){
                                $value = AUTH_REG;
                            }
                        }
                    
                        $sql .= (($sql != '') ? ', ' : '').$forum_auth_fields[$i].' = '.$value;
                    }
                    
                    $sql = 'UPDATE '.$p.'forum_cats SET '.$sql.' WHERE id = '.$forum_id;
                }
                
        		if($sql != ''){
        			if(!$this->objSQL->query($sql)){
                        hmsgDie('FAIL', 'Error: Could not update auth table');
        			}
        		}
        
        		$forum_sql = '';
        		$adv = 0;
        	}
            
            hmsgDie('INFO', 'Forum permissions updated');
        }//end of submit
        
        //
        // Get required information, either all forums if
        // no id was specified or just the requsted if it
        // was
        //
        $forum_rows = $this->objSQL->getTable("SELECT * FROM ".$p."forum_cats $forum_sql");
        $this->objSQL->freeResult($forum_rows);


        if(!$forum_id){
        	$this->objTPL->set_filenames(array(
        		'body' => 'modules/forum/template/admin/auth_select_body.tpl'
            ));
            
            //load in the main module class, we need some functions outta there :)
            $this->objPage->autoLoadModule('forum', $objForum);
    	
        	$this->objTPL->assign_vars(array(
        		'L_AUTH_TITLE'        => 'Forum Permissions Control',
        		'L_AUTH_EXPLAIN'      => 'Here you can alter the authorisation levels of each forum. You will have both a simple and advanced method for doing this, where advanced offers greater control of each forum operation. Remember that changing the permission level of forums will affect which users can carry out the various operations within them.',
        		'L_AUTH_SELECT'       => 'Select a Forum',
        		'L_LOOK_UP'           => 'Look up Forum',
        
        		'S_AUTH_ACTION'       => '/'.root().'admin/forum/auth/',
        		'S_AUTH_SELECT'       => $objForum->fselect('f', $objForum->buildJumpBox())
        	));

        }else{
        	//
        	// Output the authorisation details if an id was
        	// specified
        	//
        	$this->objTPL->set_filenames(array(
        		'body' => 'modules/forum/template/admin/auth_forum_body.tpl'
            ));
        
        	$forum_name = $forum_rows[0]['title'];
        
        	@reset($simple_auth_array);
        	while(list($key, $auth_levels) = each($simple_auth_array)){
        		$matched = 1;
        		for($k = 0; $k < count($auth_levels); $k++){
        			$matched_type = $key;
        
        			if ($forum_rows[0][$forum_auth_fields[$k]] != $auth_levels[$k]){
        				$matched = 0;
        			}
        		}
        
        		if($matched){ break; }
        	}
        
        	//
        	// If we didn't get a match above then we
        	// automatically switch into 'advanced' mode
        	//
        	if(!isset($adv) && !$matched)
        		$adv = 1;
        
        	$s_column_span == 0;
        
        	if(empty($adv)){

            		$simple_auth = '<select name="simpleauth">';
            		for($j = 0; $j < count($simple_auth_types); $j++){
            			$selected = ( $matched_type == $j ) ? ' selected="selected"' : '';
            			$simple_auth .= '<option value="' . $j . '"' . $selected . '>' . $simple_auth_types[$j] . '</option>';
            		}
            		$simple_auth .= '</select>';
                
        		$this->objTPL->assign_block_vars('forum_auth_titles', array(
        			'CELL_TITLE' => 'Simple mode'
                ));
        		$this->objTPL->assign_block_vars('forum_auth_data', array(
        			'S_AUTH_LEVELS_SELECT' => $simple_auth
                ));
        
        		$s_column_span++;
        		
        	}else{
        	   
        		//
        		// Output values of individual
        		// fields
        		//
        		for($j = 0; $j < count($forum_auth_fields); $j++){
        		  
        			$custom_auth[$j] = '&nbsp;<select name="' . $forum_auth_fields[$j] . '">';
        
        			for($k = 0; $k < count($forum_auth_levels); $k++)
        			{
        				$selected = ( $forum_rows[0][$forum_auth_fields[$j]] == $forum_auth_const[$k] ) ? ' selected="selected"' : '';
        				$custom_auth[$j] .= '<option value="' . $forum_auth_const[$k] . '"' . $selected . '>' . $lang['Forum_' . $forum_auth_levels[$k]] . '</option>';
        			}
        			$custom_auth[$j] .= '</select>&nbsp;';
        
        			$cell_title = $field_names[$forum_auth_fields[$j]];
        
        			$this->objTPL->assign_block_vars('forum_auth_titles', array(
        				'CELL_TITLE' => $cell_title
                    ));
        			$this->objTPL->assign_block_vars('forum_auth_data', array(
        				'S_AUTH_LEVELS_SELECT' => $custom_auth[$j]
                    ));
        
        			$s_column_span++;
        		}
        	}
        
        	$adv_mode = empty($adv) ? '1' : '0';
        	$switch_mode = '?adv='. $adv_mode.'&f='.$forum_id;
        	$switch_mode_text = empty($adv) ? 'Advanced mode' : 'Simple mode';
        	$u_switch_mode = '<a href="' . $switch_mode . '">' . $switch_mode_text . '</a>';
        
        	$s_hidden_fields = '<input type="hidden" name="f" value="' . $forum_id . '">';
        
        	$this->objTPL->assign_vars(array(
        		'FORUM_NAME' => $forum_name,
        
        		'L_FORUM' => 'Forum', 
        		'L_AUTH_TITLE' => 'Forum Permissions Control',
        		'L_AUTH_EXPLAIN' => 'Here you can alter the authorisation levels of each forum. You will have both a simple and advanced method for doing this, where advanced offers greater control of each forum operation. Remember that changing the permission level of forums will affect which users can carry out the various operations within them.',
        		'L_SUBMIT' => 'Submit',
        		'L_RESET' => 'Reset',
        
        		'U_SWITCH_MODE' => $u_switch_mode,
        
        		'S_FORUMAUTH_ACTION' => '/'.root().'admin/forum/auth/',
        		'S_COLUMN_SPAN' => $s_column_span,
        		'S_HIDDEN_FIELDS' => $s_hidden_fields
        	));
        

        }
        
        $this->objTPL->pparse('body', false);
    }
    
    function groupAuth($id){
        $params = array('mode' => 'mode', 'user_id' => 'uid', 'group_id' => 'gid', 'adv' => 'adv');
        
        while(list($var, $param) = @each($params)){
    		$$var = '';
        	if(!empty($_POST[$param]) || !empty($_GET[$param])){
        		$$var = (!empty($_POST[$param])) ? $_POST[$param] : $_GET[$param];
        	}
        }
        $user_id = intval($user_id);
        $group_id = intval($group_id);
        $adv = intval($adv);
        $mode = is_empty($mode) || $mode!='user' ? 'group' : 'user';
        $p = $this->objSQL->prefix();

        $forum_auth_fields = array('auth_view', 'auth_read', 'auth_post', 'auth_reply', 'auth_edit', 'auth_del', 'auth_move', 'auth_special');
        
        $auth_field_match = array(
        	'auth_view'    => AUTH_VIEW,
        	'auth_read'    => AUTH_READ,
        	'auth_post'    => AUTH_POST,
        	'auth_reply'   => AUTH_REPLY,
        	'auth_edit'    => AUTH_EDIT,
        	'auth_del'     => AUTH_DELETE,
        	'auth_move'    => AUTH_MOVE,
        	'auth_special' => AUTH_SPECIAL
        );
        
        $field_names = array(
        	'auth_view'    => 'View',
        	'auth_read'    => 'Read',
        	'auth_post'    => 'Post',
        	'auth_reply'   => 'Reply',
        	'auth_edit'    => 'Edit',
        	'auth_del'     => 'Delete',
        	'auth_move'    => 'Move',
        	'auth_special' => 'Special'
        );
        
        if(isset($_POST['submit']) && (($mode == 'user' && $user_id) || ($mode == 'group' && $group_id))){
            $user_level = '';
            //right so lets find out which group there in
            if($mode == 'user'){
                //so try it a first time..
                $query = $this->objSQL->getLine('SELECT g.id, u.userlevel
                                                 FROM '.$this->objSQL->prefix().'group_subs ug, '.$this->objSQL->prefix().'users u, '.$this->objSQL->prefix().'groups g
                                                 WHERE u.id = '.$user_id.'
                                                     AND ug.uid = u.id
                                                     AND g.id = ug.gid
                                                     AND g.single_user_group = 1');

                //if no luck..
                if(!$query){
                    //insert a new personal group into the db..
                    unset($insert);
                    $insert['name'] = '';
                    $insert['description'] = 'Personal User';
                    $insert['single_user_group'] = '1';
                    $insert['moderator'] = $user_id;
                    $insert['color'] = '';
                    $insert['order'] = '99999';

                    $gid = $this->objSQL->insertRow('groups', $insert);
                    
                    if(!$gid){ hmsgDie('FAIL', 'Error: Could not add new group.'); }
                    
                    unset($insert);
                    $insert['uid'] = $user_id;
                    $insert['gid'] = $gid;
                    $insert['pending'] = 0;
                    
                    $insert = $this->objSQL->insertRow('group_subs', $insert);
                        if(!mysql_affected_rows()){ hmsgDie('FAIL', 'Error: Could not subscribe user to group.'); }

                    //so try it a 2nd time..
                    $query = $this->objSQL->getLine('SELECT g.id, u.userlevel
                                                     FROM '.$this->objSQL->prefix().'group_subs ug, '.$this->objSQL->prefix().'users u, '.$this->objSQL->prefix().'groups g
                                                     WHERE u.id = '.$user_id.'
                                                         AND ug.uid = u.id
                                                         AND g.id = ug.gid
                                                         AND g.single_user_group = 1');

                        if(!$query){ hmsgDie('FAIL', 'Error: Could not select info from user/user_group table'); }
                }

                    
        		$group_id = $query['id'];
        		$user_level = $query['userlevel'];
        		
        		$this->objSQL->freeResult($query);
            }
            
            //and now lets do some stuff
            if($mode == 'user' && $_POST['userlevel'] == 'admin' && $user_level != ADMIN){

        		// Make user an admin (if already user)
        		if($this->objUser->grab('id') != $user_id){
                    unset($update);
                    $update['userlevel'] = ADMIN;
                    
                    $update = $this->objSQL->updateRow('users', $update, 'id = '.$user_id);
                        if($update===NULL){ hmsgDie('FAIL', 'Error: Could not update the user group'); }

                    $del = $this->objSQL->deleteRow('forum_auth', 'group_id = '.$group_id.' AND auth_mod = 0');
                        if($del===NULL){ hmsgDie('FAIL', 'Error: Could not delete the auth info'); }
                        
        			// Delete any entries in forum_auth, they are not required if user is becoming an admin
                    unset($update);
                    $update['auth_view']        = '0';
                    $update['auth_read']        = '0';
                    $update['auth_post']        = '0';
                    $update['auth_reply']       = '0';                    
                    $update['auth_del']         = '0';
                    $update['auth_move']        = '0';
                    $update['auth_special']     = '0';

                    $update = $this->objSQL->updateRow('forum_auth', $update, 'group_id = '.$group_id);
                        if($update===NULL){ hmsgDie('FAIL', 'Error: Could not update auth access'); }
        		}
        		
        		hmsgDie('INFO', 'Users permissions have been updated.'.
                                'Click <a href="/'.root().'admin/forum/group/?mode='.$mode.'">here</a> to return.');
            }else{
        		if($mode == 'user' && $_POST['userlevel'] == 'user' && $user_level == ADMIN){
        			// Make admin a user (if already admin) ... ignore if you're trying to change yourself from an admin to user!
        			if($this->objUser->grab('id') != $user_id){
                        unset($update);
                        $update['auth_view']        = '0';
                        $update['auth_read']        = '0';
                        $update['auth_post']        = '0';
                        $update['auth_reply']       = '0';                    
                        $update['auth_del']         = '0';
                        $update['auth_move']        = '0';
                        $update['auth_special']     = '0';

                        $update = $this->objSQL->updateRow('forum_auth', $update, 'group_id = '.$group_id);
                            if(!$update){ hmsgDie('FAIL', 'Error: Could not update auth access'); }

        				// Update users level, reset to USER
                        unset($update);
                        $update['userlevel'] = USER;
                        
                        $update = $this->objSQL->updateRow('users', $update, 'id = '.$user_id);
                            if(!$update){ hmsgDie('FAIL', 'Error: Could not update the user group'); }
                    }
                    
            		$message = 'Users permissions have been updated.'.
                                    'Click <a href="/'.root().'admin/forum/group/">here</a> to return.';
        		}else{
                    
                    $change_mod_list = isset($_POST['moderator']) ? $_POST['moderator'] : false;
                    
        			if(empty($adv)){
        				$change_acl_list = isset($_POST['private']) ? $_POST['private'] : false;
        			}else{
        				$change_acl_list = array();
        				$jcount = count($forum_auth_fields);
        				for($j = 0; $j < $jcount; $j++){
        					$auth_field = $forum_auth_fields[$j];
        					while(list($fid, $value) = @each($_POST['private_'.$auth_field])){
        						$change_acl_list[$fid][$auth_field] = $value;
        					}
        				}
        			}

                    $query = $this->objSQL->getTable('SELECT * FROM '.$p.'forum_cats WHERE parentid <> 0 ORDER BY `order`');
                        if($query===NULL){ hmsgDie('FAIL', 'Error: Couldnt get forum list.'); }
                            
                    
                    $forum_access = array();
                    foreach($query as $row){ $forum_access[] = $row; }
                    $this->objSQL->freeResult($query);
                    
                    $query = $this->objSQL->getTable(($mode=='user') ? 
                            'SELECT aa.* FROM '.$p.'forum_auth aa, '.$this->objSQL->prefix().'group_subs ug, '.$this->objSQL->prefix().'groups g
                                                     WHERE ug.uid = '.$user_id.'
                                                         AND g.id = ug.gid
                                                         AND aa.group_id = ug.gid
                                                         AND g.single_user_group = 1' :
                            
                            'SELECT * FROM '.$p.'forum_auth WHERE group_id = '.$group_id);
                    
                        if($query===NULL){ hmsgDie('FAIL', 'Error: Could not get user/group permissions'); }

        			$auth_access = array();
        			foreach($query as $row){ $auth_access[$row['cat_id']] = $row; }
                    $this->objSQL->freeResult($query);
                    
        			$forum_auth_action = array();
        			$update_acl_status = array();
        			$update_mod_status = array();
                    
                    $icount = count($forum_access);
        			for($i = 0; $i < $icount; $i++){
        				$fid = $forum_access[$i]['id'];
        				if(
                            (isset($auth_access[$fid]['auth_mod']) && $change_mod_list[$fid]['auth_mod'] != $auth_access[$fid]['auth_mod']) || 
                            (!isset($auth_access[$fid]['auth_mod']) && !empty($change_mod_list[$fid]['auth_mod'])) 
                          ){
            					$update_mod_status[$fid] = $change_mod_list[$fid]['auth_mod'];
            					
            					if(!$update_mod_status[$fid]){
            						$forum_auth_action[$fid] = 'delete';
            					}elseif (!isset($auth_access[$fid]['auth_mod'])){
            						$forum_auth_action[$fid] = 'insert';
            					}else{
            						$forum_auth_action[$fid] = 'update';
            					}
        				}

        				$jcount = count($forum_auth_fields);
        				for($j = 0; $j < $jcount; $j++){
        					$auth_field = $forum_auth_fields[$j];
        
        					if($forum_access[$i][$auth_field] == AUTH_ACL && isset($change_acl_list[$fid][$auth_field])){
        						if((empty($auth_access[$fid]['auth_mod']) && 
        							(isset($auth_access[$fid][$auth_field]) && $change_acl_list[$fid][$auth_field] != $auth_access[$fid][$auth_field]) || 
        							(!isset($auth_access[$fid][$auth_field]) && !empty($change_acl_list[$fid][$auth_field]))) ||
        							!empty($update_mod_status[$fid])
        						){
        							$update_acl_status[$fid][$auth_field] = (!empty($update_mod_status[$fid])) ? 0 : $change_acl_list[$fid][$auth_field];
        
        							if(isset($auth_access[$fid][$auth_field]) && empty($update_acl_status[$fid][$auth_field]) && 
                                            $forum_auth_action[$fid] != 'insert' && $forum_auth_action[$fid] != 'update'){
                                                
        								$forum_auth_action[$fid] = 'delete';
            								
        							}else if(!isset($auth_access[$fid][$auth_field]) && !($forum_auth_action[$fid] == 'delete' && 
                                                empty($update_acl_status[$fid][$auth_field]))){
                                                
        								$forum_auth_action[$fid] = 'insert';
                								
        							}else if(isset($auth_access[$fid][$auth_field]) && !empty($update_acl_status[$fid][$auth_field])){
        								$forum_auth_action[$fid] = 'update';
        							}
        							
        						}else if((empty($auth_access[$fid]['auth_mod']) && (isset($auth_access[$fid][$auth_field]) && 
                                            $change_acl_list[$fid][$auth_field] == $auth_access[$fid][$auth_field])) &&
                                            $forum_auth_action[$fid] == 'delete'){
                                                
            							$forum_auth_action[$fid] = 'update';
            							
        						}
        					}
        				}//for
        			}
        			
        			// Checks complete, make updates to DB
        			$delete_sql = '';
        			while(list($forum_id, $action) = @each($forum_auth_action)){
        				if($action == 'delete'){
        					$delete_sql .= (($delete_sql != '') ? ', ' : '').$forum_id;
        				}else{
        					if($action == 'insert'){
        						$sql_field = ''; $sql_value = '';
                                if(!empty($update_acl_status[$forum_id])){
            						while(list($auth_type, $value) = @each($update_acl_status[$forum_id])){
            							$sql_field .= (($sql_field != '') ? ', ' : '').$auth_type;
            							$sql_value .= (($sql_value != '') ? ', ' : '').$value;
            						}
        						}
        						$sql_field .= (($sql_field != '') ? ', ' : '').'auth_mod';
        						$sql_value .= (($sql_value != '') ? ', ' : '').((!isset($update_mod_status[$forum_id])) ? 0 : $update_mod_status[$forum_id]);
        						
        						$sql = 'INSERT INTO '.$p.'forum_auth (cat_id,         group_id,        '.$sql_field.') 
                                							  VALUES ('.$forum_id.',  '.$group_id.',   '.$sql_value.')';
                			}else{
        						$sql_values = '';
                                if(!empty($update_acl_status[$forum_id])){
            						while(list($auth_type, $value) = @each($update_acl_status[$forum_id])){
            							$sql_values .= (($sql_values != '') ? ', ' : '').$auth_type.' = '.$value;
            						}
        						}
        						$sql_values .= (($sql_values != '') ? ', ' : '').'auth_mod = '.
                                                ((!isset($update_mod_status[$forum_id])) ? 0 : $update_mod_status[$forum_id]);
        
        						$sql = 'UPDATE '.$p.'forum_auth
            							SET '.$sql_values.' 
            							WHERE group_id = '.$group_id.' 
            								AND cat_id = '.$forum_id;
                			}
                			
                			$query = $this->objSQL->query($sql);
                			
                			if(!$query)
                			     hmsgDie('FAIL', 'Could not update private forum permissions');
                			     
                		}
                	}
                	
        			if($delete_sql != ''){
        			    $delete = $this->objSQL->deleteRow('forum_auth', 'group_id = '.$group_id.' AND cat_id IN ('.$delete_sql.')');
        			}
        			
            		$message = ('Forum permissions have been updated.'.
                                    'Click <a href="/'.root().'admin/forum/group/?mode='.$mode.'">here</a> to return.');
        		}//$mode == 'user' && $_POST['userlevel'] == 'user' && IS_ADMIN
        		
        		// Update user level to mod for appropriate users
        		$query = $this->objSQL->getTable('SELECT u.id 
                                                FROM '.$p.'forum_auth aa, '.$this->objSQL->prefix().'users u, '.$this->objSQL->prefix().'group_subs ug
                                                WHERE ug.gid = aa.group_id
                                                    AND u.id = ug.uid
                                                    AND ug.pending = 0
                                                    AND u.userlevel NOT IN ('.MOD.', '.ADMIN.')
                                                GROUP BY u.id
                                                HAVING SUM(aa.auth_mod) > 0');
                    
                    if($query===NULL){ hmsgDie('FAIL', 'Error: Cant obtain user/group permissions'); }
                        
        		$set_mod = '';
        		if($query){ foreach($query as $row){ $set_mod .= (($set_mod != '') ? ', ' : '').$row['id']; } }
        		$this->objSQL->freeResult($query);

        		// Update user level to user for appropriate users
        		$query = $this->objSQL->getTable('SELECT u.id 
                    FROM ( ( '.$this->objSQL->prefix().'users u
                    LEFT JOIN '.$this->objSQL->prefix().'group_subs ug ON ug.uid = u.id )
					LEFT JOIN '.$p.'forum_auth aa ON aa.group_id = ug.gid ) 
					WHERE u.userlevel NOT IN ('.USER.', '.ADMIN.')
					GROUP BY u.id 
					HAVING SUM(aa.auth_mod) = 0');
                
                    if($query===NULL){ hmsgDie('FAIL', 'Error: Cant obtain user/group permissions'); }
                    
        		$unset_mod = '';
        		if($query)	foreach($query as $row){  $unset_mod .= (($unset_mod != '') ? ', ' : '').$row['id'];  }
        		$this->objSQL->freeResult($query);

        		if($set_mod != ''){
        		    unset($update);
        		    $update['userlevel'] = MOD;
                    
                    $update = $this->objSQL->updateRow('users', $update, 'id IN ('.$set_mod.')');        		  
                    
                        if($update===NULL){ hmsgDie('FAIL', 'Error: Could not update users levels'); }
        		}
        		
        		if($unset_mod != ''){
        		    unset($update);
        		    $update['userlevel'] = USER;
                    
                    $update = $this->objSQL->updateRow('users', $update, 'id IN ('.$unset_mod.')');        		  
                    
                        if($update===NULL){ hmsgDie('FAIL', 'Error: Could not update users levels'); }
        		}

                $query = $this->objSQL->getTable('SELECT uid FROM '.$this->objSQL->prefix().'group_subs WHERE gid = '.$group_id);
                    if(!$query){ hmsgDie('INFO', 'Error: There appears to be no-one in this group.'); }
        		$group_user = array();
            	foreach($query as $row){ $group_user[$row['uid']] = $row['uid']; }
        		$this->objSQL->freeResult($query);


                $query = $this->objSQL->getTable('SELECT ug.uid, COUNT(auth_mod) AS is_auth_mod 
                                                    FROM '.$p.'forum_auth aa, '.$this->objSQL->prefix().'group_subs ug
                                                    WHERE ug.uid IN ('.implode(', ', $group_user).') 
                                                        AND aa.group_id = ug.gid
                                                        AND aa.auth_mod = 1
                                                    GROUP BY ug.uid');
                                                
                    if($query===NULL){ hmsgDie('FAIL', 'Error: Could not get moderator status'); }
        			
        		foreach($query as $row){
        			if ($row['is_auth_mod']){
        				unset($group_user[$row['uid']]);
                    }
        		}
        		$this->objSQL->freeResult($query);

        		if(count($group_user)){
        		    unset($update);
        		    $update['userlevel'] = USER;
                    
                    $update = $this->objSQL->updateRow('users', $update, 'id IN ('.implode(', ', $group_user).') AND userlevel = '.MOD);        		  
                    
                        if($update===NULL){ hmsgDie('FAIL', 'Error: Could not update users levels'); }
        		}

        		hmsgDie('INFO', $message);
            }
        }elseif (($mode == 'user' && (isset($_POST['username']) || $user_id)) || ($mode == 'group' && $group_id)){
            if(isset($_POST['username'])){
                $query = $this->objSQL->getValue('users', 'id', 'username = \''. $this->objSQL->escape($_POST['username']).'\'');
                    if(!$query){ hmsgDie('FAIL', 'Error: User dosent exist'); }

        		$user_id = $query;
            }
            
            $query = $this->objSQL->getTable('SELECT * FROM '.$p.'forum_cats WHERE parentid <> 0 ORDER BY `order`, parentid');
                if(!$query)
                    hmsgDie('FAIL', 'Error: Couldnt get forum list.');
                    
            $forum_access = array();
            if($query)  foreach($query as $row){ $forum_access[] = $row; }
            $this->objSQL->freeResult($query);

        	if(empty($adv)){
                $iCount = count($forum_access);
        		for($i = 0; $i < $iCount; $i++){
        			$forum_id = $forum_access[$i]['id'];
        
        			$forum_auth_level[$forum_id] = AUTH_ALL;
        			$jCount = count($forum_auth_fields);
        			for($j = 0; $j < $jCount; $j++){
        				$forum_access[$i][$forum_auth_fields[$j]].' :: ';
        				if($forum_access[$i][$forum_auth_fields[$j]] == AUTH_ACL){
        					$forum_auth_level[$forum_id] = AUTH_ACL;
        					$forum_auth_level_fields[$forum_id][] = $forum_auth_fields[$j];
        				}
        			}
        		}
        	}



        	$query = $this->objSQL->getTable('SELECT u.id, u.username, u.userlevel, g.id as gid, g.name, g.single_user_group, ug.pending 
                                              FROM '.$this->objSQL->prefix().'users u, '.$this->objSQL->prefix().'groups g, '.$this->objSQL->prefix().'group_subs ug WHERE ' .
                                	          ($mode == 'user' ?  'u.id = '.$user_id.' AND ug.uid = u.id AND g.id = ug.gid' : 
                                                                  'g.id = '.$group_id.' AND ug.gid = g.id AND u.id = ug.uid'));

                if($query===NULL){ hmsgDie('FAIL', 'Error: Couldnt not gain user/group information'); }
            
        	$ug_info = array();
        	if($query){ foreach($query as $row){ $ug_info[] = $row; } }
    		$this->objSQL->freeResult($query);

        	$query = $this->objSQL->getTable(($mode == 'user') ? 'SELECT aa.*, g.single_user_group 
                                                                  FROM '.$p.'forum_auth aa, '.$this->objSQL->prefix().'groups g, '.$this->objSQL->prefix().'group_subs ug 
                                                                  WHERE ug.uid = '.$user_id.' 
                                                                      AND g.id = ug.gid 
                                                                      AND aa.group_id = ug.gid 
                                                                      AND g.single_user_group = 1' : 
                                                                 'SELECT * FROM '.$p.'forum_auth WHERE group_id = '.$group_id);

                if($query===NULL){ hmsgDie('FAIL', 'Error: Couldnt not gain user/group permissions'); }
                    
        	$auth_access = array();
        	$auth_access_count = array();
        	foreach($query as $row){
        		$auth_access[$row['cat_id']][] = $row;
        		$auth_access_count[$row['cat_id']]++;
        	}
    		$this->objSQL->freeResult($query);

        	$is_admin = ($mode == 'user') ? (($ug_info[0]['userlevel'] == ADMIN && $ug_info[0]['uid'] != GUEST) ? 1 : 0) : 0;

            $icount = count($forum_access);
        	for($i = 0; $i < $icount; $i++){
        		$fid = $forum_access[$i]['id'];

        		unset($prev_acl_setting);
                $jcount = count($forum_auth_fields);
        		for($j = 0; $j < $jcount; $j++){
        			$key = $forum_auth_fields[$j];
        			$value = $forum_access[$i][$key];
        			switch($value){
        				case AUTH_ALL:
        				case AUTH_REG: 
                            $auth_ug[$fid][$key] = 1; 
                        break;
                        
        				case AUTH_ACL:
        					$auth_ug[$fid][$key] = (!empty($auth_access_count[$fid])) ? 
                                                    $this->objUser->auth_check_user(AUTH_ACL, $key, $auth_access[$fid], $is_admin) : 0;
                                                    
        					$auth_field_acl[$fid][$key] = $auth_ug[$fid][$key];
        					if(isset($prev_acl_setting)){
        						if($prev_acl_setting != $auth_ug[$fid][$key] && empty($adv))
        							$adv = 1;
        					}
        					$prev_acl_setting = $auth_ug[$fid][$key];
    					break;
    					
        				case AUTH_MOD:
        					$auth_ug[$fid][$key] = (!empty($auth_access_count[$fid])) ? $this->objUser->auth_check_user(AUTH_MOD, $key, $auth_access[$fid], $is_admin) : 0;
    					break;
    					
        				case AUTH_ADMIN: 
                            $auth_ug[$fid][$key] = $is_admin; 
                        break;
                        
        				default: 
                            $auth_ug[$fid][$key] = 0; 
                        break;
        			}
        		}
        
        		// Is user a moderator?
        		$auth_ug[$fid]['auth_mod'] = (!empty($auth_access_count[$fid])) ? $this->objUser->auth_check_user(AUTH_MOD, 'auth_mod', $auth_access[$fid], 0) : 0;
        	}

        	$i = 0;
        	@reset($auth_ug);
        	while(list($fid, $user_ary) = @each($auth_ug)){
        		if(empty($adv)){
        			if($forum_auth_level[$fid] == AUTH_ACL){
        				$allowed = 1;
                        $jcount = count($forum_auth_level_fields[$fid]);
        				for($j = 0; $j < $jcount; $j++){
        					if(!$auth_ug[$fid][$forum_auth_level_fields[$fid][$j]])
                                $allowed = 0;
        				}

        				$optionslist_acl = array();
    				    $optionlist_selected = 0;
        				if($is_admin || $user_ary['auth_mod']){
        				    $optionlist_acl = array(1 => 'Allowed Access');
        				}elseif($allowed){
        				    $optionlist_acl = array(1 => 'Allowed Access', 0 => 'Disallowed Access');
        				    $optionlist_selected = 1;
        				}else{
        				    $optionlist_acl = array(1 => 'Allowed Access', 0 => 'Disallowed Access');
        				    $optionlist_selected = 0;
        				}
        				
        				$optionlist_acl = $this->objForm->select('private['.$fid.']', $optionlist_acl, $optionlist_selected);
        			}else{
        				$optionlist_acl = '&nbsp;';
        			}
        		}else{
        		    $jcount = count($forum_access);
        			for($j = 0; $j < $jcount; $j++){
        				if($forum_access[$j]['id'] == $fid){
        				    $kcount = count($forum_auth_fields);
        					for($k = 0; $k < $kcount; $k++){
        						$field_name = $forum_auth_fields[$k];
        
        						if($forum_access[$j][$field_name] == AUTH_ACL){
        							$optionlist_acl_adv[$fid][$k] = '<select name="private_'.$field_name.'['.$fid.']">';
        
        							if(isset($auth_field_acl[$fid][$field_name]) && !($is_admin || $user_ary['auth_mod'])){
        								if(!$auth_field_acl[$fid][$field_name]){
        									$optionlist_acl_adv[$fid][$k] .= '<option value="1">ON</option>
                                                                                    <option value="0" selected="selected">OFF</option>';
        								}else{
        									$optionlist_acl_adv[$fid][$k] .= '<option value="1" selected="selected">ON</option>
                                                                                    <option value="0">OFF</option>';
        								}
        							}else{
        								if($is_admin || $user_ary['auth_mod']){
        									$optionlist_acl_adv[$fid][$k] .= '<option value="1">ON</option>';
        								}else{
        									$optionlist_acl_adv[$fid][$k] .= '<option value="1">ON</option>
                                                                                    <option value="0" selected="selected">OFF</option>';
        								}
        							}
        
        							$optionlist_acl_adv[$fid][$k] .= '</select>';
        						}
        					}
        				}
        			}
        		}
        
       		
				$optionlist_mod = $this->objForm->select('moderator['.$fid.']', array(1=>'Is Moderator', 0=>'Not Moderator'), ($user_ary['auth_mod'] ? 1 : 0));

                $vars = $this->objPage->getVar('tplVars');
        		$row_class = (!($i % 2)) ? 'row_color2' : 'row_color1';
        		$row_color = (!($i % 2)) ? $vars['row_color1'] : $vars['row_color2'];
        
        		$this->objTPL->assign_block_vars('forums', array(
        			'ROW_COLOR'      => $row_color,
        			'ROW_CLASS'      => $row_class,
        			'FORUM_NAME'     => $forum_access[$i]['title'],
        
        			'U_FORUM_AUTH'   => '/'.root().'admin/forum/group/?f='.$forum_access[$i]['id'],
        
        			'S_MOD_SELECT'   => $optionlist_mod
                ));
        
        		if(!$adv){
        			$this->objTPL->assign_block_vars('forums.aclvalues', array(
        				'S_ACL_SELECT' => $optionlist_acl
                    ));
        		}else{
        			for($j = 0; $j < count($forum_auth_fields); $j++){
        				$this->objTPL->assign_block_vars('forums.aclvalues', array(
        					'S_ACL_SELECT' => $optionlist_acl_adv[$fid][$j]
                        ));
        			}
        		}
        
        		$i++;
        	}

        	if($mode == 'user'){
        		$t_username = $ug_info[0]['username'];
        		$s_user_type = $this->objForm->select('userlevel', array('admin'=>'Administrator', 'user'=>'User'), ($is_admin ? 'admin' : 'user'));
           	}else{
        		$t_groupname = $ug_info[0]['name'];
        	}

        	$name = array();
        	$id = array();
        	for($i = 0; $i < count($ug_info); $i++){
        		if(($mode == 'user' && !$ug_info[$i]['single_user_group']) || $mode == 'group'){
        			$name[] = ($mode == 'user') ? $ug_info[$i]['name'] : $ug_info[$i]['username'];
        			$id[] = ($mode == 'user') ? intval($ug_info[$i]['gid']) : intval($ug_info[$i]['id']);
        		}
        	}

        	$t_usergroup_list = $t_pending_list = '';
        	if(count($name)){
        		for($i = 0; $i < count($ug_info); $i++){
        			$ug = ($mode == 'user') ? 'group&gid=' : 'user&uid=';
        
        			if (!$ug_info[$i]['pending']){
        				$t_usergroup_list   .= (($t_usergroup_list != '') ? ', ' : '') .
                                                '<a href="/'.root().'admin/forum/group/?mode='.$ug.$id[$i].'">'.$name[$i].'</a>';
        			}else{
        				$t_pending_list     .= (($t_pending_list != '') ? ', ' : '') .
                                                '<a href="/'.root().'admin/forum/group/?mode='.$ug.$id[$i].'">'.$name[$i].'</a>';
        			}
        		}
        	}
        	
        	$t_usergroup_list = ($t_usergroup_list == '') ? 'None' : $t_usergroup_list;
        	$t_pending_list = ($t_pending_list == '') ? 'None' : $t_pending_list;
        
        	$s_column_span = 2; // Two columns always present
        	if(!$adv){
        		$this->objTPL->assign_block_vars('acltype', array(
        			'L_UG_ACL_TYPE' => 'Simple Permissions'
                ));
        		$s_column_span++;
        	}else{
        		for($i = 0; $i < count($forum_auth_fields); $i++){
        			$cell_title = $field_names[$forum_auth_fields[$i]];
        
        			$this->objTPL->assign_block_vars('acltype', array(
        				'L_UG_ACL_TYPE' => $cell_title
                    ));
        			$s_column_span++;
        		}
        	}

        	$this->objTPL->set_filenames(array(
        		'body' => 'modules/forum/template/admin/auth_ug_body.tpl'
            ));
            
        	$adv_switch = (empty($adv)) ? 1 : 0;
        	$u_ug_switch = ($mode == 'user') ? 'uid='.$user_id : 'gid='.$group_id;
        	$switch_mode = '/'.root().'admin/forum/group/?mode='.$mode.'&'.$u_ug_switch.'&adv='.$adv_switch;
        	$switch_mode_text = (empty($adv)) ? 'Advanced mode' : 'Simple mode';
        	$u_switch_mode = '<a href="' . $switch_mode . '">' . $switch_mode_text . '</a>';
        
        	$s_hidden_fields = '<input type="hidden" name="mode" value="' . $mode . '" /><input type="hidden" name="adv" value="' . $adv . '" />';
        	$s_hidden_fields .= ($mode == 'user') ? '<input type="hidden" name="uid" value="' . $user_id . '" />' : 
                                                    '<input type="hidden" name="gid" value="' . $group_id . '" />';
        
        	if($mode == 'user'){
        		$this->objTPL->assign_block_vars('switch_user_auth', array());

        		$this->objTPL->assign_vars(array(
        			'USER_NAME'                  => $this->objUser->profile($t_username),
        			'USER_LEVEL'                 => 'User Level : '.$s_user_type,
        			'USER_GROUP_MEMBERSHIPS'     => 'Group memberships : '.$t_usergroup_list
                ));
        	}else{
        		$this->objTPL->assign_block_vars('switch_group_auth', array());

        		$this->objTPL->assign_vars(array(
        			'USER_NAME'                  => $t_groupname,
        			'GROUP_MEMBERSHIP'           => 'Usergroup members : '.$t_usergroup_list.'<br />
                                                     Pending members : '.$t_pending_list
                ));
        	}
        	
        	$this->objTPL->assign_vars(array(
        		'L_USER_OR_GROUPNAME' => ($mode == 'user') ? 'Username' : 'Group name',
        
        		'L_AUTH_TITLE'        => ($mode == 'user') ? 'User Permissions Control' : 'Group Permissions Control',
        		'L_AUTH_EXPLAIN'      => ($mode == 'user') ? 
                                                             'Here you can alter the permissions and moderator status assigned to each individual user. Do not forget when changing user permissions that group permissions may still allow the user entry to forums, etc. You will be warned if this is the case.' : 
                                                             'Here you can alter the permissions and moderator status assigned to each user group. Do not forget when changing group permissions that individual user permissions may still allow the user entry to forums, etc. You will be warned if this is the case.',
        		'L_MODERATOR_STATUS'  => 'Moderator status',
        		'L_PERMISSIONS'       => 'Permissions',
        		'L_SUBMIT'            => 'Submit',
        		'L_RESET'             => 'Reset', 
        		'L_FORUM'             => 'Forum', 
        
        		'U_USER_OR_GROUP'     => '/'.root().'admin/forum/group/?mode='.$mode,
        		'U_SWITCH_MODE'       => $u_switch_mode,
        
        		'S_COLUMN_SPAN'       => $s_column_span,
        		'S_AUTH_ACTION'       => '/'.root().'admin/forum/group/?mode='.$mode, 
        		'S_HIDDEN_FIELDS'     => $s_hidden_fields
            ));
        }else{
        	$this->objTPL->set_filenames(array(
        		'body' => 'modules/forum/template/admin/'.($mode == 'user'  ? 'user' : 'auth').'_select_body.tpl'
        	));

        	if($mode != 'user'){
                $query = $this->objSQL->getTable('SELECT id, name FROM '.$this->objSQL->prefix().'groups WHERE single_user_group = 0');
                    
                    if(!$query)
                        hmsgDie('FAIL', 'Error: Couldnt get group list');
                
                $sOptions = array();
                foreach($query as $row){ $sOptions[$row['id']] = $row['name']; }
                
        		$this->objTPL->assign_vars(array(
        			'S_AUTH_SELECT' => $this->objForm->select('gid', $sOptions),
                ));
        	}
        
        	$l_type = ($mode == 'user') ? 'USER' : 'AUTH';
        
        	$this->objTPL->assign_vars(array(
        		'L_'.$l_type.'_TITLE'     => ($mode == 'user') ? 'User Permissions Control' : 'Group Permissions Control',
        		'L_'.$l_type.'_EXPLAIN'   => ($mode == 'user') ? 'Here you can alter the permissions and moderator status assigned to each individual user. Do not forget when changing user permissions that group permissions may still allow the user entry to forums, etc. You will be warned if this is the case.' : 'Here you can alter the permissions and moderator status assigned to each user group. Do not forget when changing group permissions that individual user permissions may still allow the user entry to forums, etc. You will be warned if this is the case.',
        		'L_'.$l_type.'_SELECT'    => ($mode == 'user') ? 'Select a User' : 'Select a Group',
        		'L_LOOK_UP'               => ($mode == 'user') ? 'Look up User' : 'Look up Group',
        
        		'S_HIDDEN_FIELDS'         => $this->objForm->inputbox('hidden', $mode, 'mode'), 
        		'S_'.$l_type.'_ACTION'    => '/'.root().'admin/forum/group/'
        	));
        }
        $this->objTPL->pparse('body', false);
    }

}
?>