<?php
/*======================================================================*\
||              Cybershade CMS - Your CMS, Your Way                     ||
\*======================================================================*/
if(!defined('INDEX_CHECK')){ die('Error: Cannot access directly.'); }

class forum extends Module{

	public function doAction($action){
        $this->objPage->setMenu('forum');
        $this->objPage->addJSFile('/'.root().'modules/forum/scripts/forum.js');
        $this->objPage->addCSSFile('/'.root().'modules/forum/styles/forum.css');
        $vars = $this->objPage->getVar('tplVars');

		$this->objTPL->assign_vars(array(
			'I_NO_POSTS'		=> $vars['IMG_posts_old'],         'L_NO_POSTS'		    => langVar('I_NO_POSTS'),
			'I_NEW_POSTS'		=> $vars['IMG_posts_new'],         'L_NEW_POSTS'		=> langVar('I_NEW_POSTS'),
			'I_LOCKED'			=> $vars['IMG_locked'],   	       'L_LOCKED'			=> langVar('I_LOCKED'),
			'I_ANNOUNCEMENT'	=> $vars['IMG_announcement_old'],  'L_ANNOUNCEMENT'	    => langVar('I_ANNOUNCEMENT'),
			'I_STICKY'			=> $vars['IMG_sticky_old'],   	   'L_STICKY'			=> langVar('I_STICKY'),
		));



        //reset the forum tracker
        if(User::$IS_ONLINE){
            //$this->forumTrackerInit();
        }

		if($action=='index' || is_empty($action)){
			$action = 'index';
		}

			//preview stuff
			if(preg_match('_preview_i', $action)){
				$action = 'previewPost';
			}

		/**
		 * we will 'add' a breadcrum for this module, the modules
		 * already sets the start of the pagecrumbs so its just a
		 * case of adding to it
		 */
		$this->objPage->addPagecrumb(array(
			array('url' => '/'.root().'modules/forum/', 'name' => langVar('B_FORUM')),
		));

		switch(strtolower($action)){
			case 'index':
				$this->showIndex();
			break;

			default:
			case 404:
				$this->throwHTTP(404);
			break;
		}
	}

	/**
	 * Returns sql about a specific forum
	 *
	 * @version 1.0
	 * @since 	1.0.0
	 * @autor 	xLink
	 *
	 * @param 	int 	$id
	 *
	 * @return 	array
	 */
	public function getForumInfo($id=0, $subs=false){
		//see if we have the cache in place
		if(!is_empty($this->forum)){
			//are we wanting the sub categories only?
			if($subs){
				//check if we have sub cats..
				$subs = array();
				foreach($this->forum as $cat){
					if($this->auth[$cat['id']]['auth_view'] && $cat['parent_id'] == $id){
						$subs[$cat['id']] = $cat;
					}
				}
				return $subs;

			//return specific category or all of em
			}else{
				//if they gave us a number for a ID give them the specific forum ID back
				if(is_number($id) && isset($this->forum[$id])){
					return $this->forum[$id];
				}

				//if it was a asterix, give it all to em
				if($id == '*'){ return $this->forum; }
			}
		}

		$this->forum = array();

		//grab the categories and some extra details
		$cats = $this->objSQL->getTable($this->objSQL->prepare('
			SELECT f.*, u.id as uid,
				t.id as tid, t.subject as thread_name, t.timestamp as thread_posted, p.author as last_author, p.timestamp as last_posted
			FROM `$Pforum_cats` as f
			LEFT JOIN `$Pforum_posts` as p
				ON p.id = f.last_post_id
			LEFT JOIN `$Pforum_threads` as t
				ON p.thread_id = t.id
			LEFT JOIN `$Pusers` as u
				ON u.id = p.author
			ORDER BY f.order ASC
		'));
	        if(!$cats){ hmsgDie('FAIL', 'Error: No forum information avalible at this time.'); }
			$this->objSQL->freeResult($cats);

		//shove each forum into a cache var so we dont have to keep querying for em
		foreach($cats as $cat){
			$this->forum[$cat['id']] = $cat;
		}

		$counts = $this->objSQL->getTable($this->objSQL->prepare('
			SELECT c.id, COUNT(DISTINCT t.id) AS thread_count, COUNT(DISTINCT p.id) AS post_count
			FROM `$Pforum_cats` c
			LEFT JOIN `$Pforum_threads` t
				ON t.cat_id = c.id
			LEFT JOIN `$Pforum_posts` p
				ON t.id = p.thread_id

			GROUP BY c.id
		'));
	        if(!$counts){ hmsgDie('FAIL', 'Error: No forum information avalible at this time.'); }
			$this->objSQL->freeResult($counts);

		//add the counts to them
		foreach($counts as $count){
			$this->forum[$count['id']]['thread_count'] = $count['thread_count'];
			$this->forum[$count['id']]['post_count'] = $count['post_count'];
		}

		//if they gave us a number for a ID give them the specific forum ID back
		if(is_number($id) && isset($this->forum[$id])){
			return $this->forum[$id];
		}

		//if it was a asterix, give it all to em
		if($id == '*'){ return $this->forum; }

		//otherwise we cant accommodate them so return false
		return false;
	}


    /**
     * Shows outputs the first level of forums with sub forums and threads
     *
     * @version	2.0
     * @since   1.0.0
     */
    public function showIndex(){
        $vars = $this->objPage->getVar('tplVars');
        $_row_color1 = $vars['row_color1']; $_row_color2 = $vars['row_color2'];  $_row_highlight = $vars['row_highlight'];
        $this->objPage->setTitle('Forum');

        $this->objTPL->set_filenames(array(
        	'body' => 'modules/forum/template/forum_index.tpl'
        ));

	//
	//--Moderator Setup
	//
    	$forum_moderators = array();

    	// Obtain list of moderators(users only) of each forum
    	$query = $this->objSQL->getTable($this->objSQL->prepare('
            SELECT aa.cat_id, u.id, u.username
            FROM `$Pforum_auth` aa, `$Pgroup_subs` ug, `$Pgroups` g, `$Pusers` u
            WHERE aa.auth_mod = 1
                    AND g.single_user_group = 1
                    AND ug.gid = aa.group_id
                    AND g.id = aa.group_id
                    AND u.id = ug.uid
            GROUP BY u.id, u.username, aa.cat_id
            ORDER BY aa.cat_id, u.id
        '));

        if(is_empty($query)){ hmsgDie('FAIL', 'Could not query forum moderator information'); }
            $this->objSQL->freeResult($query);

        if(count($query)){
            foreach($query as $row){
        		$forum_moderators[$row['cat_id']][] = $this->objUser->profile($row['id']);
            }
        }
        //clean up a bit
        unset($query);
	//
	//--Moderator Setup
	//
		//grab the categories and some extra details
		$mainCats = $this->getForumInfo('*');

        //get a list of permissions for the user
    	$this->auth = $this->auth(AUTH_VIEW, AUTH_LIST_ALL, $mainCats);

        //and then find out which main cats the user can see
        $categories = array();
        foreach($mainCats as $cat){
            if($this->auth[$cat['id']]['auth_view'] && $cat['parent_id']==0){ $categories[] = $cat; }
        }

        /* Sortable Cats */
        $reOrder = false;
        if(User::$IS_ONLINE && $this->config('forum', 'sortables_categories')){
            $reOrder = (!is_empty($this->objUser->grab('forum_order')) ? unserialize($this->objUser->grab('forum_order')) : false);

            //we have an active order that we can use to reorder the forum cats
            if($reOrder){
                $newOrder = array();
                //$reOrder as $id => $display
                foreach($reOrder as $k => $v){
                    foreach($categories as $f){
                        if($f['id']==$k){
                            $f['_display'] = $v;
                            $newOrder[$k] = $f; //reorder the array with the new cat order
                            break;
                        }
                    }
                }
                //and then make sure we havent missed any
                foreach($categories as $f){
                    if(array_searchRecursive($f['id'], $newOrder)===false){
                        $newOrder[] = $f;
                    }
                }
                $categories = $newOrder; //assign the new order to $cats
            }

        }
        /* Sortable Cats */

		$currId = 0; //set a var for the current id
		$row_count = 0; //setup a row counter..
		//loop through the categories
		foreach($categories as $cat){
			$children = $this->getForumInfo($cat['id'], true);

			//do we need to show the header again? (no subs for a main cat will render no header either)
			if($cat['id'] != $currId && $children){
				//if we have no data for it, then just set it to show
				if(is_empty($cat['_display'])){ $cat['_display'] = 1; }

				//just the cat headers
				$this->objTPL->assign_block_vars('forum', array(
					'ROW'			=>		$row_color,

					'ID'			=>		$cat['id'],
					'CAT'			=>		secureMe($cat['title']),
					'THREADS'		=>		langVar('L_THREADS'),
					'POSTS'			=> 		langVar('L_POSTS'),
					'LASTPOST'		=> 		langVar('L_LASTPOST'),

					/* Sortable Cats */
					'EXPAND'        =>      (User::$IS_ONLINE ? ($cat['_display']==1 ? $vars['IMG_retract'] : $vars['IMG_expand']) : '/'.root().'images/spacer.gif'),
					'DISPLAY'       =>      (User::$IS_ONLINE ? ($cat['_display']==1 ? NULL : 'display:none;') : NULL),
					'MODE'          =>      (User::$IS_ONLINE ? ($cat['_display']==1 ? '1' : '0') : '1'),
					/* Sortable Cats */
				));
				if(User::$IS_ONLINE){ $this->objTPL->assign_block_vars('forum.expand', array()); }

				//reassign the current id so we know where we are
				$currId = $cat['id'];
			}

			//make sure we have some subcategories before we continue in here..
			if(!is_empty($children)){
				foreach($children as $child){
					//see if we can view the cat first
					if(!$this->auth[$child['id']]['auth_view']){ continue; }
					$grandChildren = $this->getForumInfo($child['id'], true);

					$row_color = $row_count%2==1 ? 'row_color1' : 'row_color2';
			    	$icon_status = '_old';
					if(User::$IS_ONLINE){
						$tracking_topics = array(); $tracker = doArgs('forum_tracker', false, $_SESSION['user']);
						if(!is_empty($tracker)){ $tracking_threads = unserialize($tracker); }

						if(!is_empty($tracking_threads)){
							foreach($tracking_threads as $t){
								if($t['cat_id'] == $child['id'] && $t['read']===false){
					        	   $icon_status = '_new';
								}
							}
						}
					}
					if($thread['locked']==1){ $ico = 'IMG_locked'; }

					switch($post['mode']){
						case 1: 	$ico = 'IMG_announcement'.$icon_status; break;
						case 2: 	$ico = 'IMG_sticky'.$icon_status; 		break;
						default: 	$ico = 'IMG_posts'.$icon_status; 		break;
					}

					//sort though the last post stuff :D
					$lastThread = $this->modCat($child, 'last_post');

					$last_title  = doArgs('thread_name', null, $lastThread, function($text){
						return truncate(secureMe($text), 25);
					});

					$last_author = !is_empty($lastThread['last_author']) ? 'by '.$this->objUser->profile($lastThread['last_author']) : langVar('L_NO_POST');
					$last_post   = '/'.root().Page::$THEME_ROOT.'buttons/goto_reply.gif';

        			$this->objTPL->assign_block_vars('forum.row', array(
                        'ROWSPAN'       =>  !is_empty($grandChildren) ? 2 : 1,

                        'ID'            =>  $child['id'],
        				'CAT_ICO'		=>	$vars[$ico],
        				'URL'			=>	'/'.root().'modules/forum/'.seo($subCat['title']).'-'.$subCat['id'].'/',
        				'ROW'			=>	$row_color,
        				'CAT'			=>	secureMe($child['title']),
        				'DESC'			=>	(isset($child['desc']) && !is_empty($child['desc'])) ? contentParse($child['desc']) : '',

                        'L_TCOUNT'		=>	langVar('L_THREADS'),
                        'T_PCOUNT'		=> 	langVar('L_POSTS'),
                        'T_COUNT'		=>	$this->modCat($child, 'thread'),
                        'P_COUNT'		=> 	$this->modCat($child, 'post'),

                        'LP_AUTHOR'		=> 	$last_author,
                        'LP_URL'	    =>	!is_empty($last_title)
                                                ? '/'.root().'modules/forum/thread/'.seo($lastThread['thread_name']).'-'.$lastThread['last_post'].'.html'
                                                : null,
                        'LP_TITLE'      =>  !is_empty($last_title) ? secureMe($last_title) : null,
                        'LP_TIME'       =>  !is_empty($last_title) ? $this->objTime->mk_time($lastThread['post_time']) : null,
                        'LP_REPLY_URL'	=>	!is_empty($last_title)
                                                ? '/'.root().'modules/forum/thread/'.seo($lastThread['thread_name']).'-'.$lastThread['last_post'].'.html?mode=last_page'
                                                : null,
                        'LP_REPLY_IMG'  =>  !is_empty($last_title) ? '<img src="'.$last_post.'" alt="" />' : null,

                        'L_MODS'        =>  is_array($forum_moderators[$child['id']]) ? langVar('MODS') : null,
        				'C_MODS'        =>  is_array($forum_moderators[$child['id']]) ? implode(', ', $forum_moderators[$child['id']]) : null,
        			));

                    if(!is_empty($grandChildren)){
                        //assign this so we can see the subs
            			$this->objTPL->assign_block_vars('forum.row.subs', array(
                            'ID'            =>  $child['id'],
            				'ROW'			=>	$row_color,
                        ));

                        foreach($grandChildren as $child){
                			if(!$this->auth[$child['id']]['auth_view']){ continue; }
    						$ico = 'IMG_subForum_old';
                            if(User::$IS_ONLINE && $tracking_threads){
                				if(!is_empty($tracking_threads)){
                					foreach($tracking_threads as $thread){
                						if($thread['cat_id'] == $child['id'] && $thread['read']===false){
                							$ico = 'IMG_subForum_new';
                						}
                					}
                				}
            				}

                			$this->objTPL->assign_block_vars('forum.row.subs.cats', array(
                                'URL'       =>  '/'.root().'modules/forum/'.seo($child['title']).'-'.$child['id'].'/',
                                'ID'        =>  $child['id'],
                                'NAME'      =>  secureMe($child['title']),
                                'IMG'       =>  $vars[$ico],
                            ));
                        }
                    }
                    $row_count++;
                }
           }
        }

	//
	//-- Stats
	//
		//figure out which users have been active in the last 24 hours
		$user24 = $this->objSQL->getTable($this->objSQL->prepare(
			'SELECT id, last_active FROM `$Pusers`
				WHERE last_active >= %d
				ORDER BY last_active DESC',
			$this->objTime->mod_time(time(), 0, 0, 24, 'MINUS')
		));

        if(!is_empty($user24)){
            $users24 = array();
            foreach($user24 as $u){ $users24[] = $this->objUser->profile($u['id']); }
        }else{
            $users24 = array(langVar('M_NOONE24'));
        }

        global $config;

        //grab the groups and output em into a key
		$key = '';
		if($config['groups']){

			$groups = array();
			foreach($config['groups'] as $group){
				if($group['type'] == GROUP_HIDDEN){ continue; }
				if($group['single_user_group']){ continue; }

				$groups[] = $group;
			}

			$add = ' | '; $group_count = count($groups); $counter = 1;
	  		foreach($groups as $group){
				if($group_count == ($counter)){ $add = ''; }
				$key .= '<font style="color: '.$group['color'].'" class="username '.strtolower($group['name']).'" title="'.$group['description'].'">'.$group['name'].'</font>'.$add;

				$counter++;
			}
		}

		//grab the currently online users
        $userO = $this->objSQL->getTable($this->objSQL->prepare(
			'SELECT * FROM `$Ponline` WHERE timestamp >= %s',
			$this->objTime->mod_time(time(), 0, 20, 0, 'MINUS')
		));

        $usersO = 0; $guestsO = 0;
        if(count($userO)){
            foreach($userO as $u){
                if($u['uid']==0){   $guestsO++; continue;   }
                if($u['uid']!=0){   $usersO++;  continue;   }
            }
        }

		$boarddays = (time() - $this->config('statistics', 'site_opened')) / 86400;
        $total_topics   = $this->objSQL->getInfo('forum_threads', false);
        $total_posts    = $this->objSQL->getInfo('forum_posts', false) + $total_topics;
        $total_users    = $this->objSQL->getInfo('users', false);
        $last_user      = $this->objSQL->getLine('SELECT id FROM '.$this->objSQL->prefix().'users WHERE active = 1 ORDER BY id DESC');

		$this->objTPL->assign_block_vars('stats', array(
			'L_STATS'			=> langVar('L_STATS'),

			'L_THREADS'			=> langVar('L_TOT_THREADS'),
			'C_THREADS'			=> $total_topics,

			'L_POSTS'			=> langVar('L_TOT_POSTS'),
			'C_POSTS'			=> $total_posts,

			'L_USERS'			=> langVar('L_TOT_MEMBERS'),
			'C_USERS'			=> $total_users,

			'L_NEWUSER'			=> langVar('L_NEW_MEMBER'),
			'C_NEWUSER'			=> $this->objUser->profile($last_user['id']),

			'L_TOTAL_USERS'		=> langVar('L_USERSONOFF', $usersO, $guestsO),
			'USER24'			=> langVar('L_USERSONLINE24', count($users24), implode(', ', $users24)),

			'LEGEND'			=> langVar('L_LEGEND', $key),
        ));

		$this->objTPL->parse('body', false);
    }

	public function viewCat($category){

	}


    private function modCat($cat, $mode){
    	//make sure we have the right mode
        $mode_ary = array('post', 'thread', 'last_post');
        if(!in_array(strtolower($mode), $mode_ary)){
            $mode = 'post';
        }

		//check if there is children categories for this cat
		$subs = $this->getForumInfo($cat['id'], true);

        //k so we need to use this func for a few things..
        switch($mode){
            case 'post':
            case 'thread':
            	$count = 0;
                //can this user see this? if yes, increase the postcount
                if($this->auth[$cat['id']]['auth_view']){
                    $count += $cat[$mode.'_count'];
                    //is there any subcat?
                    if(!is_empty($subs)){
                        foreach($subs as $subCat){
                            if($this->auth[$subCat['id']]['auth_view']){
                                $count += $this->modCat($subCat, $mode);
                            }
                        }
                        return $count;
                    }
                }
                return $count;
            break;

			//thanks to children categories etc we need to figure out if any of those have a post newer than we have in this cat
            case 'last_post':
                $return = array( 'last_post'     => 0,
                                 'last_author'   => 0,
                                 'thread_name'   => NULL,
                                 'post_time'     => 0 );

                //can this user see this?
                if($this->auth[$cat['id']]['auth_view']){
                    $return = array( 'last_post'     => $cat['tid'],
                                     'last_author'   => $cat['last_author'],
                                     'thread_name'   => $cat['thread_name'],
                                     'post_time'     => $cat['last_posted'] );

                    if (!is_empty($subs)){
                        foreach($subs as $subCat){
                            if($this->auth[$subCat['id']]['auth_view']){
                                if($subCat['last_poster']!==NULL && $subCat['last_poster'] >= $return['post_time']){
                                    $return = array( 'last_post'     => $subCat['tid'],
                                                     'last_author'   => $subCat['last_author'],
                                                     'thread_name'   => $subCat['thread_name'],
                                                     'post_time'     => $subCat['last_posted'] );
                                }
                            }
                        }
                        return $return;
                    }
                }
                return $return;
            break;
        }
    }





























    function auth($type, $forum_id, $f_access=NULL){

    	switch($type){
    		case AUTH_ALL:
    			$a_sql = 'a.auth_view, a.auth_read, a.auth_post, a.auth_reply, a.auth_edit, a.auth_del, a.auth_move, a.auth_special';
    			$auth_fields = array('auth_view', 'auth_read', 'auth_post', 'auth_reply', 'auth_edit', 'auth_del','auth_move', 'auth_special');
			break;

    		case AUTH_VIEW:       $a_sql = 'a.auth_view';         $auth_fields = array('auth_view');	          break;
    		case AUTH_READ:       $a_sql = 'a.auth_read';         $auth_fields = array('auth_read');              break;
    		case AUTH_POST:       $a_sql = 'a.auth_post';         $auth_fields = array('auth_post');	          break;
    		case AUTH_REPLY:      $a_sql = 'a.auth_reply';	      $auth_fields = array('auth_reply');             break;
    		case AUTH_EDIT:       $a_sql = 'a.auth_edit';         $auth_fields = array('auth_edit');              break;
    		case AUTH_DELETE:     $a_sql = 'a.auth_del';          $auth_fields = array('auth_del');               break;
    		case AUTH_MOVE:       $a_sql = 'a.auth_move';         $auth_fields = array('auth_move');              break;
    		case AUTH_SPECIAL:    $a_sql = 'a.auth_special';      $auth_fields = array('auth_special');           break;
    		default:                                                                                              break;
    	}

    	//check if we need to return perms for a specific forum or the entire lot
    	if(empty($f_access)){
            if(!isset($this->authQuery[$type][$forum_id])){
            	$forum_match_sql = ($forum_id != AUTH_LIST_ALL ? 'WHERE a.id = '.$forum_id : '');
                $sql = 'SELECT a.id, %s FROM `$Pforum_cats` a %s';
            		$function = ($forum_id != AUTH_LIST_ALL ? 'getLine' : 'getTable');
            		if(!($this->authQuery[$type][$forum_id] = $f_access = $this->objSQL->$function($this->objSQL->prepare($sql, $a_sql, $forum_match_sql)))){
            			$this->objSQL->freeResult($f_access);
            			return array();
            		}
        		$this->objSQL->freeResult($f_access);
            }else{
                $f_access = $this->authQuery[$type][$forum_id];
            }
    	}

    	// If the user isn't logged on then all we need do is check if the forum
    	// has the type set to ALL, if yes they are good to go, if not then they
    	// are denied access
    	$u_access = array();
    	if(user::$IS_ONLINE){
            if(!isset($this->authQuery2[$type][$forum_id])){
                if(!isset($this->authQuery3)){
            		$this->authQuery3 = $query = $this->objSQL->getTable($this->objSQL->prepare(
						'SELECT a.cat_id, %s, a.auth_mod
	            			FROM `$Pforum_auth` a, `$Pgroup_subs` ug
	            			WHERE ug.uid = "%s"
	            				AND ug.pending = 0
	            				AND a.group_id = ug.gid',
	           			$a_sql, $this->objUser->grab('id')
					));

                    if(is_empty($query)){
                        hmsgDie('FAIL', 'Error: Cannot retreive the forum authorization');
                    }
                }else{
                    $query = $this->authQuery3;
                }

                if(count($query)){
                    foreach($query as $row){
                		if($forum_id != AUTH_LIST_ALL){
                			$u_access[] = $row;
                		}else{
                			$u_access[$row['cat_id']][] = $row;
                		}
                    }
                }
                $this->authQuery2[$type][$forum_id] = $u_access;
                $this->objSQL->freeResult($query);
            }else{
                $u_access = $this->authQuery2[$type][$forum_id];
            }
    	}

    	$is_admin = (User::$IS_ONLINE && User::$IS_ADMIN) ? true : 0;

    	$auth_user = array();
    	$icount = count($auth_fields);
    	for($i = 0; $i < $icount; $i++){
            $key = $auth_fields[$i];

    		if($forum_id != AUTH_LIST_ALL){
    			$value = $f_access[$key];

    			switch($value){
    				case AUTH_ALL:
    					$auth_user[$key] = true;
                        $auth_user[$key.'_type'] = langVar('L_Auth_Anonymous_Users');
    				break;
    				case AUTH_REG:
    					$auth_user[$key] = User::$IS_ONLINE ? true : 0;
    					$auth_user[$key.'_type'] = langVar('L_Auth_Registered_Users');
					break;
    				case AUTH_ACL:
    					$auth_user[$key] = User::$IS_ONLINE ? $this->objUser->checkUserAuth(AUTH_ACL, $key, $u_access, $is_admin) : 0;
    					$auth_user[$key.'_type'] = langVar('L_Auth_Users_granted_access');
					break;
    				case AUTH_MOD:
    					$auth_user[$key] = User::$IS_ONLINE ? $this->objUser->checkUserAuth(AUTH_MOD, 'auth_mod', $u_access, $is_admin) : 0;
    					$auth_user[$key.'_type'] = langVar('L_Auth_Moderators');
    				break;
    				case AUTH_ADMIN:
    					$auth_user[$key] = $is_admin;
    					$auth_user[$key.'_type'] = langVar('L_Auth_Administrators');
					break;
    				default:
    					$auth_user[$key] = 0;
					break;
    			}
    		}else{
    		    $kcount = count($f_access);
    			for($k = 0; $k < $kcount; $k++){
    				$value = $f_access[$k][$key];
    				$f_fid = $f_access[$k]['id'];
    				$u_access[$f_fid] = isset($u_access[$f_fid]) ? $u_access[$f_fid] : array();

    				switch($value){
    					case AUTH_ALL:
    						$auth_user[$f_fid][$key] = true;
    						$auth_user[$f_fid][$key.'_type'] = langVar('L_Auth_Anonymous_Users');
						break;
    					case AUTH_REG:
    						$auth_user[$f_fid][$key] = User::$IS_ONLINE ? true : 0;
    						$auth_user[$f_fid][$key.'_type'] = langVar('L_Auth_Registered_Users');
						break;
    					case AUTH_ACL:
    						$auth_user[$f_fid][$key] = User::$IS_ONLINE ? $this->objUser->checkUserAuth(AUTH_ACL, $key, $u_access[$f_fid], $is_admin) : 0;
    						$auth_user[$f_fid][$key.'_type'] = langVar('L_Auth_Users_granted_access');
						break;
    					case AUTH_MOD:
    						$auth_user[$f_fid][$key] = User::$IS_ONLINE ? $this->objUser->checkUserAuth(AUTH_MOD, 'auth_mod', $u_access[$f_fid], $is_admin) : 0;
    						$auth_user[$f_fid][$key.'_type'] = langVar('L_Auth_Moderators');
						break;
    					case AUTH_ADMIN:
    						$auth_user[$f_fid][$key] = $is_admin;
    						$auth_user[$f_fid][$key.'_type'] = langVar('L_Auth_Administrators');
						break;
     					default:
    						$auth_user[$f_fid][$key] = 0;
						break;
    				}

    			}
    		}
    	}

    	// Is user a moderator?
    	if($forum_id != AUTH_LIST_ALL){
    		$auth_user['auth_mod'] = User::$IS_ONLINE ? $this->objUser->checkUserAuth(AUTH_MOD, 'auth_mod', $u_access, $is_admin) : 0;
    	}else{
    		for($k = 0; $k < count($f_access); $k++){
    			$f_fid = $f_access[$k]['id'];
    			$u_access[$f_fid] = isset($u_access[$f_fid]) ? $u_access[$f_fid] : array();
    			$auth_user[$f_fid]['auth_mod'] = User::$IS_ONLINE ? $this->objUser->checkUserAuth(AUTH_MOD, 'auth_mod', $u_access[$f_fid], $is_admin) : 0;
    		}
    	}

    	return $auth_user;
    }


	/**
	 * Builds the multidimensional array
	 *
	 * @version 1.0
	 * @since 	1.0.0
	 * @author 	xLink
	 *
	 * @param 	array	$paths
	 * @param 	int 	$id
	 *
	 * @return 	string
	 */
    public function buildJumpBoxArray($blank=array()){
        //grab a copy of the entire cat table, grabbing the data we need
        if(!isset($this->catQuery)){
            $cats = $this->catQuery = $this->objSQL->getTable($this->objSQL->prepare('SELECT * FROM `$Pforum_cats` ORDER BY id, `order` ASC'));
        }

        //rearrange the query
        $newQuery = array();
        if(is_array($blank) && count($blank)){
            $newQuery[0] = $blank;
        }

            //first pass for master cats
            foreach($this->catQuery as $cat){
                if($cat['parent_id']!=0){ continue; }
                $newQuery[$cat['id']] = $cat;
            }
            if(!isset($this->catTitles)){
                $this->catTitles = $newQuery;
            }

            //second pass for the rest
            foreach($this->catQuery as $cat){
                if($cat['parent_id']==0){ continue; }
                $newQuery[$cat['id']] = $cat;
            }
        $this->catQuery = $newQuery;

        $auth = $this->auth(AUTH_VIEW, AUTH_LIST_ALL);
        if(is_array($blank) && count($blank)){
            $auth[0]['auth_view'] = true;
        }

        $a = array(); $cats = $this->catQuery;
        //for each parent cat
        foreach($cats as $cat){
            if(!$auth[$cat['id']]['auth_view']){ continue; }

            //this is a parent cat so just add it to the array
            if($cat['parent_id']==0){
            	$a[$cat['id']] = array();
				continue;
			}

      		//this isnt a parent cat so do some upgrades...
            if($cat['parent_id']!=0){
                $id = array_searchRecursive((int)$cat['parent_id'], $a);
                $id = $this->buildArrayPath($id, $cat['id']);

                if(!$id) $id = '$a['.$cat['id'].']';

                eval("$id = array(\$cat['title']);");
      		}

        }

        return $a;
    }

	/**
	 * A custom function to build a select box, specifically for the jumpbox
	 *
	 * @version 1.0
	 * @since 	1.0.0
	 * @author 	xLink
	 *
	 * @param 	string	$name
	 * @param 	array 	$options
	 * @param	bool 	$selected
	 * @param	bool 	$allowMasters		Allow the Root Forums to be selected?
	 *
	 * @return 	string
	 */
    public function buildJumpBox($name, $options, $selected=null, $allowMasters=true){

        $val = '<select name="'.$name.'" id="'.$name.'">'."\n";
        foreach ($options as $k => $v){
            $j=0; $title = str_replace(array('\''), array(''), $this->catTitles[$k]['title']);
            if($allowMasters){
                $val .= '<optgroup label=\'----------\'>'."\n";
                $val .= '<option value=\''.$k.'\''.($k==$selected ? "selected='true'" : '').'>'.
                            '&nbsp;'.$title.
                        '</option>'."\n";
                $val .= '<optgroup label=\'----------\'>'."\n";
            }else{
                $val .= '<optgroup label="'.$title.'">'."\n";
            }
            if(is_array($v)){ $val .= self::processSelect($v, $selected, $noKeys, $j++); }
        }
        $val .= '</select>'."\n";
        return $val;
    }

	/**
	 * A recursive function for generating the select box options
	 *
	 * @version 1.0
	 * @since 	1.0.0
	 * @author 	xLink
	 *
	 * @param 	array	$options
	 * @param 	string 	$selected
	 * @param	bool 	$noKeys
	 * @param 	int		$repeat
	 * @param 	int 	$i
	 * @param 	int 	$ki
	 *
	 * @return 	string
	 */
    private function processSelect($options, $selected, $noKeys=false, $repeat=0, $i=0, $ki=0){
		if(!is_array($options)){ return false; }

        foreach ($options as $k => $v){
            if(is_array($v)){
                foreach($v as $a => $b){
                    if(is_array($b)){
                        $val .= self::processSelect($b, $selected, $noKeys, $repeat+1, $i+1, $a);
                    }else{
                        $val .= '<option value="'.$k.'"'.($k==$selected ? 'selected="true"' : NULL).'>'.
                                    str_repeat('&nbsp;', $repeat+$i+1).'&#9500; '.$b.
                                '</option>'."\n";

                    }
                }
            }else{
                $val .= '<option value="'.($k==0 ? $ki : $k).'"'.(($k==0 ? $ki : $k)==$selected ? 'selected="true"' : '').'>'.
                            str_repeat('&nbsp;', $repeat+$i).'&#9492;'.str_repeat('-', $repeat).' '.$v.
                        '</option>'."\n";
            }
        }

        return $val;
    }

	/**
	 * Builds a path for the multi dimensional array the jumpbox uses
	 *
	 * @version 1.0
	 * @since 	1.0.0
	 * @author 	xLink
	 *
	 * @param 	array	$paths
	 * @param 	int 	$id
	 *
	 * @return 	string
	 */
	private function buildArrayPath($paths=array(), $id=0){
		if(!is_array($paths)){ return false; }

		$return = '$a'; $x=0;
		foreach($paths as $path){
			$return .= '['.$path.']';

			if($x++ == count($paths)-1 && $id!=0){
				$return .= '['.$id.']';
			}
		}
		return $return;
	}


}

?>