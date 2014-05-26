<?php

class TbDateTimePicker extends CInputWidget
{

	/**
	 * @var string locale to use.
	 */
	public $locale;

	/**
	 * @var array options that are passed to the plugin.
	 */
	public $pluginOptions = array();

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
		list($name, $id) = $this->resolveNameID();
		$id = $this->resolveId($id);

		if ($this->hasModel()) {
			echo TbHtml::activeTextField($this->model, $this->attribute, $this->htmlOptions);
		} else {
			echo TbHtml::textField($name, $this->value, $this->htmlOptions);
		}

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

		$options = !empty($this->pluginOptions) ? CJavaScript::encode($this->pluginOptions) : '';
		$this->getClientScript()->registerScript(
			__CLASS__ . '#' . $id,
			"jQuery('#{$id}').datetimepicker({$options});"
		);
	}

}
