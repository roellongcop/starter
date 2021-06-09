<?php
use app\helpers\App;
use yii\helpers\ArrayHelper;
use app\helpers\Html;

$registerJs = <<<SCRIPT
    $('a.bulk-action').on('click', function() {
        var data_process = $(this).data('process');
        $('input[name="process-selected"]').val(data_process);
        $(this).closest('form').submit();
    })
SCRIPT;
$this->registerJs($registerJs, \yii\web\View::POS_END);
?>
<?php if(App::component('access')->userCan('process-checkbox')): ?>
    <?php if (isset($searchModel->bulkActions)): ?>
        <input type="hidden" name="process-selected">
        <div class="dropdown">
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
                    <?php if (($bulkActions = $searchModel->bulkActions) != null): ?>
                        <?php foreach ($bulkActions as $bulkAction): ?>
                            <li class="navi-item">
                                <a href="#" class="navi-link bulk-action" data-process="<?= $bulkAction['process'] ?>">
                                    <?php if (Html::isHtml($bulkAction['icon'])): ?>
                                        <?= $bulkAction['icon'] ?>
                                    <?php else: ?>
                                        <?= $this->render('icon/'. $bulkAction['icon']) ?>
                                    <?php endif ?>
                                    &nbsp;
                                    <span class="navi-text">
                                        <?= $bulkAction['label'] ?>
                                    </span>
                                </a>
                            </li> 
                        <?php endforeach ?>
                    <?php endif ?>
                </ul>
            </div>
        </div> 
    <?php endif ?>
<?php endif ?>