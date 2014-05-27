<?php

class TbDateTimePickerAssets extends CInputWidget
{

	/**
	 * @var string locale to use.
	 */
	public $locale;

	/**
	 * @var string path to widget assets.
	 */
	public $assetPath;

	public function init()
	{
		parent::init();
		Yii::import('bootstrap.behaviors.TbWidget');
		$this->attachBehavior('tbWidget', new TbWidget);
		if (!isset($this->assetPath)) {
			$this->assetPath = realpath(dirname(__FILE__) . '/../assets');
		}
	}

	public function run()
	{
		if ($this->assetPath !== false) {
			$this->publishAssets($this->assetPath);
			$this->registerCssFile('/css/bootstrap-datetimepicker' . (YII_DEBUG ? '' : '.min') . '.css');

			$this->registerScriptFile(
				'/js/' . $this->resolveScriptVersion('bootstrap-datetimepicker.js', !YII_DEBUG),
				CClientScript::POS_END
			);

			if (isset($this->locale)) {
				$this->locale = str_replace('_', '-', $this->locale);
				$this->registerScriptFile(
					"/js/locales/bootstrap-datetimepicker.{$this->locale}.js",
					CClientScript::POS_END
				);
			}
		}
	}

}
