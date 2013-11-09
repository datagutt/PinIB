<?php
namespace PinIB\Models;
class Post extends \PinIB\Model{
	protected $table = 'posts';
	
	/**
		* @param integer $threadID ID of thread.
	**/
	public function posts($threadID = 0){
		$this->redis->del($threadID . ':posts');
		
		if($cache = $this->redis->get($threadID . ':posts')){
			$thread = unserialize($this->redis->get($threadID . ':posts'));
		}else{
			$query = new \PinIB\SQLQuery($this->table);
			$thread = $query->select('posts.*, users.username')
				->join('users', 'posts.user_id = users.id')
				->where(array(
					'thread_id' => $threadID
				))
				->orderBy('created_at ASC')
				->run()
				->fetchAll();
			$this->redis->set($threadID . ':posts', serialize($thread));
		}
		return $thread;
	}
	
	/**
		* @param integer $threadID Thread ID
		* @param string $content Post content.
		* @param string $file File.
		* @param integer $width Width of image.
		* @param integer $height Height of image.
		* @param integer $user_id User id.
		* @param boolean $isAnon If post should be anonymous or not.
	**/
	public function newPost($threadID = 0, $content = '', $file = '', $width = 0, $height = 0, $user_id = 0, $isAnon = 0){
		$query = new \PinIB\SQLQuery($this->table);

		$thread = $query->insert(array(
			'thread_id' => $threadID,
			'content' => $content,
			'file' => $file,
			'width' => $width,
			'height' => $height,
			'user_id' => $user_id,
			'anon' => $isAnon
		))->run();
		
		$this->redis->del($threadID . ':posts');
		
		return $thread;
	}
}