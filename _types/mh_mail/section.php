<?php
defined('is_running') or die('Not an entry point...');

/* ####################################################################################### */
/* ##                                      mh Mail                                      ## */
/* ####################################################################################### */
/* ##           Based On Demo Types "Just A Big Icon", "Run Custom Scripts"             ## */
/* ####################################################################################### */
/* локализация */

$section_lang = self::$i18n['section']['lang'];

$UID = uniqid();

$section = array();
$section['values'] = array_merge(array(
  'modal'				=> '1',
  'style'				=> 'button',
  'icon'				=> '1',
  'icon_size'			=> 'fa-lg',
  'color'				=> 'success',
  'text'				=> self::$i18n['section']['langmessage']['send_message'],
  'modal_id'			=> '#mhmm_'.$UID,
  'feedback_type'		=> 'email',
), $sectionCurrentValues );

$section['attributes'] = array(
  'class' => '',
);

$modal_ID = substr($section['values']['modal_id'],1);
$UID = substr($section['values']['modal_id'],6);
$mailbox_ID = 'mhmb_'.$UID;
	

/* ################ content ################## */

$section['content'] = '';

// link/button
$icon_size = $section['values']['icon_size'] != 'fa-1x' ? $section['values']['icon_size'] : '';
$link = ( $section['values']['icon'] || $section['values']['text'] == '') ? 
		'<i class="fa fa-envelope-o '.$icon_size.' mh-mail-icon "></i>': '';
$link .= ( $section['values']['icon'] && $section['values']['text'] != '') ? '&nbsp;' : '';
$link .= $section['values']['text'] != '' ? $section['values']['text'] : '';

if ( $section['values']['style'] == 'button' ) {
	$modal_button = '
		<button type="button" class="btn btn-{{color}}" data-toggle="modal" data-target="#'.$modal_ID.'">
			'.$link.'
		</button>
	';
} else {
	$modal_button = '
		<a href="#" data-toggle="modal" data-target="#'.$modal_ID.'" class="text-{{color}}">
			'.$link.'
		</a>
	';
}


$recaptcha = '';

if( \gp\tool\Recaptcha::isActive() ){
	global $page, $config, $ml_object;
	$recaptcha_theme = 'light';
	$recaptcha_size = 'normal'; //compact, normal
	$lang = $config['recaptcha_language'];
	if( $lang == 'inherit' ){
		$lang = $lang ? $lang : $config["language"]; // Typesetter UI language
		if( !empty($ml_object) ){ // only if Multi-Language Manager is installed
		  $ml_list = $ml_object->GetList($page->gp_index);
		  $ml_lang = is_array($ml_list) && ($ml_lang = array_search($page->gp_index, $ml_list)) !== false ? $ml_lang : false;
		}else{
		  $ml_lang = false;
		}
		$lang = $ml_lang ? $ml_lang : $lang;
	}
	$recaptcha_lang = '?hl='.$lang;
	$mhm_RecaptchaScript = '<script src="https://www.google.com/recaptcha/api.js'.$recaptcha_lang.'&onload=RecaptchaCallback&render=explicit" async defer></script>';
	if ( !strpos($page->head,$mhm_RecaptchaScript) ){
		$page->head .= "\n".$mhm_RecaptchaScript."\n";
	};

	$recaptcha .= '
		<div class="g-recaptcha" id="mhmg_'.$UID.'"></div>
	';

	$javascript = '
		var grecaptchaID = {};
		var RecaptchaCallback = function() {
			var els = document.querySelectorAll(".g-recaptcha");
			for(var i=0; i<els.length; i++){ 
				var g = grecaptcha.render(els[i], {
					"sitekey" : "'.$config['recaptcha_public'].'",
					"theme" : "'.$recaptcha_theme.'",
					"size" : "'.$recaptcha_size.'"
				});
				grecaptchaID[els[i].id] = g;
			}	
		};
	';
}


$mail_form = '
	<form id="mhmf_'.$UID.'" class="mh-mail-form">
		<div class="form-group">
			<span>'.$section_lang['Name'].'</span>
			<i class="fa fa-user"></i>
			<input class="input text form-control mh-mail-username" required="required" type="text" value=""/>
		</div>
';
$mail_form .= $section['values']['feedback_type'] == 'phone' ? '		
		<div class="form-group">
			<span>'.$section_lang['Phone'].'</span>
			<i class="fa fa-phone"></i>
			<input class="input text form-control mh-mail-userphone" required="required" type="tel" value=""/>
		</div>
' : '';		
$mail_form .= $section['values']['feedback_type'] == 'email' ? '		
		<div class="form-group">
			<span>'.$section_lang['Email'].'</span>
			<i class="fa fa-envelope"></i>
			<input class="input text form-control mh-mail-useremail" required="required" type="email" value=""/>
		</div>
' : '';		
$mail_form .= '		
		<div class="form-group">
			<span>'.$section_lang['Message'].'</span>
			<textarea class="input text form-control mh-mail-usermessage" required="required" rows="3" cols="20" value=""></textarea>
		</div>
		'.$recaptcha.'
		<input type="submit" class="hidden d-none"/>
		<br>
	</form>
	<button class="btn btn-success mh-mail-send">'.self::$i18n['section']['langmessage']['send_message'].'</button>
';



$section['content'] .= '
<div id="'.$mailbox_ID.'" class="mh-mail-box">
';

if ( $section['values']['modal'] ) {
	$section['content'] .= '
	'.$modal_button.'
	<div id="'.$modal_ID.'" class="modal fade">
		<div class="modal-dialog modal-lg modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">'.$section_lang['Your_message'].'</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">
				'.$mail_form.'
				</div>
			</div>
		</div>
	</div>
	';
} else {
	$section['content'] .= '
	<div id="'.$modal_ID.'" class="mh-mail-frame">
		'.$mail_form.'
	</div>
	';
}

$section['content'] .= '
</div>
';


/* ################ end of content ################## */

// Recommended: Section Label. If not defined, it will be generated from the folder name.
$section['gp_label'] = 'mh Mail';

// Optional: Always process values - if set to true, content will always be generated by processing values, even when not logged-in.
// Using this option, sections may have dynamic content.
$section['always_process_values'] = false;

// Optional: Admin UI color label. This is solely used in the editor's section manager ('Page' mode)
$section['gp_color'] = '#DE3265';

$components = 'fontawesome, Recaptcha';

$css_files = array( 'style.css' );

// $style = 'body { background:red!important; }';

$js_files = array(
	'script.js',
	'lib/maskedinput.js/jquery.maskedinput.min.js',
); // script.js must reside in this directory (_types/shop_item). Relative and absolute paths are also possible.


//$jQueryCode = '';
