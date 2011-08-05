<?php
/*======================================================================*\
||              Cybershade CMS - Your CMS, Your Way                     ||
\*======================================================================*/
if(!defined('INDEX_CHECK')){ die('Error: Cannot access directly.'); }
$objPage->setTitle(langVar('B_UCP').' > '.langVar('L_CONTACT_INFO'));
$objPage->addPagecrumb(array( array('url' => $url, 'name' => langVar('L_CONTACT_INFO')) ));
$objTPL->set_filenames(array(
	'body' => "modules/core/template/panels/panel.contact.tpl"
));

//grab the user info we need
$user = $objUser->getUserInfo($uid);
$uid = $objUser->grab('id');

switch(strtolower($mode)){
	default:
		$objPage->addJSFile('?mode=js');
		$objPage->addCSSFile('/'.root().'modules/profile/contactInfo.css');
		
		$objTPL->assign_vars(array(
			'FORM_START' 	=> $objForm->start('panel', array('method' => 'POST', 'action' => $saveUrl)),
			'FORM_END'		=> $objForm->finish(),

			'SUBMIT'		=> $objForm->button('submit', 'Submit'),
			'RESET'			=> $objForm->button('reset', 'Reset'),
		));

		//set some security crap
		$_SESSION['site']['panel']['sessid'] = $sessid = $objUser->mkPassword($uid.time());
		$_SESSION['site']['panel']['id'] = $uid;

        $objTPL->assign_block_vars('msg', array(
            'MSG' => msg('INFO', '<br /><ul><li>To add a new peice of contact information, select it from the list.</li> <li>If you wish to delete something from the list, use the <img src="/'.root().'images/icons/delete.png" title="Delete Me" /> icon next to it.</li> <li>You can also reorder the list simply by dragging the title of the row you wish to move.</li> <li><strong>Please be aware, after you delete something from the list or reorder the list, you still need to save it, so press \'Save\' before leaving this page</strong>.</li></ul>', 'MSG', langVar('L_CONTACT_INFO'))
        ));


        //below will contain a list of settings for the various services/networks etc everyone uses
        $objCore->autoLoadModule('profile', $objProfile);
		$settings = $objProfile->contactInfoSettings();

        //heres where we set the select box up, we dont use the objForm method cause we want some custom stuff here
        $ar = array();
        $return = 'Add: <select id="addBox" name="addBox" onchange="doMe(); return false;">';
        $return .= '<option value="0" selected="selected">Select Option Here</option>';
        foreach($settings as $set){
            if(!is_array($set)){ $return .= '<optgroup label="'.$set.'">'; continue; }
            $return .= '<option value="'.$set['code'].'" id="'.$set['code'].'" class="ico '.$set['code'].(doArgs('unique', false, $set) ? ' unique' : '').'">'.$set['name'].'</option>';

            $ar[$set['code']] = $set['name'];
        }
        $return .= '</select>';

        //set the default table and form stuff up
        $fExtras = array('id' => 'form[]', 'extra' => 'style="width: 98%"');

        $up = '<a id="delete"><img src="/'.root().'images/icons/delete.png" title="Delete Me" /></a>';
        $hTable = '<table cellspacing="1" cellpadding="3" class="tborder formTbl"><tr><td id="title" title="You can drag me to re order me!"></td><td id="field">%s</td><td id="close">'.$up.'</td></tr></table>';
        $hForm = sprintf($hTable, $objForm->inputbox('input', 'text', '', $fExtras));

        //see if we have any saved info
        $populate = null; $f = null;
        if(!is_empty($user['contact_info'])){
            $user['contact_info'] = json_decode($user['contact_info'], true);

            //loop through the contactInfo
            $i = 0; $form = array(); $url = false;
                        
            foreach($user['contact_info'] as $row){
                //we need to count through it nao
                if(!isset($form[$row['type']])){ $form[$row['type']] = 0; }
                $count = $form[$row['type']]++;
$row['val'] = preg_replace('/(![0-9-_.:\/]*)/i', '', $row['val']);
                //output the table, with the correct info
                $echo = '<div><div id="'.$row['type'].'-'.$count.'" class="'.($i++%2==0 ? 'row_color1' : 'row_color2').'"><table cellspacing="1" cellpadding="3" class="tborder formTbl"><tbody><tr>';
                $echo .= '<td id="title" class="'.$row['type'].' label" title="You can drag me to re order me!">'.$ar[$row['type']].'</td>';
                $echo .= '<td id="field">'.$objForm->inputbox('form['.$row['type'].'-'.$count.']', 'text', $row['val'], $fExtras).'</td>';
                $echo .= '<td id="close">'.$up.'</td>';
                $echo .= '</tr></tbody></table></div></div>';

                if($settings[$row['type']]['unique']){ $hide[] = $row['type']; }
                //add it back to the $populate var
                $populate .= $echo;
            }

            //push the $form stuff back to the JS counters so it can carry on from where we left off
            foreach($form as $k => $v){ $f .= ' form[\''.$k.'\'] = '.$v.';'; }

            if(count($hide)){ 
            	if(count($hide)==1){
            		$f .= ' $("'.implode('", "', $hide).'").hide();'; 
            	}else{
            		$f .= ' $("'.implode('", "', $hide).'").invoke("hide");'; 
            	}
			}
        }
        $objPage->addJSCode('var form = [];'.$f);

        //output to the template
        $objTPL->assign_vars(array(
            'SELECT'         => $return,
            'POPULATE_FORM'  => $populate,

            'HFORM'          => $hForm,
            'HIDDEN_FIELDS'  => $objForm->inputbox('sessid', 'hidden', $sessid).$objForm->inputbox('id', 'hidden', $uid),
        ));
	break;
	
	case 'save':
	   unset($update);
		if (!HTTP_POST && !HTTP_AJAX){
			hmsgDie('FAIL', 'Error: Cannot verify information.');
		}

		//security check 1
        if(doArgs('id', false, $_POST) != $_SESSION['site']['panel']['id']){
            hmsgDie('FAIL', 'Error: I cannot remember what you were saving...hmmmm');
        }
        //security check 2
        if(doArgs('sessid', false, $_POST) != $_SESSION['site']['panel']['sessid']){
            hmsgDie('FAIL', 'Error: I have conflicting information here, cannot continue.');
        }


		//Continue with the checks
        $update = array(); $contact = array();
        if(is_empty($_POST['form'])){ $update['contact_info'] = ''; }
        foreach($_POST['form'] as $type => $option){
            if(is_empty($option)){ continue; }
            $type = preg_replace('/([0-9-]*)/i', '', $type);
            $option = preg_replace('/([0-9-]*)/i', '', $option);

            $contact[] = array('type' => $type, 'val' => $option);
        }

        $update['contact_info'] = json_encode($contact);

		$noUpdate = true;
		//if we have stuff to update
		if(count($update)){
			//try the update
			$update = $objUser->updateUserSettings($uid, $update);
				if(!$update){
					$_SESSION['site']['panel']['error'] = array($objUser->error());
					$objPage->redirect($url, 3);
					exit;
				}
			$noUpdate = false;
		}

        $objUser->reSetSessions($uid);

    	unset($_SESSION['site']['panel']);
        $objPage->redirect($url, 3);
        hmsgDie('OK', implode('<br />', $updateMsg).'<br />'.langVar('L_PRO_UPDATE_SUCCESS'));
	break;


    case 'js':
    $tplVars = $objPage->getVar('tplVars');
	header('Content-type: text/javascript');
	
    $JS = <<<JS
    var j = 0;
    
document.observe("dom:loaded", function(){
	reOrder();
	
	$$("option[class*=ico]").each(function(ele){
		Event.observe(ele, 'click', function(){
			if($(ele).hasClassName('ico') && $(ele).hasClassName('unique')){
				$(ele).hide();
			}
		});
	});
});


function reOrder(){ 
	Sortable.create('contentTarget', {scroll: window, tag:'div', handle: 'label'});
	
	//watch the delete buttons
	$$("a[id=delete]").each(function(ele){
		var da = ele.readAttribute('data-mod');

		if(da != 1){
			Event.observe(ele, 'click', removeRow);
			ele.writeAttribute('data-mod', '1');
		}
	});
}

function removeRow(e){
	Event.stop(e);
	
	var id = $(this).up('div').identify();
	
    Effect.BlindUp(id, { duration: 1.0 });
    setTimeout('$(\''+id+'\').remove();', 2000);

    $(strip(id)).show();
}

function doMe(){
    //grab the element
    ele = $('addBox').options[$('addBox').selectedIndex];
    
    //if by somechance the newb selects the first one, ignore it
    if(ele.id==0){ return; }

    //do a rolling counter for the forms so we /can/ have multiple copies
    if(!isset(form[ele.id])){ form[ele.id] = 0; }
    var count = form[ele.id]++;

    //clone the input
    Move.element('hiddenForm', 'contentTarget', 'copy', ele.id+'-'+count);

    //now we need to get the table fields
    var table = ele.id+'-'+count;
    var title = $$('#'+table+' td[id=title]')[0];
    var field = $$('#'+table+' td[id=field]')[0].down();

    //now toggle the class name, update the title with the selectbox's value and update the form name
    $(table).down().addClassName(((j % 2)==0 ? 'row_color2' : 'row_color1')); j++;
    title.update(ele.innerHTML).addClassName(ele.value).addClassName('label');
    field.writeAttribute('name', 'form['+table+']');
	$(table).show();
    setTimeout(function(){
    	title.scrollTo();
    	Effect.SlideDown(table, {duration: 0.5});
    }, 500);

    //reset it so you can select multiple in succession
    $('addBox').selectedIndex = 0;

    //make sure to execute the reOrder function again to take the new elements into consideration
    reOrder();
}

function strip(pstrSource){
    var m_strOut = new String(pstrSource);
    m_strOut = m_strOut.replace(/[^a-zA-Z]/g, '');
    return m_strOut;
}

var Move = {
    copy: function(e, target, id) {
        var eId      = $(e);
        var copyE    = eId.cloneNode(true);
        var cLength  = copyE.childNodes.length -1;
        copyE.id     = id || e+'-copy';

        for(var i = 0; cLength >= i;  i++) {
            if(copyE.childNodes[i].id) {
                var cNode   = copyE.childNodes[i];
                var firstId = cNode.id;
                cNode.id    = firstId+'-copy';
            }
        }
        $(target).appendChild(copyE);
    },
    element: function(e, target, type, id) {
        var eId =  $(e);
        if(type == 'move') {
           $(target).appendChild(eId);
        }else if(type == 'copy') {
           this.copy(e, target, id);
        }
    }
}

JS;
    die($JS);
    break;

}

$objTPL->parse('body', false);
?>