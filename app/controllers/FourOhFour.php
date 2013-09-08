<?php
namespace PinIB\Controllers;

class FourOhFour extends \PinIB\Controller{
	public function index(){
		http_response_code(404);
		echo $this->view->render('404.html');
	}
}
