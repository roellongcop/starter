<?php

namespace app\widgets;

class KeenActiveForm extends \yii\widgets\ActiveForm
{
	public function init()
	{
		parent::init();
		$this->errorCssClass = 'is-invalid';
		$this->successCssClass = 'is-valid';
		$this->validationStateOn = 'input';

		$this->options['class'] = 'form';
		$this->options['novalidate'] = 'novalidate';
	}
}
