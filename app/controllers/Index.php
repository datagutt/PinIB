<?php
namespace PinIB\Controllers;
use \PinIB\Input;

class Index extends \PinIB\Controller{
	public function index(){
		$thread = $this->app->getModel('thread');

		if(Input::get('noCache') == 1){
			$thread->redis->del('threads');
		}

		$this->view->render('front.html', array(
			'threads' => $thread->threads()
		));
	}
}