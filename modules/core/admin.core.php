<?php
/*======================================================================*\
||              Cybershade CMS - Your CMS, Your Way                     ||
\*======================================================================*/
if (!defined('INDEX_CHECK')) die('Error: Cannot access directly.');

class core extends Module{

    /**
     * ACP's Constructor Function
     *
     *
     */
    function doAction($action){
        //if the desktop dir is in play then use the desktop version
        if(is_dir($this->objPage->acpThemeROOT)){
            //spawn specific windows
            if(preg_match('/window/is', $action)){
                $this->newWindow();
                exit;
            }

            //draw the shell
            if(is_empty($action)){
                $this->drawCP();
                exit;
            }
        }else{
            //load a core panel
            if(preg_match('_([a-zA-Z0-9]*)($|/save)_i', $action, $sysModule)){
                $action = 'sysModule';

                //if we have to run the save, do so
                if($sysModule[2]=='/save'){
                    $mode = 'save';
                }
            }

            //if action is empty or / then show the default panel
            if($this->action=='' || $this->action=='/'){
                $action = 'index';
            }

            //figure out what to do here
            switch(strtolower($action)){
                case 'sysmodule':
                    $this->loadSystemCP($sysModule[1], $mode);
                break;

                default:
                case 'index':
                    $this->showIndex();
                break;
            }

        }
    }

//
//-- 'Normal' ACP Panel
//

    function loadSystemCP($module, $mode=''){
        //construct a simple path for the core panels
        $path = cmsROOT.'modules/core/admin/'.$module;

        //sanity checks
        if(!is_file($path.'/cfg.php')){
            hmsgDie('FAIL', 'Could not locate the configuration file for "'.$module.'". Load Failed');
        }
        if(!is_file($path.'/panel.'.$module.'.php')){
            hmsgDie('FAIL', 'Could not locate Module "'.$module.'". Load Failed');
        }

        //include and maybe load in the language file
        if(is_file($path.'/lang.'.$this->config('global', 'language').'.php')){
            $this->translate($path.'/lang.'.$this->config('global', 'language').'.php');
        }

        include $path.'/panel.'.$module.'.php';
    }

    function showIndex(){
        $this->objPage->setTitle('Administration Panel');
        $this->objPage->setMenu(false);

    }

//
//-- Everything below is for the Desktop ACP Panel
//

    function drawCP(){
        $this->objPage->addCSSFile('/'. root(). $this->objPage->acpThemeROOT. 'style.css');
        $this->objPage->addJSFile('/'. root(). $this->objPage->acpThemeROOT. 'jquery.desktop.js');

        $this->objPage->showHeader();

        $this->objTPL->set_filenames(array(
            'body' => $this->objPage->acpThemeROOT . 'desktop.tpl'
        ));

//
//-- Left Side Menu
//
        $menuL[] = 'CMoS';
        $menuL['Moderator Tools'] = array(
            'ico'  => '/'.root().'images/icons/user.png',
        );
        $menuL['Tools'] = array(
            'ico'  => '/'.root().'images/icons/settings.png',
        );

        if(User::$IS_ADMIN){
            $menuL['Tools'][] = array(
                'link' => '#',
                'name' => 'CMS CLI',

                'data-window' => 'cli',
                'data-id' => 'win_'.randCode(3),
                'data-test' => 'bar',
            );
        }

        if(User::$IS_MOD){
            $menuL['Tools'][] = array(
                'link' => '#',
                'name' => 'User Tools',

                'data-window' => 'usertools',
                'data-id' => 'win_'.randCode(3),

            );
        }

//
//-- Right Side Menu
//
        $menuR['Back to Website'] = '/'.root();
        $menuR[$this->objUser->grab('username')] = array();
        $menuR[$this->objUser->grab('username')][] = array(
            'link' => '#',
            'name' => 'Account Prefrences',
            'ico'  => '/'.root().'images/icons/settings.png',
        );
        $menuR[$this->objUser->grab('username')][] = array(
            'link' => '#',
            'name' => 'Logout ACP'
        );
        $menuR[] = 'clock';

//
//-- Desktop Icons
//


        $this->objTPL->assign_vars(array(
            'MENU_BAR_L'     => $this->setupMenu($menuL),
            'MENU_BAR_R'     => $this->setupMenu($menuR, 'right'),

            'TASK_BAR'         => '&nbsp;',
        ));

        $this->objTPL->parse('body');
        $this->objPage->showFooter(true);
    }


    function setupMenu(array $menu, $float='left'){
        if(!is_array($menu) || is_empty($menu)){ return NULL; }

        $_menu = '';
        $menuLink = '<a class="menu_trigger" href="%s">%s</a>';
        foreach($menu as $title => $ext){
            #echo dump($ext, $title);
            if($ext == 'clock'){
                $_menu .= "\n\t\t\t".'<li class="title" id="clock">&nbsp;</li>';
                continue;
            }

            if(is_empty($title)){
                $_menu .= "\n\t\t\t".'<li class="title">'.$ext.'</li>';
                continue;
            }

            if(!is_array($ext)){
                $_menu .= '<li>'.sprintf($menuLink, (is_empty($ext) ? '#' : $ext), $title).'</li>';
                continue;
            }

            if(is_array($ext)){
                $_menu .= "\n\t\t\t".'<li>'.sprintf($menuLink, '#', '<img src="'.$ext['ico'].'"/> '.$title).
                    "\n\t\t\t".'<ul class="submenu">';

                unset($ext['ico']);
                foreach($ext as $link){
                    $data = null;
                    foreach($link as $k => $v){
                        if(substr($k, 0, 5) == 'data-'){
                            $data .= ' '.$k.'="'.$v.'"';
                        }
                    }


                    $_menu .= "\n\t\t\t\t".'<li><a href="'.$link['link'].'"'.$data.'>'.
                                '<img src="'.$link['ico'].'"/> '.$link['name'].'</a></li>';
                }
                $_menu .= "\n\t\t\t".'</ul></li>'."\n";
            }
        }

        return '<ul class="float-'.$float.'">'.$_menu."\n\t\t".'</ul>';
    }



    function newWindow(){
        $window = $_GET['window'];
        $class = new ReflectionClass('core');

        if($class->hasMethod('window_'.$window)){
            $this->{'window_'.$window}();
        }
    }

    function genWindow($winType=null, $options=array()){
        $options = array_merge($_GET, $options);

        //verify the window tpl exists
        $winTypes = array('1frame', '2frame');

        switch($winType){
            default:
                $window = '2frame.tpl';
            break;

            case (in_array($winType, $winTypes)):
                $window = $winType.'.tpl';
            break;
        }

        $windowId = 'win_'.randCode(3);
        $this->objTPL->set_filenames(array(
            $windowId => $this->objPage->acpThemeROOT . 'windows/' . $window,
            'winFrame' => $this->objPage->acpThemeROOT . 'windowFrame.tpl'
        ));

            $this->objTPL->assign_vars(array(
                'WIN_ID'         => doArgs('id', $windowId, $options),

                'CONTENTS'         => (isset($options['debug']) ? dump($options) : null)
                                    . doArgs('content', '', $options),
            ));

            $this->objTPL->parse($windowId, false);


        //window positioning
        $style = null;
        if(isset($options['position']) && is_array($options['position']) && !is_empty($options['position'])){
            $allowed = array('x'=>'left', 'y'=>'top', 'h'=>'height', 'w'=>'width');
            foreach($options['position'] as $k => $v){
                if(isset($allowed[$k]) && !is_empty($allowed[$k])){
                    $style .= $allowed[$k].': '.$v.'px; ';
                }
            }
        }
        $style .= 'display: block; position: absolute;';

        //

        $this->objTPL->assign_vars(array(
            'WIN_ICO'         => doArgs('ico', '/'.root().'images/icons/application.png', $options),
            'WIN_TITLE'     => doArgs('title', 'Untitled Window', $options),
            'WIN_FOOTER'     => doArgs('footer', '', $options),

            'WIN_CONTENTS'     => $this->objTPL->get_html($windowId),
            'WIN_STYLE'        => $style,
            'WIN_DATA'        => $data,
        ));

        $this->objTPL->parse('winFrame'); exit;
    }




    function window_userTools(){

        if(!HTTP_POST){
            #top: 33px; left: 591px; height: 426px; width: 520px; display: block; position: absolute;
            $options['ico'] = '/'.root().'images/icons/user.png';
            $options['title'] = 'User Tools';
            $options['position'] = array('y'=>'30', 'x'=>'636', 'h'=>'426', 'w'=>'506');

            $content = null;

            $formExtras = array('required'=>true);
            $tabLink = '<li><a href="#%2$s"><span>%s</span></a></li>';

            $content .= '<div id="userTools"><ul>';
            $content .= sprintf($tabLink, 'New User', 'new_user');
            $content .= sprintf($tabLink, 'Send Notification', 'new_notification');
            $content .= sprintf($tabLink, 'Password Utilities', 'password_utilities');
            $content .= sprintf($tabLink, 'User Permissions', 'user_permsissions');
            $content .= '</ul>';

                $content .= $this->objForm->outputForm(array(
                    'FORM_START'     => $this->objForm->start('newUser', array('method' => 'post', 'action' => '?')),
                    'FORM_END'         => $this->objForm->finish(),

                    'FORM_SUBMIT'    => $this->objForm->button('submit', 'Register User'),
                    'FORM_RESET'     => $this->objForm->button('reset', 'Reset'),
                ),
                array(
                    'field' => array(
                        'User Registration'    => '_header_',
                        'Username'             => $this->objForm->inputbox('username', 'text', '', $formExtras),
                        'Password'             => $this->objForm->inputbox('password', 'password', '', $formExtras),
                        'Email'             => $this->objForm->inputbox('email', 'email', '', $formExtras),
                    ),
                ),
                array(
                    'id'         => 'new_user',
                    'border'     => false,
                    'header'     => '<h5>%s</h5>',
                ));



                $content .= $this->objForm->outputForm(array(
                    'FORM_START'     => $this->objForm->start('newNotification', array('method' => 'post', 'action' => '?')),
                    'FORM_END'         => $this->objForm->finish(),

                    'FORM_SUBMIT'    => $this->objForm->button('submit', 'Send Notification'),
                ),
                array(
                    'field' => array(
                        'Send Notification'    => '_header_',
                        'Username'             => $this->objForm->inputbox('notify', 'hidden', 'mode').
                                                $this->objForm->inputbox('username', 'text', '', $formExtras),
                        'Notification'         =>     $this->objForm->textarea('message', '', $formExtras+array('class'=>'float-right')),
                    ),
                ),
                array(
                    'id'         => 'new_notification',
                    'border'     => false,
                    'header'     => '<h5>%s</h5>',
                ));

            $content .= '</div><script>$("div#userTools").tabs();</script>';


            $options['content'] = $content;
            $this->genWindow('1frame', $options);
        }else{

        }

    }

    function window_cli(){
        $options['ico'] = '/'.root().'images/icons/application_xp_terminal.png';
        $options['title'] = 'CLI';
        $options['content'] = 'cli';


        $this->genWindow('cli', $options);
    }

}
?>