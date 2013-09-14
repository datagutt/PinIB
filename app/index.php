<?php
namespace PinIB;

// Fail out if not included from root
if(!defined('PINIB_PATH')){
	header('HTTP/1.1 403 Forbidden', true, 403);
	die();
}

// Compares PHP version against our requirement.
if(!version_compare(PHP_VERSION, '5.4.0', '>=')){
	die('PinIB needs PHP 5.4.0 or higher to run. You are currently running PHP ' . PHP_VERSION . '.');
}

if(ENV == 'development'){
	error_reporting(E_ALL | E_STRICT);
	ini_set('display_errors', true);
}else{
	ini_set('display_errors', false);
}

session_start();
ob_start();

date_default_timezone_set('Europe/Paris');

require PINIB_PATH . 'routes.php';

try{
	require PINIB_PATH . '/app/core/DB.php';
	require PINIB_PATH . '/app/core/App.php';
	require PINIB_PATH . '/app/core/Controller.php';
	require PINIB_PATH . '/app/core/Model.php';
	require PINIB_PATH . '/app/core/View.php';
	require PINIB_PATH . '/app/core/CSRF.php';
	require PINIB_PATH . '/app/core/Utils.php';
	
	require PINIB_PATH . '/app/libraries/Config.php';
	require PINIB_PATH . '/app/libraries/Auth.php';
	
	if(file_exists(PINIB_PATH . '/config.php')){
		require PINIB_PATH . '/config.php';
	}else{
		// Installer stuff
		die('');
	}
	
	Config::init();
	
	$twig = loadTwig();
	
	$app = new App($twig, $routes);
	spl_autoload_register(array($app, 'autoload'));
	$app->run();
}catch(\Exception $e){
	http_response_code(503);
	
	die('PinIB Exception: ' . $e->getMessage());
}
