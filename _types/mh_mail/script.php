<?php
defined('is_running') or die('Not an entry point...');

/*
 * We have the following variables to work with:
 * $page                  The $page object
 * $type                  The current section type ID string
 * $types                 Array of all enabled Custom Section types
 * self::$i18n            The language array, empty if none provided
 * $sectionRelativeCode   e.g. /addons/CustomSections/_types/my_section
 * $sectionRelativeData   e.g. /data/_addondata/CustomSections/my_section
 * $sectionPathCode       e.g. /var/www/hosts/my_typesetter/addons/CustomSections/_types/my_section
 * $sectionPathData       e.g. /var/www/hosts/my_typesetter/data/_addondata/CustomSections/my_section
 */

includeFile('tool/email_mailer.php');

$section_lang = self::$i18n['section']['lang'];

global $langmessage, $config;

if( !empty($_POST['id']) ){
	$id = htmlspecialchars(json_decode($_POST['id']));
	$Name = htmlspecialchars(json_decode($_POST['Name']));
	$Phone = htmlspecialchars(json_decode($_POST['Phone']));
	$Email = htmlspecialchars(json_decode($_POST['Email']));
	$Message = htmlspecialchars(json_decode($_POST['Message']));
	$Captcha = boolval(json_decode(filter_input(INPUT_POST, 'Captcha', FILTER_SANITIZE_ENCODED)));

	$PageURL = htmlspecialchars(json_decode($_POST['PageURL']));

	$page->ajaxReplace = array();


	if( !$Captcha ){
		message($section_lang['ReCaptcha']);
		return 'return';
	}

	if( !empty($Name) && ( !empty($Phone) || !empty($Email)) ){
		$mail = new \gp_phpmailer();
		$mail->CharSet = 'UTF-8';
		$mail->SetFrom($config['from_address'], $config['from_name']);
		$mail->AddAddress($config['toemail'], $config['toname']);
		$mail->Subject = $Name;
		$mail->Body  = '<strong>'.$section_lang['Name'].'</strong> - '.$Name.'<br/>';
		$mail->Body .= !empty($Phone) ? '<strong>'.$section_lang['Phone'].'</strong> - '.$Phone.'<br/>' : '';
		$mail->Body .= !empty($Email) ? '<strong>'.$section_lang['Email'].'</strong> - '.$Email.'<br/>' : '';
		$mail->Body .= '<strong>'.$section_lang['Page'].'</strong> - '.$PageURL.'<br/>'.
						'<strong>'.$section_lang['Message'].'</strong><br>'.$Message;
		$mail->IsHTML(true);
		$mail->AllowEmpty = true;

		if( $mail->Send() ) {
			message($section_lang['Success']);
			$page->ajaxReplace[] = array('trigger','#'.$id,'success');
		}
		else {
			message($section_lang['Oops']);
		}
	}
}
return 'return';
