<?php
namespace PinIB\Models;
class Thread extends \PinIB\Model{
	protected $table = 'threads';
	
	public function threads($amount = 10){
		$query = new \PinIB\SQLQuery($this->table);
		if($cache = $this->redis->get('threads')){
			$threads = unserialize($cache);
		}else{
			$threads = $query->find('*', false, $amount, 'created_at DESC');
			$this->redis->set('threads', serialize($threads));
		}
		return $threads;
	}
	
	public function bySlug($slug = ''){
		$query = new \PinIB\SQLQuery($this->table);
		$thread = $query->findOne('*', array('slug' => $slug), false, 'created_at DESC');
		return $thread;
	}
	
	public function posts($threadID = 0){
		$post = $this->app->getModel('post');
		
		return $post->posts($threadID);
	}
}