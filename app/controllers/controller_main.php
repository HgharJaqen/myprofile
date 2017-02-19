<?php

class Controller_Main extends Controller
{
	function __construct() { include "app/models/model_user.php"; }

	// главное действие - профиль пользователя
	function action_index() {
		$model = new Model_User();
		if(!$model->getUserId() === false) {
			$data = $model->getUserData();
			if($data == null) {
			    $model->forgetUser();
			    header('Location: '.Route::$baseUrl.Route::$language."/main/index");
			}
			else { $this->generate('profile_view.php', 'template_view.php', $data); }
		}
		else{
			Route::$backPage='main/index';
			$this->generate('login_view.php', 'template_view.php');
		}
	}

	// действие выхода
	function action_logout(){
		$model = new Model_User();
		if(!$model->getUserId() === false) {
			$model->forgetUser();
		}
		header('Location: '.Route::$baseUrl.Route::$language."/main/index");
	}

	// действие входа
	function action_login(){
		$model = new Model_User();
		if(!$model->getUserId() === false){
			header('Location: '.Route::$baseUrl.Route::$language."/main/index");
		}
		else{
			$this->generate('login_view.php', 'template_view.php');
		}
	}

	// действие регистрации
	function action_register() {
		$model = new Model_User();
		if(!$model->getUserId() === false){
			header('Location: '.Route::$baseUrl.Route::$language."/main/index");
		}
		else{
			$this->generate('register_view.php', 'template_view.php');
		}
	}
}