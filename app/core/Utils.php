<?php
function id($a){
	return $a;
}
function redirect($location = '/', $statusCode = 302){
	header('Location: ' . $location, true, $statusCode);
}
function isExternal($url){
	$urlHost = parse_url($url, PHP_URL_HOST);
	$baseUrlHost = parse_url($_SERVER['SERVER_NAME'], PHP_URL_HOST);
	return $urlHost !== $baseUrlHost || !empty($urlHost);
}
/* https://github.com/idiot/feather/blob/master/feather/classes/url.php */
function slug($str, $separator = '-') {
	$str = iconv('utf-8', 'us-ascii//TRANSLIT', $str);
	// replace non letter or digits by separator
	$str = preg_replace('#[^\\pL\d]+#u', $separator, $str);

	return trim(strtolower($str), $separator);
}
function ago($date){
	if(empty($date)) {
		return 'No date provided';
	}
	
	$periods = array('s', 'm', 'h', 'd', 'w', 'mo', 'y', 'decade');
	$lengths = array('60','60','24','7','4.35','12','10');
	
	$now = time();
	$unix_date = strtotime($date);
	
	// check validity of date
	if(empty($unix_date)) {	   
		return 'Bad date';
	}
	
	// is it future date or past date
	if($now > $unix_date) {	   
		$difference	= $now - $unix_date;
		$tense = 'ago';
	
	}else{
		$difference	= $unix_date - $now;
		$tense = 'from now';
	}
	
	for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++){
		$difference /= $lengths[$j];
	}
	
	$difference = round($difference);
	
	if($difference == 0) {
		return 'just now';
	}
	
	return "$difference$periods[$j] {$tense}";
}