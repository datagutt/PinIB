<?php
$routes = array(
	'/' => array('controller' => 'Index'),
	'/thread/:alpha' => array('controller' => 'Thread'),
	'/tag/:string' => array('controller' => 'Thread', 'method' => 'tag'),
	'/auth' => array('controller' => 'Auth'),
	'/auth/login' => array('controller' => 'Auth', 'method' => 'login')
	'/auth/logout' => array('controller' => 'Auth', 'method' => 'logout')
);
