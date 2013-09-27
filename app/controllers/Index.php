<?php
namespace PinIB\Controllers;

class Index extends \PinIB\Controller{
	public function index(){
		$thread = $this->app->getModel('thread');
		
		if(isset($_GET['noCache']) && $_GET['noCache'] == 1){
			$thread->redis->del('thread');
		}
				
		$this->view->render('front.html', array(
			'threads' => $thread->posts()
		));
	}
}