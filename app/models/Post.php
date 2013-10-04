<?php
namespace PinIB\Models;
class Post extends \PinIB\Model{
	protected $table = 'posts';
	
	public function posts($threadID = 0){
		$query = new \PinIB\SQLQuery($this->table);
		$thread = $query->find('*', array('thread_id' => $threadID ), false, 'created_at DESC');
		return $thread;
	}
}