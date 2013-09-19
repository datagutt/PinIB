<?php
namespace PinIB\Models;
class Thread extends \PinIB\Model{
	protected $table = 'thread';
	
	public function findMany($amount = 10){
		$stmt = \PinIB\DB::prepare('SELECT * from ' . $this->table. ' ORDER BY published desc LIMIT :amount');
		$stmt->bindParam(':amount', $amount, \PDO::PARAM_INT);
		$result = $stmt->execute();
		
		return $result;
	}
}