<?php

namespace app\widgets;

use app\helpers\App;
use app\models\Theme;
use app\widgets\AnchorForm;
use app\widgets\DateRange;
use app\widgets\Pagination;
use app\widgets\RecordStatusFilter;
use app\widgets\RecordStatusInput;
use app\widgets\Search;
use app\widgets\SearchButton;

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

	public function search($model, $options = [])
	{
		$options['model'] = $model;

		return Search::widget($options);
	}

	public function searchButton()
	{
		return SearchButton::widget();
	}

	public function pagination($model)
	{
		return Pagination::widget([
	        'form' => $this,
	        'model' => $model,
	    ]);
	}

	public function recordStatusFilter($model)
	{
		return RecordStatusFilter::widget([
	        'form' => $this,
	        'model' => $model,
	    ]);
	}

	public function dateRange($model)
	{
		return DateRange::widget(['model' => $model]);
	}

	public function buttons()
	{
		return AnchorForm::widget();
	}

	public function recordStatus($model)
	{
		return RecordStatusInput::widget([
			'form' => $this,
			'model' => $model
		]);
	}
}