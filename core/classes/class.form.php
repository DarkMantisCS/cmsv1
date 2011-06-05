<?php
/*======================================================================*\
||              Cybershade CMS - Your CMS, Your Way                     ||
\*======================================================================*/
if(!defined('INDEX_CHECK')){ die('Error: Cannot access directly.'); }

/**
* Class to create and maintain forms
*
* @version     1.0
* @since       1.0.0
* @author      xLink
*/
class form extends coreClass{

	/**
	 * Starts a new form off
	 *
	 * @version	1.0
	 * @since   1.0.0
	 * @author  xLink
	 *
	 * @param   string $name 	Name of the form
	 * @param   array  $args	Arguments to pass to the form header
	 *
	 * @return  string
	 */
	public function start($name, $args=array()){
		$args = array(
			'method'        => doArgs('method', 	null, 	$args),
			'action'        => doArgs('action', 	null, 	$args),
			'onsubmit'      => doArgs('onsubmit', 	false, 	$args),
			'extra'      	=> doArgs('extra', 		null, 	$args),
			'validate'    	=> doArgs('validate', 	true, 	$args),
		);

		return '<form name="'.$name.'" id="'.$name.'" '.
					(!is_empty($args['method'])     ? 'method="'.$args['method'].'" ' 		: 'method="'.$_SERVER['PHP_SELF'].'" ').
					(!is_empty($args['action'])     ? 'action="'.$args['action'].'" ' 		: null).
					($args['onsubmit']   			? 'onsubmit="'.$args['onsubmit'].'" ' 	: null).
					($args['validate']===false 		? 'novalidate="novalidate" '  			: null).
					(!is_empty($args['extra'])      ? $args['extra'] 						: null).
				'>'."\n";
	}

	/**
	 * Finishes the form - mebe useful for something else in the future
	 *
	 * @version	1.0
	 * @since   1.0.0
	 * @author  xLink
	 *
	 * @return  string
	 */
	public function finish(){
		return '</form>';
	}

	/**
	 * Mould for the input tag, this supports a fair amount of tags
	 *
	 * @version	1.0
	 * @since   1.0.0
	 * @author  xLink
	 *
	 * @param   string 	$name
	 * @param   string 	$type
	 * @param   string 	$value
	 * @param   array 	$args
	 *
	 * @return  string
	 */
	public function inputbox($name, $type='text', $value='', $args=array()){
		$args = array(
			'id'            => doArgs('id', 			$name, 	$args),
			'class'         => doArgs('class', 			null, 	$args),
			'checked'       => doArgs('checked', 		false, 	$args),
			'disabled'      => doArgs('disabled', 		false, 	$args),
			'br'            => doArgs('br', 			false, 	$args),
			'extra'         => doArgs('extra', 			null, 	$args),
			'xssFilter'     => doArgs('xssFilter', 		true, 	$args),

			//HTML5 tag additions
			'required'     	=> doArgs('required', 		false, 	$args),
			'placeholder'   => doArgs('placeholder', 	null, 	$args),
			'autofocus'     => doArgs('autofocus', 		false, 	$args),
			'min'   		=> doArgs('min', 			0, 		$args, 'is_number'),
			'max'     		=> doArgs('max', 			0, 		$args, 'is_number'),
			'step'     		=> doArgs('step', 			0, 		$args, 'is_number'),

			//CMS addition - will set the field to auto complete usernames
			'autocomplete'  => doArgs('autocomplete', 	true, 	$args),
		);

		$typeVali = array( 'button', 'checkbox', 'file', 'hidden', 'image', 'password', 'radio', 'reset', 'submit', 'text',
							//html5 specials
							'email', 'url', 'number', 'range', 'search', 'datetime-local', 'datetime', 'date', 'time', 'week', 'month' );

		return '<input type="'.(in_array($type, $typeVali) ? $type : 'text').'" '.
					'class="'.$args['class'].'" name="'.$name.'" id="'.$args['id'].'" '.
					($args['xssFilter']===true			? 'value="'.htmlspecialchars($value).'" ' 	: 'value="'.$value.'" ').

					(!is_empty($args['placeholder'])	? 'placeholder="'.$args['placeholder'].'" ' : null).
					($args['required']===true 			? 'required="required" ' 					: null).
					(!is_empty($args['autofocus'])		? 'autofocus="'.$args['autofocus'].'" ' 	: null).

					(!is_empty($args['min'])			? 'min="'.$args['min'].'" ' 				: null).
					(!is_empty($args['max'])			? 'max="'.$args['max'].'" ' 				: null).
					(!is_empty($args['step'])			? 'step="'.$args['step'].'" ' 				: null).

					($args['checked']===true			? 'checked="checked" '						: null).
					($args['disabled']===true			? 'disabled="disabled" '					: null).
					($args['autocomplete']===false		? 'autocomplete="off" '						: null).
					(!is_empty($args['extra'])			? $args['extra']							: null).
				'/>'.
					($args['br']===true					? '<br />'."\n"								: '');
	}

	/**
	 * Output a textarea input box
	 *
	 * @version	1.0
	 * @since   1.0.0
	 * @author  xLink
	 *
	 * @param   string 	$name
	 * @param   string 	$value
	 * @param   array	$args
	 *
	 * @return  string
	 */
	public function textarea($name='textarea', $value=null, $args=array()){
		$args = array(
			'cols'      => doArgs('cols', 45, $args),
			'rows'      => doArgs('rows', 5, $args),

			'id'		=> doArgs('id', $name, $args),
			'class'     => doArgs('class', null, $args),
			'disabled'  => doArgs('disabled', false, $args),
			'br'        => doArgs('br', false, $args),
			'extra'     => doArgs('extra', null, $args),
			'xssFilter' => doArgs('xssFilter', true, $args),
			'placeholder'   => doArgs('placeholder', 	null, 	$args),
		);

		return '<textarea '.
					'name="'.$name.'" id="'.$args['id'].'" '.
					'class="'.($args['class']).'" '.
					'cols="'.(is_number($args['cols']) 	? $args['cols'] 			: 45).'" '.
					'rows="'.(is_number($args['rows']) 	? $args['rows'] 			: 5).'"'.
					(!is_empty($args['placeholder'])	? 'placeholder="'.$args['placeholder'].'" ' : null).
					(!is_empty($args['extra'])  		? $args['extra']            : null).
					($args['disabled']===true   		? 'disabled="disabled" '    : null).
				'>'.($args['xssFilter']===true  		? htmlspecialchars($value)  : $value).'</textarea>'.
					($args['br']===true         		? '<br />'."\n"             : '');
	}

	/**
	 * Output a submit or reset button
	 *
	 * @version	1.0
	 * @since   1.0.0
	 * @author  xLink
	 *
	 * @param   string 	$name
	 * @param   string 	$value
	 * @param   array 	$args
	 *
	 * @return  string
	 */
	public function button($name=null, $value, $args=array()){
		$type = ($name=='submit' ? 'submit' : ($name=='reset' ? 'reset' : doArgs('type', 'button', $args)));
		$name = doArgs('name', $name, $args);

		return $this->inputbox($name, $type, $value, $args);
	}

	/**
	 * New Radio Button
	 *
	 * @version	1.0
	 * @since   1.0.0
	 * @author  xLink
	 *
	 * @param   string 	$name
	 * @param   string 	$value
	 * @param   string 	$defaultSetting
	 * @param   array 	$args
	 *
	 * @return  string
	 */
	public function radio($name='radio', $value=array(), $defaultSetting=null, $args=array()){
		$args = array(
			'id'		=> doArgs('id', $name, $args),
			'class'     => doArgs('class', null, $args),
			'disabled'  => doArgs('disabled', false, $args),
			'br'        => doArgs('br', false, $args),
			'xssFilter' => doArgs('xssFilter', true, $args),

			'showValue' => doArgs('showValue', true, $args),
		);

		$return = null;
		foreach($val as $key => $value){
			$value = ($args['xssFilter']===true ? htmlspecialchars($value) : $value);
			$return .= ($args['showLabels']===true ? '<label>' : '').
							'<input type="radio"'.
								'name="'.$name.'" id="'.$args['id'].'" '.
								($args['xssFilter']===true    			? 'value="'.htmlspecialchars($key).'" ' : 'value="'.$key.'" ').
								($defaultSetting==$key                  ? 'checked="checked" '      			: null).
							'/>'.($args['showValue']===true             ? ' '.$value                			: null).
						($args['showLabels']===true ? '</label>' : '').
								($args['br']===true                     ? '<br />'."\n"             			: '');
		}


		return $return;
	}

	/**
	 * Created a new checkbox
	 *
	 * @version	1.0
	 * @since   1.0.0
	 * @author  xLink
	 *
	 * @param   string 	$name
	 * @param   string 	$value
	 * @param   bool 	$checked
	 * @param   array 	$args
	 *
	 * @return  string
	 */
	public function checkbox($name='check', $value='', $checked=false, $args=array()){
		$args['checked'] = $checked;

		return $this->inputbox($name, 'checkbox', $value, $args);
	}

	/**
	 * Select box tag - convert any array to a select box...i think :D
	 *
	 * @version	1.0
	 * @since   1.0.0
	 * @author  xLink
	 *
	 * @param   string 	$name
	 * @param   array 	$options
	 * @param   array 	$args
	 *
	 * @return  string
	 */
	public function select($name, $options, $args=array()){
		$args = array(
			'id'		=> doArgs('id', 		$name, $args),
			'selected'  => doArgs('selected', 	null, $args),
			'noKeys'  	=> doArgs('noKeys', 	false, $args),
			'multi'		=> doArgs('multi', 		false, $args),

			'class'     => doArgs('class', 		null, $args),
			'disabled'  => doArgs('disabled', 	false, $args),
			'extra'     => doArgs('extra', 		null, $args),
			'xssFilter' => doArgs('xssFilter', 	true, $args),
		);

		//added support for multiple selections
		if($args['multi']===true){
			$name = $name.'[]';
			$args['extra'] .= ' multiple="multiple"';
		}

		$extra = $args['extra'];
		$selected = $args['selected'];
		$noKeys = $args['noKeys'];

		$option = '<option value="%1$s"%2$s>%3$s</option>'."\n";
		$val = sprintf('<select name="%1$s" id="%2$s"%3$s%4$s%5$s>',
					$name,
					$args['id'],
					(!is_empty($args['class']) 	? ' class="'.$args['class'].'"' : null),
					($args['disabled']===true 	? ' disabled="disabled"' 		: null),
					(!is_empty($args['extra'])  ? ' '.$args['extra'] 			: null)
				)."\n";


		foreach($options as $k => $v){
			if(is_array($v)){
				$val .= sprintf('<optgroup label="%s">'."\n", $k);
				foreach($v as $a => $b){
					if(is_array($b)){
						$val .= $this->processSelect($b, $selected, $noKeys);
					}else{
						$val .= sprintf($option,
											$a,
											(md5($a)==md5($selected) ? ' selected="true"' : null),
											($noKeys===true ? $a : $b)
										);
					}
				}
			}else{
				$val .= sprintf($option,
									$k,
									(md5($k)==md5($selected) ? ' selected="true"' : null),
									($noKeys===true ? $k : $v)
								);
			}
		}
		$val .= '</select>'."\n";
		return $val;
	}

	/**
	 * Private recursion for select tag.
	 *
	 * @version	1.0
	 * @since   1.0.0
	 * @author  xLink
	 *
	 * @param   array 	$options
	 * @param   string 	$selected
	 * @param   bool	$noKeys
	 *
	 * @return  string
	 */
	private function processSelect($options, $selected, $noKeys=false){
		foreach ($options as $k => $v){
			if(is_array($v)){
				foreach($v as $a => $b){
					if(is_array($b)){
						$val .= $this->processSelect($b, $selected, $noKeys);
					}else{
						$val .= '<option value="'.$a.'"'.(md5($a)==md5($selected) ? ' selected="true" ' : null).'>'.
									($noKeys===true ? $b : $a).'</option>'."\n";
					}
				}
			}else{
				$val .= '<option value="'.$k.'"'.(md5($k)==md5($selected) ? ' selected="true" ' : null).'>'.
							($noKeys===true ? $v : $k).'</option>'."\n";
			}
		}
		return $val;
	}


	public function outputForm($vars, $elements){
		//make sure we have something to use before continuing
		if(is_empty($elements)){ $this->setError('Nothing to output'); return false; }

		if(!isset($elements['field']) || is_empty($elements['field'])){
			$this->setError('Fields are blank or undetectable, make sure they are set using \'field\' key.');
			return false;
		}

		//init the template, give it a rand id to stop it clashing with anything else
		$randID = inBetween('name="', '"', $vars['FORM_START']);
		$this->objTPL->set_filenames(array(
			'form_body_'.$randID => 'modules/core/template/formOutput.tpl',
		));

		$this->objTPL->assign_vars($vars);

		$this->objTPL->reset_block_vars('form_error');
		if(isset($elements['errors']) && !is_empty($elements['errors'])){
			$this->objTPL->assign_block_vars('form_error', array(
				'ERROR_MSG' => implode('<br />', $elements['errors']),
			));
		}


		$this->objTPL->reset_block_vars('field');
		//loop thru each element
		foreach($elements['field'] as $label => $field){
			if(is_empty($field)){ continue; }

			$formVars = array();

			//grab the description before we play with the $label
			$desc = $elements['desc'][$label];

			//upper care the words
			$label = ucwords($label);

			//if its a header, set it as one with a hr under
			if($field == '_header_'){
				$label = '<h3>'.$label.'</h3><hr />';
			}

			//assign some vars to the template
			$this->objTPL->assign_block_vars('field', array(
				'L_LABEL' 		=> $label,
				'L_LABELFOR'	=> inBetween('name="', '"', $field),

				'F_ELEMENT' 	=> ($field == '_header_' ? '' : $field),
				'F_INFO'		=> $desc,
			));

			//if this isnt a 'header' then output the label
			if($field != '_header_'){
				$this->objTPL->assign_block_vars('field.label', array());
			}

			//if we have a description, lets output it with the label
			if(!is_empty($desc)){
				$this->objTPL->assign_block_vars('field.desc', array());
			}
		}

		//return the html all nicely parsed etc
		return $this->objTPL->get_html('form_body_'.$randID);
	}

	function loadCaptcha($var){
		return $this->objPlugins->hook('CMSForm_Captcha', $var);
	}
}
?>