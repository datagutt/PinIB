<?php
namespace PinIB;
class Controller{

	/**
		* @param App $app
	**/
	public function __construct(App $app){
		$this->app = $app;
		$this->view = $app->view;
		
		$this->view->addFunction('getToken', new \Twig_Function_Function('\\PinIB\\CSRF::getToken'));
		$this->view->addFunction('getUser', new \Twig_Function_Function('\\PinIB\\Auth::get'));
		$this->view->addFunction('slug', new \Twig_Function_Function('slug'));
		$this->view->addFunction('ago', new \Twig_Function_Function('ago'));
	}
	
	public function index(){
	}
}
