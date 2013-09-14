<?php
namespace PinIB;
class Controller{
	public function __construct($app = NULL){
		$this->app = $app;
		$this->view = $app->view;
		
		$this->view->addFunction('getToken', new \Twig_Function_Function('\\PinIB\\CSRF::getToken'));
		$this->view->addFunction('getUser', new \Twig_Function_Function('\\PinIB\\Auth::get'));
	}
	
	public function index(){
	}
}
