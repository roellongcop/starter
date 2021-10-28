<?php

use app\helpers\Html;
?>
<input type="hidden" name="process-selected">
<div class="dropdown mb-5" style="width: fit-content;">
    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
        <?= $title ?>
        <span class="caret"></span>
    </button>
    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right p-0 m-0">
        <ul class="navi navi-hover">
            <li class="navi-header pb-1">
                <span class="text-primary text-uppercase font-weight-bolder font-size-sm">
                    PROCESS:
                </span>
            </li>
            <?= Html::foreach($bulkActions, function($key, $bulkAction) {
                return $this->render('_list', [
                    'bulkAction' => $bulkAction
                ]);
            }) ?>
        </ul>
    </div>
</div>