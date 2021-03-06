<?php
namespace PinIB;

require PINIB_PATH . '/app/vendor/Twig/lib/Twig/Autoloader.php';
require PINIB_PATH . '/app/vendor/Markdown/Michelf/Markdown.php';
\Twig_Autoloader::register();

class Twig_PinIB_Environment extends \Twig_Environment{

	/**
		* @param string $template
		* @param array $vars Variables to use in template.
	**/
	public function render($template, array $vars = array()){
		try{
			echo parent::render($template, $vars);
		}catch(Twig_Error_Loader $e) {
			echo '<h2>'.$e->getRawMessage().'</h2>';
		}
	}
}
function loadTwig(){
	global $config;
	if(isset($config['theme'])){
		$theme = $config['theme'];
	}else{
		$theme = 'default';
	}
	$loader = new \Twig_Loader_Filesystem(array(
		PINIB_PATH . '/app/views'
	));
	$twig = new Twig_PinIB_Environment($loader, array(
		'cache' => $config['cache'] ? PINIB_PATH . 'cache' : false
	));
	$twig->addFilter(new \Twig_SimpleFilter('markdown', '\\Michelf\\_MarkdownExtra_TmpImpl::defaultTransform'));
	return $twig;
}
