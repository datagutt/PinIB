<?php
namespace PinIB\Controllers;

class Auth extends \PinIB\Controller{
	public function index(){
		redirect('/auth/login');
	}
	
	public function login(){
		$this->view->render('auth/login.html');
	}
}
