<?php
namespace PinIB\Controllers;

class Auth extends \PinIB\Controller{
	public function index(){
		redirect('/auth/login');
	}
	
	public function login(){
		if(!\PinIB\Auth::guest()){
			redirect('/');
		}

		if(!isset($_POST['username']) || !isset($_POST['password'])){
			$this->view->render('auth/login.html');
		}else{
			\PinIB\CSRF::check();
			$username = $_POST['username'];
			$password = $_POST['password'];
			if(\PinIB\Auth::login($username, $password)){
				redirect('/');
			}else{
				$this->view->render('errors/nologinforyou.html');
			}
		}
	}
	
	public function logout(){
		\PinIB\CSRF::check();
		\PinIB\Auth::logout();
	}
}
