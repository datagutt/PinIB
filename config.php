<?php
$config = array();
$config['db'] = array();

// Database
$config['db']['type'] = 'mysql';
$config['db']['database'] = 'idioticdev';
$config['db']['host'] = 'localhost';
$config['db']['prefix'] = '';
$config['db']['username'] = 'root';
$config['db']['password'] = trim(file_get_contents('/var/nettsamfunn1.pw'));

// Memcached
$config['memcached'] = array(
	'memch1' => array('host' => 'localhost','port' => '11211')
);
/* Server configuration */
$config['cache'] = false;
$config['url_variable'] = 'REQUEST_URI';
$config['functions'] = array(
	'csrf' => 'makeCSRF'
);