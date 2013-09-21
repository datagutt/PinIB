<?php
namespace PinIB\Models;
class Thread extends \PinIB\Model{
	protected $table = 'threads';
	
	public function  posts($amount = 10){
		$query = new \PinIB\SQLQuery($this->table);
		if($cache = $this->redis->get('threads')){
			$threads = unserialize($cache);
		}else{
			$threads = $query->find('*', false, $amount, 'created_at DESC');
			$this->redis->set('threads', serialize($threads));
		}
		return $threads;
	}
}