<?php
	include "app/views/".Route::$language.'/login_'.Route::$language.'.php';
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
					<h3 class='panel-title'><?php echo $lng['sign_in'];?></h3>
				</div>
				<div class='panel-body'>
					<form id='form'>
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
						
						<button type='submit' class='btn btn-success btn-block'><?php echo $lng['sign_in'];?></button>
					</form>
				</div>
			</div>
			<p class='text-center'>
				<a href="<?php echo Route::$language.'/main/register'?>"><?php echo $lng['Dont_have_an_account?_Sign_up!'];?></a>        
			</p>
		</div>
	</div>
</div>

<script>
	$( document ).ready(function() {

        var elements = {
            form : $('#form'),

            idMsg : $("#idMsg"),
            idBlock1 : $("#idBlock1"),
            idBlock2 : $("#idBlock2"),

            idBlockUsername : $("#idBlockUsername"),
            idHelpUsername : $("#idHelpUsername"),

            idBlockPassword : $("#idBlockPassword"),
            idHelpPassword : $("#idHelpPassword"),

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

                return self.validate (message, elements.idBlockUsername, elements.idHelpUsername);
            },

            passwordValidate : function () {
                var self = validateClient;

                var data = elements.form.serializeArray();
                var password = data[1].value;
                var message = 'success';

                if(password.length==0){ message = "<?php echo $lng['required'];?>"; }

                return self.validate (message, elements.idBlockPassword, elements.idHelpPassword);
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
                        url: "<?php echo Route::$language.'/ajax/login';?>",
                        data: elements.form.serialize(),
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

                var backPage = '';
                var msg = 'success';
                var usernameMsg = 'success';
                var passwordMsg = 'success';

                try {
                    var json = JSON.parse(response);
                    msg = json.msg;
                    usernameMsg = json.usernameMsg;
                    passwordMsg = json.passwordMsg;
                    backPage = json.backPage;
                } catch (err) {
                    msg = '<?php echo $lng['error'];?>';
                }

                if(msg=='success' && usernameMsg=='success' && passwordMsg=='success') {
                    $(location).attr('href', backPage);
                }
                else {
                    if(self.validateMsg(msg)) {
                        self.validateForm (usernameMsg, elements.idBlockUsername, elements.idHelpUsername);
                        self.validateForm (passwordMsg, elements.idBlockPassword, elements.idHelpPassword);
                    }
                }
            },

        };

        $('#register-form-username').on('blur', validateClient.usernameValidate);
        $('#register-form-password').on('blur', validateClient.passwordValidate);

        $('#form').on('submit', function (e) {
            e.preventDefault();

            var isUsername = validateClient.usernameValidate();
            var isPassword = validateClient.passwordValidate();

            if(isUsername && isPassword) { sendForm.sendAjax(); }

        });
		
	});
	
</script>




















