<?php
namespace PinIB;

require_once PINIB_PATH . '/app/vendor/PasswordLib/lib/PasswordLib/PasswordLib.php';
class Auth{
	public static function guest(){
		return isset($_SESSION['user']) == false;
	}
	
	public static function get(){
		return isset($_SESSION['user']) ? $_SESSION['user'] : [];
	}
	
	public static function login($username = '', $password = ''){
		$crypt = new \PasswordLib\PasswordLib;
		
		$stmt = DB::prepare("SELECT * FROM ::users WHERE username = :username");
		$stmt->bindParam(':username', $username, \PDO::PARAM_STR);
		$stmt->execute();
		$user = $stmt->fetch();
		if($user && $user['password']){
			$isGood = $crypt->verifyPasswordHash($password, $user['password']);
			if($isGood){
				$_SESSION['user'] = [
					'id' => $user['id'],
					'username' => $user['username'],
					'type' => $user['type']
				];
				return true;
			}
		}
		return false;
	}
	
	public static function logout(){
		@session_destroy();
		redirect('/');
	}
}