<?php
	include "app/views/".Route::$language.'/register_'.Route::$language.'.php';
?>

<div class='container'>
	<div class='row hidden' id='idBlock1'>
		<div class='col-xs-12'>
			<div id='idMsg' class='alert-dismissible alert-success alert fade in'>
				
			</div>
		</div>
	</div>

	<div class='row' id='idBlock2'>
		<div class='col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3'>
			<div class='panel panel-default'>
				<div class='panel-heading'>
					<h3 class='panel-title'><?php echo $lng['sign_up'];?></h3>
				</div>
				<div class='panel-body'>
					<form id='form' enctype='multipart/form-data'>
						<div id='idBlockUsername' class='form-group field-register-form-username required'>
							<label class='control-label' for='register-form-username'><?php echo $lng['username'];?></label>
							<input type='text' id='register-form-username' class='form-control' name='username'>
							<div id='idHelpUsername' class='help-block'></div>
						</div>
						<div id='idBlockPassword' class='form-group field-register-form-password required'>
							<label class='control-label' for='register-form-password'><?php echo $lng['password'];?></label>
							<input type='password' id='register-form-password' class='form-control' name='password'>
							<div id='idHelpPassword' class='help-block'></div>
						</div>
						<div id='idBlockEmail' class='form-group field-register-form-email required'>
							<label class='control-label' for='register-form-email'><?php echo $lng['email'];?></label>
							<input type='text' id='register-form-email' class='form-control' name='email'>
							<div id='idHelpEmail' class='help-block'></div>
						</div>
						 <div id='idBlockPicture' class='form-group field-register-form-email required'>
							<label for='register-form-picture'><?php echo $lng['avatar'];?></label>
							<input type='file' id='register-form-picture' name='picture'>
							<div id='idHelpPicture' class='help-block'></div>
						 </div>
						<button type='submit' class='btn btn-success btn-block'><?php echo $lng['sign_up'];?></button>
					</form>
				</div>
			</div>
			<p class='text-center'>
				<a href="<?php echo Route::$language.'/main/login'?>"><?php echo $lng['Already_registered?_Sign_in!'];?></a>        
			</p>
		</div>
	</div>
</div>

<script>
	$( document ).ready(function() {

		var elements = {
            formPicture : $('#register-form-picture'),
		    form : $('#form'),

            idMsg : $("#idMsg"),
            idBlock1 : $("#idBlock1"),
            idBlock2 : $("#idBlock2"),

            idBlockUsername : $("#idBlockUsername"),
            idHelpUsername : $("#idHelpUsername"),

            idBlockPassword : $("#idBlockPassword"),
            idHelpPassword : $("#idHelpPassword"),

            idBlockEmail : $("#idBlockEmail"),
            idHelpEmail : $("#idHelpEmail"),

            idBlockPicture : $("#idBlockPicture"),
            idHelpPicture : $("#idHelpPicture"),
        };

		var validateClient = {

		    validate : function (message, idBlock, idHelp) {
                if(message == 'success') {
                    idBlock.removeClass('has-success');
                    idBlock.removeClass('has-error');
                    idHelp.html('');
                    return true;
                }
                else {
                    idBlock.removeClass('has-success');
                    idBlock.addClass('has-error');
                    idHelp.html(message);
                    return false;
                }
            },

            usernameValidate : function () {
                var self = validateClient;

                var data = elements.form.serializeArray();
                var username = data[0].value;
                var message = 'success';

                if(username.length==0){ message = "<?php echo $lng['required'];?>"; }
                else if(username.length<3){ message = "<?php echo $lng['more_3'];?>"; }
                else if(username.length>15){ message = "<?php echo $lng['less_16'];?>"; }
                else if(!(/^[a-z0-9_]+$/i.test(username))) { message = "<?php echo $lng['incorrect'];?>"; }

                return self.validate (message, elements.idBlockUsername, elements.idHelpUsername);
            },

            passwordValidate : function () {
                var self = validateClient;

                var data = elements.form.serializeArray();
                var password = data[1].value;
                var message = 'success';

                if(password.length==0){ message = "<?php echo $lng['required'];?>"; }
                else if(password.length<3){ message = "<?php echo $lng['more_3'];?>"; }
                else if(password.length>15){ message = "<?php echo $lng['less_16'];?>"; }
                else if(!(/^[a-z0-9_]+$/i.test(password))) { message = "<?php echo $lng['incorrect'];?>"; }

                return self.validate (message, elements.idBlockPassword, elements.idHelpPassword);
            },

            emailValidate : function () {
                var self = validateClient;

                var data = elements.form.serializeArray();
                var email = data[2].value;
                var message = 'success';

                if(email.length == 0) { message="<?php echo $lng['required'];?>"; }
                else if(!(/^[a-z0-9_]+@[a-z0-9_]+\.[a-z]{2,6}$/i.test(email))) { message="<?php echo $lng['incorrect'];?>"; }

                return self.validate (message, elements.idBlockEmail, elements.idHelpEmail);
            },

            pictureValidate : function () {
                var self = validateClient;
                var picture = elements.formPicture.val();
                var message = 'success';

                if(picture.length == 0) { message="<?php echo $lng['required'];?>"; }
                else {
                    var parts = picture.split('.');
                    picture = parts[parts.length - 1];
                    picture = picture.toLowerCase();

                    if(picture!='jpg' && picture!='gif' && picture!='png') { message="<?php echo $lng['incorrect_type'];?>"; }
                }

                return self.validate (message, elements.idBlockPicture, elements.idHelpPicture);
            },

        };

        var sendForm = {

            isConnected : false,

            validateMsg : function (message) {
                if(message == 'success') {
                    elements.idBlock1.addClass('hidden');
                    return true;
                }
                else {
                    elements.idBlock1.removeClass('hidden');
                    elements.idMsg.removeClass('alert-success');
                    elements.idMsg.addClass('alert-danger');
                    elements.idMsg.html(message);
                    return false;
                }
            },

            validateForm : function (message, idBlock, idHelp) {
                if(message == 'success') {
                    idBlock.addClass('has-success');
                    idBlock.removeClass('has-error');
                    idHelp.html('');
                    return true;
                }
                else {
                    idBlock.removeClass('has-success');
                    idBlock.addClass('has-error');
                    idHelp.html(message);
                    return false;
                }
            },

            sendAjax : function () {
                var self = sendForm;

                if(!self.isConnected) {
                    self.isConnected = true;

                    $.ajax({
                        type: 'POST',
                        url: "<?php echo Route::$language.'/ajax/registerSend';?>",
                        data: new FormData(elements.form.get(0)),
                        cache: false,
                        contentType: false,
                        processData: false,
                    }).done(self.doneAjax
                    ).fail(function() {
                        self.validateMsg("<?php echo $lng['error'];?>");
                    }).always(function() {
                        self.isConnected = false;
                    });
                }
            },

            doneAjax : function(response) {
                var self = sendForm;

                var msg = 'success';
                var usernameMsg = 'success';
                var passwordMsg = 'success';
                var emailMsg = 'success';
                var pictureMsg = 'success';

                try {
                    var json = JSON.parse(response);
                    msg = json.msg;
                    usernameMsg = json.usernameMsg;
                    passwordMsg = json.passwordMsg;
                    emailMsg = json.emailMsg;
                    pictureMsg = json.pictureMsg;
                } catch (err) {
                    msg = '<?php echo $lng['error'];?>';
                }

                if(msg=='success' && usernameMsg=='success' && passwordMsg=='success' && emailMsg=='success' && pictureMsg=='success') {
                    elements.idBlock1.removeClass('hidden');
                    elements.idMsg.removeClass('alert-danger');
                    elements.idMsg.addClass('alert-success');
                    elements.idMsg.html("<?php echo $lng['successfully_signed_up'];?>");
                    elements.idBlock2.addClass('hidden');
                }
                else {
                    if(self.validateMsg(msg)) {
                        self.validateForm (usernameMsg, elements.idBlockUsername, elements.idHelpUsername);
                        self.validateForm (passwordMsg, elements.idBlockPassword, elements.idHelpPassword);
                        self.validateForm (emailMsg, elements.idBlockEmail, elements.idHelpEmail);
                        self.validateForm (pictureMsg, elements.idBlockPicture, elements.idHelpPicture);
                    }
                }
            },

        };
		
		$('#register-form-username').on('blur', validateClient.usernameValidate);
		$('#register-form-password').on('blur', validateClient.passwordValidate);
		$('#register-form-email').on('blur', validateClient.emailValidate);
        elements.formPicture.on('change', validateClient.pictureValidate);
		
		$('#form').on('submit', function (e) {
            e.preventDefault();

            var isUsername = validateClient.usernameValidate();
            var isPassword = validateClient.passwordValidate();
            var isEmail = validateClient.emailValidate();
            var isPicture = validateClient.pictureValidate();

            if(isUsername && isPassword && isEmail && isPicture) { sendForm.sendAjax(); }

        });
		
	});
	
</script>




















