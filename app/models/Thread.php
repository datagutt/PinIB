<?php
namespace PinIB\Models;
class Thread extends \PinIB\Model{
	protected $table = 'threads';
	
	/**
		* @param integer $amount Amount of threads.
	**/
	public function threads($amount = 10){
		$query = new \PinIB\SQLQuery($this->table);
		if($cache = $this->redis->get('threads')){
			$threads = unserialize($cache);
		}else{
			$threads = $query->find('*', array(), $amount, 'created_at DESC');
			$this->redis->set('threads', serialize($threads));
		}
		return $threads;
	}
	
	/**
		* @param slug $slug Slug
	**/
	public function bySlug($slug = ''){
		$query = new \PinIB\SQLQuery($this->table);
		$thread = $query->findOne('*', array('slug' => $slug), false, 'created_at DESC');
		return $thread;
	}
	
	/**
		* @param string $title Thread title.
		* @param string $file File.
		* @param integer $width Width of image.
		* @param integer $height Height of image.
		* @param integer $user_id User id.
	**/
	public function newThread($title = '', $file = '', $width = 0, $height = 0, $user_id = 0){
		$query = new \PinIB\SQLQuery($this->table);

		$thread = $query->insert(array(
			'title' => $title,
			'slug' => \slug($title),
			'file' => $file,
			'width' => $width,
			'height' => $height,
			'user_id' => $user_id
		))->run();
		return $thread;
	}
	
	/**
		* @param integer $threadID Thread ID
	**/
	public function posts($threadID = 0){
		$post = $this->app->getModel('post');
		
		return $post->posts($threadID);
	}
}