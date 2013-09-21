<?php
namespace PinIB\Controllers;

class Index extends \PinIB\Controller{
	public function index(){
		//if(User::$loggedin){
		//}
		$thread = $this->app->getModel('thread');
		foreach($thread->posts() as $thread){
			var_dump($thread);
		}
		$this->view->render('front.html', array(
			'threads' => array()
		));
	}
}