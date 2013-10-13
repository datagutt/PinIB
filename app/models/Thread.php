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
		* @param integer $threadID ID of thread.
	**/
	public function posts($threadID = 0){
		$post = $this->app->getModel('post');
		
		return $post->posts($threadID);
	}
}