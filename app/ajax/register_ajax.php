<?php

class Register_Ajax
{
    //Класс для входа регистрации, ответ в json формате, в случаи успеха данные записываются в бд

	private $usernameMsg = 'success'; // причина ошибки имени пользователя
	private $passwordMsg = 'success'; // причина ошибки имени пароля
	private $emailMsg = 'success'; // причина ошибки имени email
	private $pictureMsg = 'success'; // причина ошибки имени picture
		
	private $msg = 'success'; // иная ошибка
	
	private $db = null; // база данных
	
	private $lng; // языковые сообщения
	
	function __construct() { 
		include "app/views/".Route::$language.'/register_'.Route::$language.'.php';  // подключаем файл с массивом сообщений языка
		$this->lng = $lng; // теперь $lng массив сообщений нужного языка
	}

    // вывод ответа в json формате
	private function response() {
		$json_data = array (
		    'msg'=>$this->msg,
            'usernameMsg'=>$this->usernameMsg,
            'passwordMsg'=>$this->passwordMsg,
            'emailMsg'=>$this->emailMsg,
            'pictureMsg'=>$this->pictureMsg);

		echo json_encode($json_data, JSON_UNESCAPED_UNICODE);
	}

	// проверка на уникальность имени пользователя
	private function usernameUnique($username) {
		$username = mysqli_real_escape_string($this->db, $username);
		
		if($result = mysqli_query($this->db, "SELECT id FROM users WHERE username='$username'")) {
			if($row = mysqli_fetch_assoc($result)) { $this->usernameMsg = $this->lng['already_use']; }
		}
		else{ $this->msg = $this->lng['error']; return false; }
		return true;
	}

    // валидация и если успешно данные записываются в бд
	private function isValid($andSend = false) {
		$username = ''; $password = ''; $email = ''; $filename = '';
		
		$this->usernameMsg = 'success';
		$this->passwordMsg = 'success';
		$this->emailMsg = 'success';
		
		$this->msg = 'success';
		
		if(isset($_POST['username'])) { $username = $_POST['username']; }
		if(isset($_POST['password'])) { $password = $_POST['password']; }
		if(isset($_POST['email'])) { $email = $_POST['email']; }

		if($_FILES['picture']['size'] == 0) { $this->pictureMsg = $this->lng['required']; }
        elseif($_FILES['picture']['error'] != 0) { $this->pictureMsg = $this->lng['error_uploading_file']; }
		else {
            $types = array('image/gif', 'image/png', 'image/jpeg');
            if(!in_array($_FILES['picture']['type'], $types)) { $this->pictureMsg = $this->lng['incorrect_type']; }
            else {
                $filename = 'pictures/'.uniqid();
                if($_FILES['picture']['type'] == 'image/jpeg') { $filename = $filename.'.jpeg'; }
                elseif($_FILES['picture']['type'] == 'image/png') { $filename = $filename.'.png'; }
                elseif($_FILES['picture']['type'] == 'image/gif') { $filename = $filename.'.gif'; }
            }
		}
		
		$username = stripslashes($username); $username = htmlspecialchars($username);
		$password = stripslashes($password); $password = htmlspecialchars($password);
		$email = stripslashes($email); $email = htmlspecialchars($email);
		
		if(strlen($username)==0) { $this->usernameMsg = $this->lng['required'];  }
		elseif(strlen($username)<3) { $this->usernameMsg = $this->lng['more_3']; }
		elseif(strlen($username)>15) { $this->usernameMsg = $this->lng['less_16']; }
		elseif(!preg_match("/^[a-z0-9_]+$/i", $username)) { $this->usernameMsg = $this->lng['incorrect']; }
		elseif(!$this->usernameUnique($username)) { return false; }
		
		if(strlen($password)==0) { $this->passwordMsg = $this->lng['required']; }
		elseif(strlen($password)<3) { $this->passwordMsg = $this->lng['more_3']; }
		elseif(strlen($password)>15) { $this->passwordMsg = $this->lng['less_16']; }
		elseif(!preg_match("/^[a-z0-9_]+$/i", $password)) { $this->passwordMsg = $this->lng['incorrect']; }
		
		if(strlen($email)==0) { $this->emailMsg = $this->lng['required']; }
		elseif(!preg_match("/^[a-z0-9_]+@[a-z0-9_]+\.[a-z]{2,6}$/i", $email)) { $this->emailMsg = $this->lng['incorrect']; }
		
		if($this->usernameMsg!='success' || $this->passwordMsg!='success' || $this->emailMsg!='success' || $this->msg!='success' || $this->pictureMsg!='success') {
			return false;
		}
		
		if($andSend) {
			$username = mysqli_real_escape_string($this->db, $username);
			$password = mysqli_real_escape_string($this->db, $password);
			$email = mysqli_real_escape_string($this->db, $email);

            $tmp_name = $_FILES['picture']['tmp_name'];
            if(move_uploaded_file($tmp_name, $filename)) {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                if($result = mysqli_query($this->db,
                    "INSERT INTO users (username,password,email,picture) VALUES('$username','$hash','$email','$filename')")) { }
                else{ $this->msg = $this->lng['error']; return false; }
            }
            else { $this->pictureMsg = $this->lng['could_not_load_file']; }

		}
	}

    // главный метод регистрации
	public function validate($andSend = false) {
        include "app/core/db.php";

        $this->db = mysqli_connect($host, $username, $passwd, $dbname);
		
		if($this->db) { $this->isValid($andSend); }
		else { $this->msg = $this->lng['error']; }
		
		$this->response(); 
		
		mysqli_close($this->db);
	}
}