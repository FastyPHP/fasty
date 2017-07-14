<?php

namespace Core\Classes;

class Template extends \Smarty
{
	public	$templatePath,
			$languagePath,
			$language,
			$compilePath,
			$cachePath;

	/**
	 * Initiates
	*/

	public function __construct(){

		parent::__construct();

		$this->templatePath		=		Config::Get('tempPath');
		$this->languagePath		=		Config::Get('langPath');
		$this->compilePath		=		Config::Get('tempComp');
		$this->cachePath		=		Config::Get('tempCach');
		$this->language			=		Config::Get('language');

		if(Config::Get('tempCachTime')){
			$this->caching			= 	1;
			$this->cache_lifetime	= 	Config::Get('tempCachTime');
		}

		$this->	setCompileDir($this->compilePath)->
				setCacheDir($this->cachePath)->
				setTemplateDir($this->templatePath);
	}

	public function language(string $file) : array {

		if(Config::Get('underdev'))
			Debug::addLanguage(str_replace('../', '~/', $this->languagePath) .'/'. $this->language .'/'. $file .'.language.php');

		return require ($this->languagePath .'/'. $this->language .'/'. $file .'.language.php');
	}

	public function view(string $file, array $vars = [], int $cache = 0) : void {

		$this->assign('config', Config::Get());

		if(is_array($vars)){
			foreach($vars as $key => $val){
				$this->assign($key, $val);
			}
		}

		if($cache != 0){
			$this->caching = 2;
			$this->cache_lifetime = $cache;
		}

		$this->display(str_replace('.', '/', $file) . '.tpl');

		if(Config::Get('underdev'))
			Debug::addTemplate($this->templatePath .'/'. str_replace('.', '/', $file) . '.tpl', $vars);
	}
}
?>
