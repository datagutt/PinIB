<?php
namespace PinIB\Controllers;

class Auth extends \PinIB\Controller{
	public function index(){
		#redirect('/auth/login');
		echo 'index';
	}
	
	public function login(){
		echo 'login';
	}
}
