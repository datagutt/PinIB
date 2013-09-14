<?php
namespace PinIB\Controllers;

class Index extends \PinIB\Controller{
	public function index(){
		//if(User::$loggedin){
		//}
		$this->view->render('front.html');
	}
}