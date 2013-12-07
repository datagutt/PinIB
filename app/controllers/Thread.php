<?php
namespace PinIB\Controllers;
use \PinIB\Input;

require PINIB_PATH . '/app/libraries/ImageUpload.php';

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
		
		// TODO: Allow guests to post
		if(\PinIB\Auth::guest()){
			return;
		}
		
		if(Input::post('thread-content')){
			\PinIB\CSRF::check();
			
			$thread_content = strip_tags(Input::post('thread-content'));
			if($image = Input::file('image')){
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
		
		// TODO: Allow guests to post
		if(\PinIB\Auth::guest()){
			return;
		}
		
		if(Input::post('post-content')){
			\PinIB\CSRF::check();

			$post_content = strip_tags(Input::post('post-content'));
			$image = Input::file('image');
			
			if(\PinIB\Auth::guest()){
				$isAnon = 1;
				$uid = 0;
			}else{
				$isAnon = Input::post('anon') ? Input::post('anon') == 'on' : false;
				$uid = $_SESSION['user']['id'];
			}
			
			// futuba timestamp
			$new = time().substr(microtime(), 2, 3); 
			$fileName = $new . '.png';
			$containsImage = !empty($fileName) && is_array($image) && !empty($image['tmp_name']);

			$c = new \PinIB\ImageUpload();

			try{
				if($containsImage){
					$c->upload($image, $new);
				}
			}catch(\PinIB\ImageException $e){
				$this->view->render('errors/upload.html', array(
					'error' => $e->getMessage()
				));
				exit;
			}
			
			if(!$containsImage || is_file(UPLOAD_PATH . '/' . $fileName)){
				$post->newPost($t['id'], $post_content, !empty($containsImage) ? $fileName : false, 399, 399, $uid, $isAnon);
				redirect('/thread/' . $slug);
			}else{
				$this->view->render('errors/upload.html', array(
					'error' => 'File could not be uploaded.'
				));
				exit;
			}
		}
		
	}
}