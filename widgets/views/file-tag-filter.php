<?php

use app\helpers\Html;
use app\helpers\Url;

$this->registerWidgetCssFile('file-tag-filter');
?>

<div class="text-right mt-2">
    <div class="btn-group ">
        <button type="button" class="btn btn-primary btn-sm"><?= $activeTag ?></button>
        <button type="button" class="btn btn-primary  btn-sm dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-reference="parent">
            <span class="sr-only">Toggle Dropdown</span>
        </button>
        <div class="dropdown-menu">
            <?= Html::a('- ALL -', Url::to([$action, 'tag' => '']), [
                'class' => 'dropdown-item ' . (($activeTag == '')? 'dropdown-item-hover': '')
            ]); ?>
            <?=	Html::foreach ($tags, function($tag) use($activeTag, $action) {
				return Html::a($tag, Url::to([$action, 'tag' => $tag]), [
				    'class' => 'dropdown-item ' . (($activeTag == $tag)? 'dropdown-item-hover': '')
				]);
			}); ?>
        </div>
    </div>
</div>
