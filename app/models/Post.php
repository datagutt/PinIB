<?php
namespace PinIB\Models;
class Post extends \PinIB\Model{
	protected $table = 'posts';
	
	/**
		* @param integer $threadID ID of thread.
	**/
	public function posts($threadID = 0){
		$query = new \PinIB\SQLQuery($this->table);
		$thread = $query->select('posts.*, users.username')
			->join('users', 'posts.user_id = users.id')
			->where(array(
				'thread_id' => $threadID
			))
			->orderBy('created_at DESC')
			->run()
			->fetch();
		return $thread;
	}
}