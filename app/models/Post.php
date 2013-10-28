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
	
	/**
		* @param string $content Post content.
		* @param string $file File.
		* @param integer $width Width of image.
		* @param integer $height Height of image.
		* @param integer $user_id User id.
	**/
	public function newPost($content = '', $file = '', $width = 0, $height = 0, $user_id = 0){
		$query = new \PinIB\SQLQuery($this->table);

		$thread = $query->insert(array(
			'content' => $content,
			'slug' => \slug($title),
			'file' => $file,
			'width' => $width,
			'height' => $height,
			'user_id' => $user_id
		))->run();
		return $thread;
	}
}