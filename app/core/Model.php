<?php
namespace PinIB;
class Model{
	protected $table = '';
	
	/**
		* @param App $app
	**/
	public function __construct(App $app){
		$this->app = $app;
		$this->redis = new \Predis\Client(false, array('prefix' => $this->table . ':'));
	}
}
