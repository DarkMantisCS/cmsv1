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


        //view thread
        if(preg_match('_^thread/([a-zA-Z0-9-]*)\-([0-9]*)_i', $action, $threadId)){
            $action = 'thread';
            $this->rowstart = doArgs('page', 0, $_GET);
            if(User::$IS_ONLINE){
                switch($_GET['mode']){
                    case 'lock':
                    case 'unlock':
                        $this->lock = $this->lockThread($threadId[2], ($_GET['mode']=='lock' ? true : false));
                    break;

                    case 'watch':
                    case 'unwatch':
                        $this->watchThread($threadId[2], ($_GET['mode']=='watch' ? true : false));
                    break;

                    case 'edit':        $action = 'edit';        break;
                    case 'reply':       $action = 'reply';       break;
                    case 'qreply':      $action = 'qreply';      break;
                    case 'rm':          $action = 'remove';      break;
                    case 'move':        $action = 'move';        break;
                }
            }
        }

            //view category
            if(preg_match('_^([a-z0-9-]*)-([0-9]*)/page([0-9]*)_i', $action, $boardId) ||
                preg_match('_^([a-z0-9-]*)-([0-9]*)_i', $action, $boardId)){
                    $action = 'cat';
                    $this->rowstart = isset($boardId[3]) ? $boardId[3] : 0;
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

            case 'cat':
                $this->viewCat($boardId[2]);
            break;

            case 'thread':
                $this->viewThread($threadId[2]);
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
		if(is_empty($this->forum)){
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

	        //get a list of permissions for the user
	    	$this->auth = $this->auth(AUTH_ALL, AUTH_LIST_ALL, $cats);

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
		}


		//are we wanting the sub categories only?
		if($subs){
			//check if we have sub cats..
			$cats = array(); $forums = $this->forum;
			foreach($forums as $cat){
				if($this->auth[$cat['id']]['auth_view'] && $cat['parent_id'] == $id){
					$cats[$cat['id']] = $cat;
				}
			}
			return $cats;

		//return specific category or all of em
		}else{
			//if it was a asterix, give it all to em
			if($id == '*'){ return $this->forum; }

			//if they gave us a number for a ID give them the specific forum ID back
			if(is_number($id) && isset($this->forum[$id])){
				return array($this->forum[$id]);
			}
		}

		//otherwise we cant accommodate them so return false
		return false;
	}

	public function outputCats($categories, $index=false, $title=null){
        $vars = $this->objPage->getVar('tplVars');
        $_row_color1 = $vars['row_color1']; $_row_color2 = $vars['row_color2'];  $_row_highlight = $vars['row_highlight'];

        $this->objTPL->set_filenames(array(
        	'categories' => 'modules/forum/template/forum_categoryOutput.tpl',
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
					'CAT'			=>		(!is_empty($title) ? $title : $cat['title']),
					'THREADS'		=>		langVar('L_THREADS'),
					'POSTS'			=> 		langVar('L_POSTS'),
					'LASTPOST'		=> 		langVar('L_LASTPOST'),

					/* Sortable Cats */
					'EXPAND'        =>      (User::$IS_ONLINE && $index ? ($cat['_display']==1 ? $vars['IMG_retract'] : $vars['IMG_expand']) : '/'.root().'images/spacer.gif'),
					'DISPLAY'       =>      (User::$IS_ONLINE && $index ? ($cat['_display']==1 ? NULL : 'display:none;') : NULL),
					'MODE'          =>      (User::$IS_ONLINE && $index ? ($cat['_display']==1 ? '1' : '0') : '1'),
					/* Sortable Cats */
				));
				if(User::$IS_ONLINE && $index){ $this->objTPL->assign_block_vars('forum.expand', array()); }

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
        				'URL'			=>	'/'.root().'modules/forum/'.seo($child['title']).'-'.$child['id'].'/',
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


		$return = $this->objTPL->get_html('categories');
		$this->objTPL->reset_block_vars('forum');
		return $return;
	}


    /**
     * Shows outputs the first level of forums with sub forums and threads
     *
     * @version	2.0
     * @since   1.0.0
     * @author	xLink
     */
    public function showIndex(){
        $vars = $this->objPage->getVar('tplVars');
        $_row_color1 = $vars['row_color1']; $_row_color2 = $vars['row_color2'];  $_row_highlight = $vars['row_highlight'];
        $this->objPage->setTitle('Forum');

        $this->objTPL->set_filenames(array(
        	'body' => 'modules/forum/template/forum_index.tpl',
        ));

		//grab the categories and some extra details
		$mainCats = $this->getForumInfo('*');

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

		$this->objTPL->assign_var('CATEGORIES', $this->outputCats($categories, true));

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
        $last_user      = $this->objSQL->getLine($this->objSQL->prepare('SELECT id FROM `$Pusers` WHERE active = 1 ORDER BY id DESC'));

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


    /**
     * Outputs threads for a category, and sub categories if necessary
     *
     * @version	1.3
     * @since   0.8.0
     * @author 	xLink
     *
     * @param 	int 	$id		ID of the category to start from
     */
	public function viewCat($id){
		//init some generally used vars
		$vars = $this->objPage->getVar('tplVars');
		$_row_color1 = $vars['row_color1']; $_row_color2 = $vars['row_color2'];  $_row_highlight = $vars['row_highlight'];

		$this->objTPL->set_filenames(array(
			'body' => 'modules/forum/template/forum_category.tpl'
		));

			//grab this forums info and auth
			$cat = $this->getForumInfo($id);
			$catAuth = $this->auth[$id];

			//if forum dosent exist or user dosent have perms...BOOM!
			if(is_empty($cat) || !$catAuth['auth_read'] || !$catAuth['auth_view']){
	            $this->objPage->setTitle(langVar('B_FORUM').' > '.langVar('L_CAT_NF'));

				//this msg depends on if they wer owned due to permissions or the forum actually dosent exist :O
				$msg = (!$catAuth['auth_view'] ? langVar('L_NO_ID', $id) : langVar('F_PERMS', $catAuth['auth_read_type']));
				hmsgDie('INFO', $msg);
	            return;
			}else{
				//else check to see if we have sub cats, and output
				$this->objTPL->assign_var('CATEGORY', $this->outputCats($cat, false, langVar('L_SUBCATS')));
			}

			//grab all the parents and granparents for this forum
	        $this->getSubCrumbs($id);
	        $this->objPage->setTitle(langVar('B_FORUM').' > '.secureMe($cat['title']));

			//reset $cat so we dont get confuzzled and check to see if we arnt a root forum
			$cat = $cat[0];
	        if($cat['parent_id'] == 0){
	        	//no posts are allowed in root forums
	            $this->objTPL->parse('body', false);
	            return;
	        }
		//
		//--Begin Thread Output
		//
			$limit = 20;
			//init pagination
			$objPagination = new pagination('page', $limit, $this->objSQL->getInfo('forum_threads', array('`cat_id`=%s AND `mode`=0', $id)));

			//grab the threads with the current pagination limit
	        $threads = $this->objSQL->getTable($this->objSQL->prepare(
				'SELECT t.*, p.timestamp as last_timestamp, count(DISTINCT p.id) as replies
					FROM `$Pforum_threads` t
	                LEFT JOIN `$Pforum_posts` p
		                ON t.id = p.thread_id
	                WHERE t.cat_id = %d
						AND t.mode = 0

	                GROUP BY t.id
	                ORDER BY p.timestamp DESC
	                LIMIT %s',
	            $id,
				$objPagination->getSqlLimit()
			));

			//grab the 'special' threads, announcements, stickies etc
	        $special = $this->objSQL->getTable($this->objSQL->prepare(
				'SELECT t.*, p.timestamp as last_timestamp, count(DISTINCT p.id) as replies
					FROM `$Pforum_threads` t
	                LEFT JOIN `$Pforum_posts` p
		                ON t.id = p.thread_id
	                WHERE t.cat_id = %d
						AND t.mode <> 0

	                GROUP BY t.id
	                ORDER BY p.timestamp DESC',
	            $id
			));

			//output the header
	        $this->objTPL->assign_block_vars('threads', array(
	            'CAT'				=> secureMe($cat['title']),
	            'L_THREAD_TITLE'	=> langVar('L_THREAD_TITLE'),
	            'L_AUTHOR'			=> langVar('L_AUTHOR'),
	            'L_VIEWS'			=> langVar('L_VIEWS'),
	            'L_REPLIES'			=> langVar('L_POSTS'),
	            'L_LASTPOST'		=> langVar('L_LASTPOST'),
	        ));

	        //if user has the permission to post in here..
	    	if($catAuth['auth_post']){
	    		$this->objTPL->assign_block_vars('threads.post', array(
	                'URL'     => '/'.root().'modules/forum/'.seo($cat['title']).'-'.$id.'/post/',
	                'TEXT'    => 'New Topic',
	                'IMG'     => $vars['FIMG_new_post'],
	            ));
	        }
	        $this->objTPL->assign_var('PAGINATION', $objPagination->getPagination());
	        if(is_array($special)){ $threads = array_merge($special, $threads); }

	        if(is_empty($threads)){
	        	$this->objTPL->assign_block_vars('threads.error', array(
	        		'ERROR' => langVar('L_NO_THREADS'),
	        	));
	        }else{
	        	//loop through the threads
	            $count = 0;
	            foreach($threads as $thread){

	            	//figure out which icon we should be showing
			    	$icon_status = '_old';
					if(User::$IS_ONLINE){
						$tracking_topics = array(); $tracker = doArgs('forum_tracker', false, $_SESSION['user']);
						if(!is_empty($tracker)){ $tracking_threads = unserialize($tracker); }

						if(!is_empty($tracking_threads)){
							foreach($tracking_threads as $t){
								if($t['id'] == $thread['id'] && !$t['read']){
					        	   $icon_status = '_new';
								}
							}
						}
					}

					//title and post status
					$title = secureMe($thread['subject']);
					if(is_empty($title)){ $title = 'No Thread Title'; }
					switch($thread['mode']){
						case 1:
							$title = langVar('L_ANNOUNCEMENT', $title);
							$ico = 'IMG_announcement'.$icon_status;
						break;
						case 2:
							$title = langVar('L_STICKY', $title);
							$ico = 'IMG_sticky'.$icon_status;
						break;
						default:
							$title = $title;
							$ico = 'IMG_posts'.$icon_status;
						break;
					}
					if($thread['locked']==1){ $ico = 'IMG_locked'; }

					//output the thread info to the template
					$this->objTPL->assign_block_vars('threads.row', array(
						'ID'			=> 'thread_'.$thread['id'],
						'ICON'			=> $vars[$ico],
						'URL'			=> $this->generateThreadURL($thread),
						'CLASS'			=> $count%2 ? 'row_color1' : 'row_color2',

						'TITLE'			=> $title,
						'AUTHOR'		=> $this->objUser->profile($thread['author']),
						'VIEWS'			=> $thread['views'],
						'REPLIES'		=> $thread['replies'],

						'LP_AUTHOR'		=> $thread['replies'] ? $this->objUser->profile($thread['last_post_id']) : null,
						'LP_URL'		=> $thread['replies'] ? $this->generateThreadURL($thread).'?mode=last_page' : null,
						'LP_TIME'		=> $thread['replies'] ? $this->objTime->mk_time($thread['last_timestamp']) : langVar('L_NO_REPLYS'),
					));

			        $count++;
	            }
	        }

		$this->objTPL->parse('body', false);
	}

	public function viewThread($id){
		$vars = $this->objPage->getVar('tplVars');
		$this->objTPL->set_filenames(array(
			'body' => 'modules/forum/template/forum_viewThread.tpl',
		));

		//grab the thread
		$thread = $this->objSQL->getLine($this->objSQL->prepare(
			'SELECT t.*, COUNT(DISTINCT p.id) as posts
				FROM `$Pforum_threads` t
				LEFT JOIN `$Pforum_posts` p
					ON p.thread_id = t.id
				WHERE t.id = %d',
			$id
		));
			//make sure it exists
	        if(!is_array($thread)){ $this->throwHTTP(404); return; }

		//grab the cat
		$cat = $this->getForumInfo($thread['cat_id']);
		$cat = $cat[0];

		//grab the auth and make sure they /can/ see it
        $threadAuth = $this->auth[$thread['cat_id']];
        if(!$threadAuth['auth_view'] || !$threadAuth['auth_read']){
            $this->objPage->setTitle(langVar('B_FORUM'). ' > '.langVar('P_PERMISSION_DENIED'));
            hmsgDie('INFO', langVar('L_AUTH_MSG', $threadAuth['auth_read_type']));
        	return;
        }

        //sort out the breadcrumbs & page title
		$threadTitle = secureMe($thread['subject']);
		$threadUrl = $this->generateThreadURL($thread);

		$page_name = array(langVar('B_FORUM'), $cat['title'], (!is_empty($threadTitle) ? $threadTitle : langVar('F_VIEWF')));
		$this->objPage->setTitle(implode(' > ', $page_name));

		$this->getSubCrumbs($thread['cat_id']);
		$this->objPage->addPagecrumb(array(
			array('url' => $threadUrl, 'name' => $threadTitle),
		));

        //update views
        if(!isset($_SESSION['site']['forum']['view'][$thread['tid']])){
            $this->objSQL->query($this->objSQL->prepare('UPDATE `$Pforum_threads` SET views = (views+1) WHERE id = %d LIMIT 1', $id));
            $_SESSION['site']['forum']['view'][$thread['tid']] = 1;
        }

		//if the user is online
		if(User::$IS_ONLINE){
			//do thread tracker part of the tour
				$tracker = doArgs('forum_tracker', false, $_SESSION['user']);
				$tracking_threads = array();
	            if(!is_empty($tracker)){
	                $tracking_threads = unserialize($tracker);
	            }

				//find the thread row in the array or create a new one
	        	if(!is_empty($tracking_threads)){
	            	foreach($tracking_threads as $k => $v){
	            		if($tracking_threads[$k]['id'] == $id){
	                		$tracking_threads[$k][$id]['read'] = true;
	                		$tracking_threads[$k][$id]['last_poster'] = time();
	                    }
	            	}
	        	}else{
	            	$tracking_threads[$id]['read'] = true;
	            	$tracking_threads[$id]['last_poster'] = time();
	        	}

				//now update the user row
	            unset($update);
	            $_SESSION['user']['forum_tracker'] = $update['forum_tracker'] = serialize($tracking_threads);
	            $this->objUser->updateUserSettings($this->objUser->grab('id'), $update);
	            unset($update);

			//update the users watch status
	        $this->objSQL->updateRow('forum_watch', array('seen'=>1), array('user_id ="%s" AND thread_id ="%s"', $this->objUser->grab('id'), $id));

			// && read notification if needed
			$this->objNotify->clearNotifications($id, true);
		}

		//setup a new pagination obj
        $objPagination = new pagination('page', 10, $thread['posts']);

        //see if the user wants us to jump to the last page
        if(doArgs('mode', false, $_GET) == 'last_page'){ $objPagination->goLastPage(); }

        //check for guest restrictions
        $limit = $objPagination->getSqlLimit();
        if(!User::$IS_ONLINE && $this->config('forum', 'guest_restriction')){
        	$this->objTPL->assign_block_vars('error', array(
        		'ERROR' => langVar('L_VIEW_GUEST'),
        	));

            $limit = '1;';
        }

        //grab the thread posts
        $posts = $this->objSQL->getTable($this->objSQL->prepare(
			'SELECT * FROM `$Pforum_posts` WHERE thread_id = %d ORDER by timestamp, id ASC LIMIT %s',
			$id, $limit
		));

        //assign some vars to the tpl
    	$this->objTPL->assign_vars(array(
            'THREAD_TITLE'  => $threadTitle,
            'PAGINATION'    => $objPagination->getPagination(true),
            'JUMPBOX'       => $this->objForm->start('jump'.randcode(2)).
                                $this->buildJumpBox('jumpbox', $this->buildJumpBoxArray(), $thread['cat_id'], false, ' onchange="jump(\'jumpbox\');" ').
                                $this->objForm->finish(),
    	));

		//setup the watch thread trigger
        $watchThread = $this->objSQL->getInfo('forum_watch', array('user_id ="%s" AND thread_id ="%s"', $this->objUser->grab('id'), $id));
        $this->objTPL->assign_var('WATCH',
            (USER::$IS_ONLINE
                ? '[ <a href="'.$threadUrl.'?mode='.($watchThread ? 'unwatch' : 'watch').'">'.
						langVar(($watchThread ? 'L_UNWATCH_THREAD' : 'L_WATCH_THREAD')).'</a> ]'
                : null)
        );

		//check if the thread is currently locked
		if($thread['locked']==0){
			$quick_reply = doArgs('forum_quickreply', false, $_SESSION['user']);

			//test if we get to output quick reply
			if($quick_reply && ($threadAuth['auth_reply'] || $threadAuth['auth_mod'] || User::$IS_MOD)){
				$_SESSION['site']['forum'][$id]['id']     = $id;
				$_SESSION['site']['forum'][$id]['sessid'] = $sessid = md5($this->objUser->grab('username').$id);

				//assign the form to the tpl
				$this->objTPL->assign_vars(array(
					'F_START'           => $this->objForm->start('qreply', array('method' => 'POST', 'action' => $threadUrl.'?mode=qreply')),
					'F_END'             => $this->objForm->finish(),
					'HIDDEN'			=> $this->objForm->inputbox('sessid', 'hidden', $sessid).
					                       $this->objForm->inputbox('id', 'hidden', $id).
					                       $this->objForm->inputbox('quick_reply', 'hidden', 'true'),

					'L_QUICK_REPLY'		=> langVar('L_QUICK_REPLY'),
					'F_QUICK_REPLY'		=> $this->objForm->textarea('post', '', array(
												'extra'=> ' tabindex="2"',
												'style'=> 'width:100%;height:50px;border:0;padding:0;',
												'placeholder'=> langVar('L_QR_PLACEHOLDER')
											)),

					'POST_OPTIONS'      => langVar('L_OPTIONS'),
					'OPTIONS'           => $this->objForm->checkbox('autoLock', null, false).' '.langVar('L_QR_LOCK_THREAD').
					                       (!$watchThread
					                           ? $this->objForm->checkbox($this->objUser->grab('autowatch'), 'watch_topic').' Watch Topic.'
					                           : NULL),

					'SUBMIT'			=> $this->objForm->button('submit', 'Post', array('extra'=> ' tabindex="3"')),
				));

                $this->objTPL->assign_block_vars('qreply', array(
                    'TEXT'  => langVar('L_QUICK_REPLY'),
                ));

				if($threadAuth['auth_mod'] || User::$IS_MOD){
					$this->objTPL->assign_block_vars('qreply.options', array());
				}
			}
			if($threadAuth['auth_reply'] || $threadAuth['auth_mod'] || User::$IS_MOD){
				$this->objTPL->assign_block_vars('reply', array(
					'URL'   => $threadUrl.'?mode=reply',
					'TEXT'  => langVar('L_POST_REPLY'),
					'IMG'   => $thread['locked']==1 ? '<img src="'.$vars['FIMG_locked'].'" />'  : '<img src="'.$vars['FIMG_reply'].'" />' ,
				));
			}

		}else{
			$this->objTPL->assign_block_vars('reply', array(
				'URL'   => $threadUrl.'?mode=unlock',
				'TEXT'  => langVar('L_THREAD_LOCKED'),
				'IMG'	=> $thread['locked']==1 ? '<img src="'.$vars['FIMG_locked'].'" />' : NULL,
			));
		}

		//posts get output here

		$this->objTPL->parse('body', false);
	}

	public function generateThreadURL($thread){
		if(!is_array($thread) || is_empty($thread)){
			return null;
		}
		return '/'.root().'modules/forum/thread/'.seo($thread['subject']).'-'.$thread['id'].'.html';
	}

    /**
     * Figures out Combined Posts counts for $cat and subs /
     * 		Figured out which 'last post' to show from the sub cats
     *
     * @version	1.0
     * @since   0.8.0
     * @author 	xLink
     *
     * @param 	int 	$cat	ID of the parent category
     * @param	string 	$mode
     *
     * @return 	int/array	int if $mode == (post || thread), array if $mode == last_post
     */
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

    /**
     * Sets Breadcrumbs from this category to its highest grandparent.
     *
     * @version	1.3
     * @since   0.8.0
     * @author 	xLink
     *
     * @param 	int 	$id		ID of the category to start from
     */
    private function getSubCrumbs($id){
		//set some vars
		$count = 0; $countArray = array();

		//get the current category
		$query = $this->getForumInfo($id);

		//and add it to the breadcrumb array
		$b[$count++] 	= $query[0];
		$countArray[] 	= $query[0]['id'];

		//and then loop back through the cats till we have no parent id
		while($query[0]['parent_id'] != 0){
			//grab the parent cat
			$query = $this->getForumInfo($query[0]['parent_id']);

			//and add it to the array
			$b[$count++] 	= $query[0];
			$countArray[] 	= $query[0]['id'];

			if(in_array($query['id'], $countArray)){
				$query['parent_id'] = 0; break;
			}
		}

		//reverse $b and add the info gained to the
		$b = array_reverse($b); $crumbs = array();
		foreach($b as $cat){
			$crumbs[] = array('url' => '/'.root().'modules/forum/'.seo($cat['title']).'-'.$cat['id'].'/', 'name' => $cat['title']);
		}
		$this->objPage->addPagecrumb($crumbs);
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