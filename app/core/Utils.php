<?php
function redirect($location = '/', $statusCode = 302){
	header('Location: ' . $location, true, $statusCode);
}
function isExternal($url){
	$urlHost = parse_url($url, PHP_URL_HOST);
	$baseUrlHost = parse_url($_SERVER['SERVER_NAME'], PHP_URL_HOST);
	return $urlHost !== $baseUrlHost || !empty($urlHost);
}
function slug($str, $separator = '-') {
	$str = iconv('utf-8', 'us-ascii//TRANSLIT', $str);
	// replace non letter or digits by separator
	$str = preg_replace('#[^\\pL\d]+#u', $separator, $str);

	return trim(strtolower($str), $separator);
}
/* https://github.com/idiot/feather/blob/master/feather/classes/url.php */

