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
use app\widgets\Checkbox;
use app\widgets\Filter;
use app\widgets\BootstrapSelect;
use app\widgets\ImageGallery;
use app\widgets\JsonEditor;
use app\widgets\Dropzone;

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

	public function dropzone($model, $attribute = '', $tag = '', $options = [])
	{
		$options['model'] = $model;
		$options['attribute'] = $attribute;
		$options['tag'] = $tag;

		return Dropzone::widget($options);
	}

	public function bootstrapSelect($model, $attribute = '', $data = [], $options = [])
	{
		$options['form'] = $this;
		$options['model'] = $model;
		$options['attribute'] = $attribute;
		$options['data'] = $data;

		return BootstrapSelect::widget($options);
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

	public function pagination($model, $options = [])
	{
		$options['form'] = $this;
		$options['model'] = $model;

		return Pagination::widget($options);
	}

	public function recordStatusFilter($model)
	{
		return RecordStatusFilter::widget([
	        'form' => $this,
	        'model' => $model,
	    ]);
	}

	public function dateRange($model, $options = [])
	{
		$options['model'] = $model;

		return DateRange::widget($options);
	}

	public function buttons()
	{
		return AnchorForm::widget();
	}

	public function filter($model, $attribute = '', $data = [], $title = '')
	{
		return Filter::widget([
	        'form' => $this,
	        'model' => $model,
	        'attribute' => $attribute,
	        'data' => $data,
	        'title' => $title,
	    ]);
	}

	public function recordStatus($model)
	{
		return RecordStatusInput::widget([
			'form' => $this,
			'model' => $model
		]);
	}

	public function checkbox($data = [], $name = '', $checkedFunction = null)
	{
		return Checkbox::widget([
            'data' => $data,
            'name' => $name,
            'checkedFunction' => $checkedFunction
        ]);
	}

	public function imageGallery($model, $attribute = '', $tag = '', $options = [])
	{
		$options['model'] = $model;
		$options['attribute'] = $attribute;
		$options['tag'] = $tag;

		return ImageGallery::widget($options);
	}

	public function jsonEditor($data = [], $id = '', $options = [])
	{
		return JsonEditor::widget([
	        'data' => $data,
	        'id' => $id,
	        'options' => $options,
	    ]);
	}
}