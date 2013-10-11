<?php
namespace PinIB;
use PDO;

class DB{

	public static $connected = false;
	private static $debug = true;
	private static $prefix;
	private static $instance;
	
	private function __construct(){} 
	
	private function __clone(){} 
	
	public static function getInstance(){
		global $config;
		$dsn = sprintf('%s:dbname=%s;host=%s;charset=utf8', $config['db']['type'], $config['db']['database'], $config['db']['host']);
		
		self::$prefix = $config['db']['prefix'];
		
		try{
			self::$connected = true;
			self::$instance = new PDO($dsn, $config['db']['username'], $config['db']['password'], [
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_PERSISTENT => true
			]);
		}catch(PDOException $e){
			die('Database is down.');
		}
		return self::$instance; 
	}
	
	/**
		* @param string $query SQL query.
		* @param array $options Database options.
	**/
	public static function prepare($query, array $options = array()){
		global $config;
		$instance = self::getInstance();
		
		try{
			$sth = call_user_func_array(array($instance, 'prepare'), array(str_replace('::', self::$prefix, $query), $options));
		}catch(PDOException $e){
			if(self::$debug){
				throw new PDOException($e);
			}
			die('An SQL-error occurred.');
		}
		return $sth;
	}
	
	/**
		* @param string $query SQL query.
	**/
	public static function query($query){
		global $config;
		$instance = self::getInstance();

		try{
			$sth = call_user_func_array(array($instance, 'query'), array(str_replace('::', self::$prefix, $query))); 
		}catch(PDOException $e){
			if(self::$debug){
				throw new PDOException($e);
			}
			die('An SQL-error occurred.');
		}
		return $sth;
	}
	
	/**
		* @param string $method Method to call.
		* @param array $arguments Arguments to use.
	**/
	final public static function __callStatic($method, array $arguments) { 
		$instance = self::getInstance(); 
		
		return call_user_func_array(array($instance, $method), $arguments); 
	}
}
class SQLQuery{
	protected $table;
	protected $type = 'SELECT ';
	protected $_result;
	
	public $fields = '*';
	public $from = '';
	public $where = '';
	public $orderBy = '';
	public $limit = '';
	
	public $error;
	
	/**
		* @param array $table Table to SELECT from.
	**/
	public function __construct($table = ''){
		$this->table = $table;
	}

	public function run(){
		$query = $this->type;
		if(is_array($this->fields)){
			$query .= implode(',', $this->fields);
		}else{
			$query .= !empty($this->fields) ? $this->fields : '*';
		}
		
		$query .= ' FROM ' . $this->table;
		
		$where = $this->where;
		if(is_array($where)){
			$query .= ' WHERE ';
			foreach($this->where as $key => $value){
				$query .= $key . ' = :' . $key;
			}
		}
		
		$orderBy = $this->orderBy;
		if(!empty($orderBy)){	
			$query .= ' ORDER by ' . $orderBy;
		}
		
		$limit = $this->limit;
		if(!empty($limit)){	
			$query .= ' LIMIT ' . $this->limit;
		}
		
		$stmt = DB::prepare($query);
		
		if(is_array($where)){
			foreach($this->where as $key => $value){
				$stmt->bindParam($key, $value, (gettype($value) == 'integer') ? \PDO::PARAM_INT : \PDO::PARAM_STR);
			}
		}
		
		try{
			$stmt->execute();
			$this->_result = $stmt;
			return $this;
		}catch(PDOException $e){
			$this->error = $e->getMessage();
			return false;
		}
	}
	
	public function fetchAll(){
		if($this->_result !== null){
			if($row = $this->_result->fetchAll(\PDO::FETCH_ASSOC)){
				return $row;
			}
		}
		return false;
	}
	
	public function fetch(){
		if($this->_result !== null){
			if($row = $this->_result->fetch(\PDO::FETCH_ASSOC)){
				return $row;
			}
		}
		return false;
	}
	
	/**
		* @param string $limit Maximum amount of items to return.
	**/
	public function limit($limit = null){
		if(!empty($limit)){
			$this->limit = $limit;
		}
		
		return $this;
	}
	
	/**
		* @param string $orderBy Items to order by.
	**/
	public function orderBy($orderBy = ''){
		if(!empty($orderBy)){
			$this->orderBy = $orderBy;
		}
		
		return $this;
	}
	
	/**
		* @param string $fields Fields to select.
	**/
	public function select($fields = '*'){
		$this->fields = $fields;
		
		return $this;
	}
	
	/**
		* @param array $where Where.
	**/
	public function where(array $where){
		$this->where = $where;
		
		return $this;
	}
	
	/**
		* @param string $fields Fields to select.
		* @param array $where Where.
		* @param string $limit Maximum amount of items to return.
		* @param string $orderBy Items to order by.
	**/
	public function find($fields = '*', array $where, $limit = null, $orderBy = null){
		$this->select($fields)->where($where)->orderBy($orderBy)->limit($limit);
		
		return $this->run()->fetchAll();
	}
	
	/**
		* @param string $fields Fields to select.
		* @param array $where Where.
		* @param string $limit Maximum amount of items to return.
		* @param string $orderBy Items to order by.
	**/
	public function findOne($fields = '*', array $where, $limit = null, $orderBy = null){
		$this->select($fields)->where($where)->orderBy($orderBy)->limit($limit);
		
		return $this->run()->fetch();
	}
	
	/**
		* @param integer $id ID to find.
		* @param array $fields Fields to select.
	**/
	public function findById($id, array $fields = array('*')){
		$this->select($fields)->where(array('id' => $id));
		
		return $this->run()->fetch();
	}
}