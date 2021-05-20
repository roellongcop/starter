<?php
namespace app\widgets;

use Yii;
use app\helpers\App;

class ActiveForm extends \yii\widgets\ActiveForm
{
	public $keenThemes = [
		'demo1-main',
		'demo1-main-fluid',
		'light',
		'light-fluid',
		'dark',
		'dark-fluid',
		'no-aside-light',
		'no-aside-light-fluid',
		'no-aside-dark',
		'no-aside-dark-fluid',
		'demo2-fixed',
		'demo2-fluid',
		'demo3-fixed',
		'demo3-fluid',
	];


	public function init()
	{
		parent::init();

		$currentTheme = App::identity('currentTheme');

		if (in_array($currentTheme->slug, $this->keenThemes)) {
			$this->errorCssClass = 'is-invalid';
			$this->successCssClass = 'is-valid';
			$this->validationStateOn = 'input';

			$this->options['class'] = 'form';
			$this->options['novalidate'] = 'novalidate';
		}
	}
}
