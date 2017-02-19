<?php

class Model_User
{
	function __construct() { session_start(); }

	//получаем данные пользователя из бд, возвращаем массив с данными
	public function getUserData() {
		$returnArray = null;
		$userId = $this->getUserId();
		
		if(!$userId === false){
            include "app/core/db.php";

            $db = mysqli_connect($host, $username, $passwd, $dbname);
		
			if($db) { 
				if($result = mysqli_query($db, "SELECT * FROM users WHERE id='$userId'")) {
					if($row = mysqli_fetch_assoc($result)) {
						$returnArray = $row;
					}
				}
			}
			
			mysqli_close($db);
		}
		
		return $returnArray;
	}

	// полкчаем id пользователя или false
	public function getUserId() {	
		if(isset($_SESSION['userId'])) { return $_SESSION['userId']; }
		else{ return false; }
	}

	// удаляем пользователя из сессии
	public function forgetUser() {
		unset($_SESSION['userId']);
	}
}












