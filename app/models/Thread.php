<?php
namespace PinIB\Models;
class Thread extends \PinIB\Model{
	protected $table = 'thread';
	
	public function findMany($amount = 10){
		$stmt = \PinIB\DB::prepare('SELECT * from ' . $this->table. ' WHERE amount = :amount ORDER BY published desc');
		$stmt->bindParam(':amount', $amount, \PDO::PARAM_STR);
		$result = $stmt->execute();
		
		return $result;
	}
}