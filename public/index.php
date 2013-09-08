<?php
/**
 * PinIB
 *
 * @copyright Copyright (c) 2013, Thomas lekanger
 * @version 1.0
 */

if(!defined('PINIB_PATH')){
	define('PINIB_PATH', dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR);
}
define('ENV', 'development');

require PINIB_PATH . '/app/index.php';
