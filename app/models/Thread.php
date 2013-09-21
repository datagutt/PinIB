<?php
namespace PinIB\Models;
class Thread extends \PinIB\Model{
	protected $table = 'threads';
	
	public function  posts($amount = 10){
		$query = new \PinIB\SQLQuery($this->table);
		$result = $query->find('*', false, $amount, 'created_at DESC')->fetchAll();
		
		return $result;
	}
}