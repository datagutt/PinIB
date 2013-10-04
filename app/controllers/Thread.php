<?php
namespace PinIB\Controllers;

class Thread extends \PinIB\Controller{
	public function index($slug = ''){
		$thread = $this->app->getModel('thread');
		$t = $thread->bySlug($slug);
		
		$this->view->render('thread/thread.html', array(
			'thread' => $t,
			'posts' => $thread->posts($t['id'])
		));
	}
}