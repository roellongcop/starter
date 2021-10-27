<?php

use app\helpers\Html;
use app\widgets\Checkbox;
?>
<div class="row">
    <div class="col-md-8">
        <?= Checkbox::widget([
            'data' => ['page' => 'Check All Access'],
            'inputClass' => 'checkbox',
            'options' => [
                'id' => 'check_all',
                'onclick' => 'checkAllModule(this)'
            ],
        ]) ?>
        <br>
        <div class="accordion accordion-toggle-arrow" id="module-access-accordion">
            <?= Html::foreach($controller_actions, function($controller, $actions) {
                return $this->render('_form_actions-content', [
                    'controller' => $controller,
                    'actions' => $actions,
                ]);
            }) ?>
        </div>
    </div>
</div>