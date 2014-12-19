<?php
/**
 * EFancyboxWidget class file.
 *
 * @author Veaceslav Medvedev <slavcopost@gmail.com>
 * @link http://code.google.com/p/yiiext/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */
/**
 * EFancyboxWidget {@link http://fancybox.net/ fancybox jQuery plugin} widget.
 *
 * @author Veaceslav Medvedev <slavcopost@gmail.com>
 * @version 0.2
 * @package yiiext.widgets.fancybox
 * @link http://fancybox.net/
 */
class EFancyboxWidget extends CWidget
{
	/**
	 * @var string URL where to look assets.
	 */
	public $assetsUrl;
	/**
	 * @var string script name.
	 */
	public $scriptFile;
	/**
	 * @var string stylesheet.
	 */
	public $cssFile;
	/**
	 * @var string selector for generate fancybox.
	 * Defaults to '[href$=\'.jpg\'],a[href$=\'.png\'],a[href$=\'.gif\']'.
	 */
	public $selector='a[href$=\'.jpg\'],a[href$=\'.png\'],a[href$=\'.gif\']'; //a:has(img)
	/**
	 * @var boolean enable "mouse-wheel" to navigate throught gallery items.
	 * Defaults to false.
	 */
	public $enableMouseWheel=false;
	/**
	 * @var array extension options. For more info read {@link http://fancybox.net/api/ documentation}
	 */
	public $options=array();

	/**
	 * Init widget.
	 */
	function init()
	{
		if($this->assetsUrl===null)
			$this->assetsUrl=Yii::app()->getAssetManager()->publish(dirname(__FILE__).'/assets',false,-1,YII_DEBUG);

		if($this->scriptFile===null)
			$this->scriptFile=YII_DEBUG ? 'jquery.fancybox-2.1.5.js' : 'jquery.fancybox-2.1.5.pack.js';

		if($this->cssFile===null)
			$this->cssFile='jquery.fancybox-2.1.5.css';

		$this->registerClientScript();
	}
	/**
	 * Run widget.
	 */
	public function run()
	{
	}
	/**
	 * Register CSS and Script.
	 * @return void
	 */
	protected function registerClientScript()
	{
		$cs=Yii::app()->getClientScript();
		if($this->cssFile!==false)
			$cs->registerCssFile($this->assetsUrl.'/'.$this->cssFile);
		$cs->registerCoreScript('jquery');
		$cs->registerScriptFile($this->assetsUrl.'/'.$this->scriptFile);

        // Registry mouse-wheel script if mouse-wheel enabled.
		if($this->enableMouseWheel)
            $cs->registerScriptFile($this->assetsUrl.'/jquery.mousewheel-3.1.3.pack.js');

        if(isset($this->options['helpers']['media']))
            $cs->registerScriptFile($this->assetsUrl.'/helpers/jquery.fancybox-media-1.0.6.js');

        if(isset($this->options['helpers']['thumbs'])){
		    $cs->registerCssFile($this->assetsUrl.'/helpers/jquery.fancybox-thumbs-1.0.7.css');
            $cs->registerScriptFile($this->assetsUrl.'/helpers/jquery.fancybox-thumbs-1.0.7.js');
        }

        if(isset($this->options['helpers']['buttons'])){
		    $cs->registerCssFile($this->assetsUrl.'/helpers/jquery.fancybox-buttons-1.0.5.css');
            $cs->registerScriptFile($this->assetsUrl.'/helpers/jquery.fancybox-buttons-1.0.5.js');
        }

        $cs->registerScript($this->getId(),'$("'.$this->selector.'").fancybox('.CJavaScript::encode($this->options).');',CClientScript::POS_READY);
	}
}
