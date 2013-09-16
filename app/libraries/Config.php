<?php
namespace PinIB;

class Config{
	protected static $redis;
	
	protected static $instance;
	protected static $config = array();
	
	public static function init(){
		self::$redis = new \Predis\Client(false, array('prefix' => 'config:'));
	}
	
	public static function getInstance(){
		if(isset(static::$instance)){
			return static::$instance;
		}else{
			$className = __CLASS__;
			$class = new $className;
			$class->init();
            
			return static::$instance = $class;
		}
	}
	
	public static function exists($key) {
		return isset(self::$config[$key]);
	}
	
	public static function get($name){
		if(!self::$redis->get($name)){
			$stmt = DB::prepare('SELECT * from ::config WHERE name = :name');
			$stmt->bindParam('name', $name, \PDO::PARAM_STR);
			
			$stmt->execute();
			
			$row = $stmt->fetch(\PDO::FETCH_ASSOC);
			
			if($row){
				$this::$redis->set($row['name'], $row['value']);
				self::$config[$row['name']] = $row['value'];
			}else{				
				throw new Exception('That is not a valid config setting!');
			}
		}else{
			self::$config[$name] = self::$redis->get($name);
			return self::$config[$name];
		}
	}
	
	public static function set($name = '', $value = ''){	
		self::$redis->set($name, $value);
		self::$config[$name] = $value;	
		
		$stmt = DB::prepare('INSERT INTO ::config SET name = :name, value = :value 
ON DUPLICATE KEY UPDATE name = :name, value = :value');
		
		$stmt->bindParam('name', $name, \PDO::PARAM_STR);
		if(is_int($value)){
			$stmt->bindParam('value', $value, \PDO::PARAM_INT);
		}else{
			$stmt->bindParam('value', $value, \PDO::PARAM_STR);
		}
		$stmt->execute();
	}
}