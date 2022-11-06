<?php

use app\helpers\Html;

$this->registerWidgetCssFile('file-tag-filter');
?>

<div class="text-right mt-2">
    <div class="btn-group ">
        <button type="button" class="btn btn-primary btn-sm"><?= $activeTag ?></button>
        <button type="button" class="btn btn-primary  btn-sm dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-reference="parent">
            <span class="sr-only">Toggle Dropdown</span>
        </button>
        <div class="dropdown-menu">
            <?= Html::a('- ALL -', ["file/{$action}", 'tag' => '', 'keywords' => $keywords], [
                'class' => 'dropdown-item ' . (($activeTag == '')? 'dropdown-item-hover': ''),
                'data-tag' => '',
            ]); ?>
            <?=	Html::foreach ($tags, function($tag) use($activeTag, $action, $keywords) {
				return Html::a($tag, ["file/{$action}", 'tag' => $tag, 'keywords' => $keywords], [
				    'class' => 'dropdown-item ' . (($activeTag == $tag)? 'dropdown-item-hover': ''),
                    'data-tag' => $tag,
				]);
			}); ?>
        </div>
    </div>
</div>
