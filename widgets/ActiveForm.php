<?php

namespace app\widgets;

use Yii;
use app\helpers\App;

class ActiveForm extends \yii\widgets\ActiveForm
{
	public function init()
	{
		parent::init();

		$currentTheme = App::identity('currentTheme');
		$keenThemes = App::params('keen_themes');

		if ($currentTheme) {
			if (in_array($currentTheme->slug, $keenThemes)) {
				$this->errorCssClass = 'is-invalid';
				$this->successCssClass = 'is-valid';
				$this->validationStateOn = 'input';

				$this->options['class'] = 'form';
				$this->options['novalidate'] = 'novalidate';
			}
		}
	}
}
