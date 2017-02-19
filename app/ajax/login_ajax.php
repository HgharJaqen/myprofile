<?php

class Login_Ajax
{
    //Класс для входа пользователя, ответ в json формате, в случаи успеха id пользователя сохраняются в $_SESSION['userId']

	private $usernameMsg = 'success'; // причина ошибки имени пользователя
	private $passwordMsg = 'success'; // причина ошибки пароля
		
	private $msg = 'success'; // иная ошибка
	
	private $db = null; // база данных
	
	private $lng; // языковые сообщения
	
	function __construct() { 
		include "app/views/".Route::$language.'/login_'.Route::$language.'.php'; // подключаем файл с массивом сообщений языка
		$this->lng = $lng; // теперь $lng массив сообщений нужного языка
	}

	// вывод ответа в json формате
	private function response() {
		$json_data = array (
		    'msg'=>$this->msg,
            'usernameMsg'=>$this->usernameMsg,
            'passwordMsg'=>$this->passwordMsg,
            'backPage'=>Route::$language.'/'.Route::$backPage);
		echo json_encode($json_data, JSON_UNESCAPED_UNICODE);
	}

	// валидация и если успешно логинимся $_SESSION['userId'] = id пользователя
	private function isValid() {
		$username = ''; $password = '';
		
		$this->usernameMsg = $this->lng['username_is_not_found']; 
		$this->passwordMsg = $this->lng['password_incorrect']; 
		$this->msg = $this->lng['error'];
		
		if(isset($_POST['username'])) { $username = $_POST['username']; }
		if(isset($_POST['password'])) { $password = $_POST['password']; }
		
		$username = stripslashes($username); $username = htmlspecialchars($username);
		$password = stripslashes($password); $password = htmlspecialchars($password);
		
		$username = mysqli_real_escape_string($this->db, $username);
		$password = mysqli_real_escape_string($this->db, $password);
		
		if($result = mysqli_query($this->db, "SELECT * FROM users WHERE username='$username'")) {
			$this->msg = "success";
			if($row = mysqli_fetch_assoc($result)) { 
				$this->usernameMsg = "success";
				if(password_verify($password, $row['password'])) {
					$this->passwordMsg = 'success';
					
					session_start();
					$_SESSION['userId'] = $row['id'];
				}
			}
		}
	}

	// главный метод логина
	public function login() {
        include "app/core/db.php";

		$this->db = mysqli_connect($host, $username, $passwd, $dbname);
		
		if($this->db) { $this->isValid(); }
		else { $this->msg='error'; }
		
		$this->response();
		
		mysqli_close($this->db);
	}
}


	