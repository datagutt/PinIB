<?php
namespace PinIB\Controllers;
use \PinIB\Input;

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
		
		if(Input::post('thread-content')){
			\PinIB\CSRF::check();
			
			$thread_content = strip_tags(Input::post('thread-content'));
			if($image = Input::post('image')){
				if(\PinIB\Auth::guest()){
					$isAnon = 1;
					$uid = 0;
				}else{
					$isAnon = Input::post('anon') ? Input::post('anon') == 'on' : false;
					$uid = $_SESSION['user']['id'];
				}
				
				$thread->newThread($title, $thread_content, $image, 399, 399, $uid, $isAnon);
			}else{
				// Tell the user that threads MUST include an image
			}
		}
	}
	
	public function reply($slug = ''){
		$thread = $this->app->getModel('thread');
		$post = $this->app->getModel('post');
		
		$t = $thread->bySlug($slug);

		if(Input::post('post-content')){
			\PinIB\CSRF::check();

			$post_content = strip_tags(Input::post('post-content'));
			$image = Input::post('image') ? Input::post('image') : false;
			
			if(\PinIB\Auth::guest()){
				$isAnon = 1;
				$uid = 0;
			}else{
				$isAnon = Input::post('anon') ? Input::post('anon') == 'on' : false;
				$uid = $_SESSION['user']['id'];
			}
			
			$post->newPost($t['id'], $post_content, $image, 399, 399, $uid, $isAnon);
			
			redirect('/thread/' . $slug);
		}
		
	}
}