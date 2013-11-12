<?php
namespace PinIB\Controllers;
use PinIB\Input;

class Auth extends \PinIB\Controller{
	public function index(){
		redirect('/auth/login');
	}
	
	public function login(){
		if(!\PinIB\Auth::guest()){
			redirect('/');
		}

		if(!Input::post('username') || !Input::post('password')){
			$this->view->render('auth/login.html');
		}else{
			\PinIB\CSRF::check();
			$username = Input::post('username');
			$password = Input::post('password');
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
