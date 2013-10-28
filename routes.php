<?php
$routes = array(
	'/' => array('controller' => 'Index'),
	'/newthread' => array('controller' => 'Thread', 'method' => 'newthread'),
	'/thread/:alpha' => array('controller' => 'Thread'),
	'/thread/:alpha/reply' => array('controller' => 'Thread', 'method' => 'reply'),
	'/tag/:string' => array('controller' => 'Thread', 'method' => 'tag'),
	'/auth' => array('controller' => 'Auth'),
	'/auth/login' => array('controller' => 'Auth', 'method' => 'login'),
	'/auth/logout' => array('controller' => 'Auth', 'method' => 'logout')
);
