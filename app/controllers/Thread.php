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
	
	public function newthread(){
		$thread = $this->app->getModel('thread');
		
		$thread->newThread('title', 'http://', 399, 399, 1, $isAnon);
	}
	
	public function reply($slug = ''){
		$thread = $this->app->getModel('thread');
		$post = $this->app->getModel('post');
		
		$t = $thread->bySlug($slug);

		if(isset($_POST['post-content'])){
			\PinIB\CSRF::check();

			$post_content = strip_tags($_POST['post-content']);
			$image = isset($_POST['image']) ? $_POST['image'] : false;
			
			if(\PinIB\Auth::guest()){
				$isAnon = 1;
				$uid = 0;
			}else{
				$isAnon = isset($_POST['anon']) ? $_POST['anon'] == 'on' : false;
				$uid = $_SESSION['user']['id'];
			}
			
			$post->newPost($t['id'], $post_content, $image, 399, 399, $uid, $isAnon);
			
			redirect('/thread/' . $slug);
		}
		
	}
}