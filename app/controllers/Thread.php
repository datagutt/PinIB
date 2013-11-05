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
		
		if(isset($_POST['post-content']) && isset($_POST['image'])){
			$post_content = strip_tags($_POST['post-content']);
			$image = $_POST['image'];
			
			if(Auth::guest()){
				$isAnon = 1;
				$uid = $_SESSION['user']['id'];
			}else{
				$isAnon == isset($_POST['anon']) ? $_POST['anon'] == '1' : false;
				$uid = 0;
			}
			
			$post->newPost($t['id'], $post_content, $image, 399, 399, $uid, $isAnon);
		}
	}
}