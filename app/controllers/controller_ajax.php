<?php

class Controller_Ajax extends Controller
{
    //регистрация пользователя - это для ajax, данные возвращаются в json формате
	function action_registerSend() {	
		include "app/ajax/register_ajax.php";
		$ajax = new Register_Ajax();
		$ajax->validate(true);
	}

	//логинимся - это для ajax, данные возвращаются в json формате
	function action_login() {	
		include "app/ajax/login_ajax.php";
		$ajax = new Login_Ajax();
		$ajax->login();
	}
}