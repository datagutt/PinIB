<?php
namespace PinIB\Controllers;

class Index extends \PinIB\Controller{
	public function index(){
		//if(User::$loggedin){
		//}
		$thread = $this->app->getModel('thread');
		$this->view->render('front.html', array(
			'threads' => $thread->posts()
		));
	}
}