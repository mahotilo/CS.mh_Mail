$(document).ready(function() {

//send command to script.php
	$('.mh-mail-send').on('click', function(event){
		event.preventDefault();
		var $form = $(this).siblings('form');
		var result = $form[0].checkValidity();
		if (result) {
			var ID = $(this).closest('.mh-mail-box').attr('id');
			var Name = $form.find('.mh-mail-username');
			var Phone = $form.find('.mh-mail-userphone');
			var Email = $form.find('.mh-mail-useremail');
			var Message = $form.find('.mh-mail-usermessage');
			var gid = $form.find('.g-recaptcha').attr('id');
			var Captcha = (typeof grecaptcha != "undefined") ? grecaptcha.getResponse(grecaptchaID[gid]).length != 0 : true;
			var href = window.location.href;
			var data = 'cmd=custom_sections_cmd' // MANDATORY!
						+ '&type=mh_mail'  // MANDATORY!
						+ '&id=' + JSON.stringify(ID)
						+ '&Name=' + JSON.stringify(Name.val())
						+ '&Phone=' + JSON.stringify(Phone.val())
						+ '&Email=' + JSON.stringify(Email.val())
						+ '&Message=' + JSON.stringify(Message.val())
						+ '&Captcha=' + JSON.stringify(Captcha)
						+ '&PageURL=' + JSON.stringify(window.location.hostname+window.location.pathname)
						;
			$gp.loading();
			$gp.postC(href,data);
		} else {
			$form.find(':submit').click();
		}
	});



//cath result from mailer
	$(".mh-mail-box").on("success", function(event){
		event.preventDefault();
		var gid = $(this).find('.g-recaptcha').attr('id');
		if (typeof grecaptcha != "undefined")
		grecaptcha.reset(grecaptchaID[gid]);
		$(this).find('form').trigger('reset');
		$(this).find('.modal').modal('hide');
	});



//MaskedInput
	$('input.mh-mail-userphone').mask('(999) 999-99-99',{placeholder:" "});


});
