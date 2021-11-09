<?php

namespace app\widgets;

use app\helpers\App;
use app\models\Theme;

class ActiveForm extends \yii\widgets\ActiveForm
{
	public function init()
	{
		parent::init();

		$currentTheme = App::identity('currentTheme');

		if ($currentTheme) {
			if (in_array($currentTheme->slug, Theme::KEEN)) {
				$this->errorCssClass = 'is-invalid';
				$this->successCssClass = 'is-valid';
				$this->validationStateOn = 'input';

				$this->options['class'] = 'form';
				$this->options['novalidate'] = 'novalidate';
			}
		}
	}
}
