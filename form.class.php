<?php

/*
 * Form object
 *

This class makes making html forms way quicker, easier and more intuitive.

An example for outputting a form would be:

THE PHP CODE
$form = new Form('contact_form', 'email.php');
$form->input('text', 'full_name', '', 'Your name');
$form->textarea('comments', 'Type a comment here');
$form->input('submit', 'send_button', 'Send message');
$form->output();

OUTPUTS

<form action="email.php" method="post" name="contact_form">
	<div>
		<label for="contact_form-full_name">Your name</label>
		<input type="text" name="full_name" value="" id="contact_form-full_name"  />
	</div>
	<div>
		<label for="contact_form-comments">Comments</label>
		<textarea name="comments" id="contact_form-comments" >Type a comment here</textarea>
	</div>
	<div>
		<input type="submit" name="send_button" value="Send message" id="contact_form-send_button"  />
	</div>
</form>

*/

 class Form
{

	function __construct($name, $action = '', $method = 'post', $additional_attr = ''){
		$this->formname = $name;
		$this->html = '<form action="'.$action.'" method="'.$method.'" name="'.$name.'" '.$additional_attr.'>'."\n";
	}
	
	/*
		input()  Generate an input tag
		
		$type	str		e.g. button, checkbox, file, hidden, image, password, radio, reset, submit, text
		$name	str		Name the input
		$value	str		(opt) If you want a default value
		$label	str		(opt) Label text, defaults to tag name, set to false for no label (types submit and hidden don't show labels)
		$additional_attr	html	(opt) Append additional attributes to input tag
	*/
	function input($type, $name, $value = '', $label = '', $additional_attr = ''){
		
		if($type == 'radio' || $type == 'checkbox'){
			$label = ($label === '') ? ucwords(str_replace('_', ' ', $value)) : $label;
		}else{
			$label = ($label === '') ? ucwords(str_replace('_', ' ', $name)) : $label;
		}
		$id = $this->formname.'-'.$name;
		if($type == 'checkbox' || $type == 'radio') $id .= '-'.$value;
		
		$this->html .= '<div>';
		if($type != 'submit' && $type != 'hidden' && $label !== NULL) $this->html .= '<label for="'.$id.'">'.$label.'</label>';
		$this->html .= '<input type="'.$type.'" name="'.$name.'" value="'.$value.'" id="'.$id.'" '.$additional_attr.' /></div>'."\n";

	}
	
	
	/*
		checkboxes()  Generates a group of checkboxes
		
		$name		str		The name for the group of checkboxes
		$checkboxes	arr		Array of checkbox values ['This is the value' => 'This is the label', 'This will be both value and label']
		$selected	arr		(opt) Array of values for checkboxes to be checked
	*/
	function checkboxes($name, $checkboxes, $selected = array()){
		
		$name .= '[]';
		foreach($checkboxes as $value => $label){
			if(is_int($value)) $value = $label;
			$select = (in_array($value, $selected)) ? 'checked="checked"' : '';
			$this->input('checkbox', $name, $value, $label, $select);
		}
		
	}
	
	
	/*
		radios()  Generates a group of radio buttons
		
		$name		str		The name of the group of radio buttons
		$radios		arr		Array of radio button values ['This is the value' => 'This is the label', 'This will be both value and label']
		$selected	str		(opt) Value of radio button you want to check
	*/
	function radios($name, $radios, $selected = ''){
		foreach($radios as $value => $label){
			if(is_int($value)) $value = $label;
			$select = ($value == $selected) ? 'checked="checked"' : '';
			$this->input('radio', $name, $value, $label, $select);
		}
	}
	
	
	/*
		select()  Generates a select list
		
		$name		str		The name of the select menu
		$options	arr		Array of options ['option value'=>'option inner html', "both value and option inner html"]
		$selected	str		(opt) Value of option to be selected
		$label		str		(opt) Label text, defaults to tag name, set to false for no label
	*/
	function select($name, $options, $selected = '', $label = ''){
		$id = $this->formname.'-'.$name;
		$label = ($label === '') ? ucwords(str_replace('_', ' ', $name)) : $label;
		$this->html .= '<div>';
		if($label !== false) $this->html .= '<label for="'.$id.'">'.$label.'</label>';
		$this->html .= '<select name="'.$name.'" id="'.$id.'" '.$selected.'>';
		foreach($options as $value => $option){
			$value = (is_int($value)) ? $option : $value;
			$select = ($value == $selected) ? ' selected="selected"' : '';
			$this->html .= '<option value="'.$value.'"'.$select.'>'.$option.'</option>';
		}
		$this->html .= '</select></div>';
	}
	
	
	/*
		textarea()  Generates a textarea
		
		$name	str		The name of the textarea
		$value	str		(opt) If you want to fill the textbox
		$label	str		(opt) Label text, defaults to tag name, set to false for no label
		$additional_attr	html	(opt) Appends additional attributes to textarea tag
	*/
	function textarea($name, $value = '', $label = '', $additional_attr = ''){
		$id = $this->formname.'-'.$name;
		$label = ($label == '') ? ucwords(str_replace('_', ' ', $name)) : $label;
		$this->html .= '<div><label for="'.$id.'">'.$label.'</label><textarea name="'.$name.'" id="'.$id.'" '.$additional_attr.'>'.$value.'</textarea></div>';
	}
	
	
	/*
		write()  Allows HTML to be inserted into the form
		
		$html	str		HTML to be written into the form
	*/
	public function write($html){
		$this->html .= $html;
	}
	
	
	/*
		output()  Echoes out the form html
		
	*/
	public function output(){
		echo $this->html.'</form>';
	}
	
}

?>