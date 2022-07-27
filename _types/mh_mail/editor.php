<?php

defined('is_running') or die('Not an entry point...');

$editor_lang = self::$i18n['editor']['lang'];

$editor = array(
  'custom_scripts'  => false,
  'custom_css'      => false,
  'editor_components' =>  false,

  'controls' => array(

    // the controls array keys must match the section's values

    // value 'modal' --start
    'modal' => array(
      'label' => $editor_lang['Modal'],
      'control_type' => 'checkbox',
      'attributes' => array(),
      'on' => array(
      	'CustomSection:formElementsLoaded' => 'function(){$(this).trigger("change")}',
      	'change' => 'function(){ 
			var $c = $("[name = \'values[style]\']").closest(".editor-ctl-box");
			if ( $(this).val() == "1" ) { $c.show(); } else { $c.hide(); };
			var $c = $("[name = \'values[icon]\']").closest(".editor-ctl-box");
			if ( $(this).val() == "1" ) { $c.show(); } else { $c.hide(); };
			var $c = $("[name = \'values[icon_size]\']").closest(".editor-ctl-box");
			if ( $(this).val() == "1" ) { $c.show(); } else { $c.hide(); };
			var $c = $("[name = \'values[color]\']").closest(".editor-ctl-box");
			if ( $(this).val() == "1" ) { $c.show(); } else { $c.hide(); };
			var $c = $("[name = \'values[text]\']").closest(".editor-ctl-box");
			if ( $(this).val() == "1" ) { $c.show(); } else { $c.hide(); };
			var $c = $("[name = \'values[modal_id]\']").closest(".editor-ctl-box");
			if ( $(this).val() == "1" ) { $c.show(); } else { $c.hide(); };
      	 }',
      ),
    ),
    // value 'modal' --end


    // value 'style' --start
    'style' => array(
      'label' => '<i class="fa fa-link"></i> '.$editor_lang['Button_Style'],
      'control_type' => 'select',
      'options' => array(
        'link' => $editor_lang['link'],
        'button' => $editor_lang['button'],
      ),
      'attributes' => array(),
      'on' => array(),
    ), 
    // value 'style' --end


    // value 'text' --start
    'text' => array(
      'label' => '<i class="fa fa-font"></i> '.$editor_lang['Text'],
      'control_type' => 'text',
      'attributes' => array(
        // 'class' => '',
        'placeholder' => '',
        // 'pattern' => '', // regex for validation
      ),
      'on' => array(
      ),
    ),
    // value 'text' --end


    // value 'icon' --start
    'icon' => array(
      'label' => '<i class="fa fa-envelope-o"></i> '.$editor_lang['Icon'],
      'control_type' => 'checkbox',
      'attributes' => array(),
      'on' => array(),
    ),
    // value 'icon' --end


    // value 'icon_size' --start
    'icon_size' => array(
      'label' => '<i class="fa fa-link"></i> '.$editor_lang['Icon_size'],
      'control_type' => 'select',
      'options' => array(
        'fa-1x' => '1x',
        'fa-lg' => 'lg',
        'fa-2x' => '2x',
        'fa-3x' => '3x',
        'fa-4x' => '4x',
        'fa-5x' => '5x',
      ),
      'attributes' => array(),
      'on' => array(),
    ), 
    // value 'icon_size' --end
        

    // value 'color' --start
    'color' => array(
      'label' => '<i class="fa fa-link"></i> '.$editor_lang['Color'],
      'control_type' => 'select',
      'options' => array(
        'primary' 	=> 'primary',
        'secondary' => 'secondary',
        'success' 	=> 'success',
        'danger' 	=> 'danger',
        'warning' 	=> 'warning',
        'info' 		=> 'info',
        'light' 	=> 'light',
        'dark' 		=> 'dark',
        'link' 		=> 'link',
      ),
      'attributes' => array(),
      'on' => array(),
    ), 
    // value 'color' --end


    // value 'modal_id' --start
    'modal_id' => array(
      'label' => '<i class="fa fa-certificate"></i> '.$editor_lang['Modal_ID'],
      'control_type' => 'text',
      'attributes' => array(
      	'readonly' => 'readonly',
        // 'class' => '',
        'placeholder' => '',
        // 'pattern' => '', // regex for validation
      ),
      'on' => array(
      ),
    ),
    // value 'modal_id' --end


    // value 'feedback_type' --start
    'feedback_type' => array(
      'label' => '<i class="fa fa-comment"></i> '.$editor_lang['Feedback_type'],
      'control_type' => 'radio_group',
      'radio-buttons' => array( 
        // radio value => radio label
        'email' => $editor_lang['Email'],
        'phone' => $editor_lang['Phone'],
      ),
      'attributes' => array(),
      'on' => array(),
    ), 
    // value 'feedback_type' --end

  ),

);
