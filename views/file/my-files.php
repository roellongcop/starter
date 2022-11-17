<?php

use app\helpers\Html;
use app\helpers\Url;
use app\models\search\FileSearch;
use app\widgets\ActiveForm;
use app\widgets\Autocomplete;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\File */

$this->title = 'My Files';
$this->params['breadcrumbs'][] = 'Files';
$this->params['searchModel'] = new FileSearch([
    'searchAction' => ['my-files'],
]);
$this->params['showCreateButton'] = true; 
$this->params['activeMenuLink'] = '/my-files';

$this->addCssFile('css/my-files');
$this->addJsFile('js/my-files');

$myFilesUrl = Url::toRoute(['file/my-files']);
$deleteFileUrl = Url::toRoute(['file/delete']);

$this->registerJs(<<< JS
    myFiles({
        myFilesUrl: '{$myFilesUrl}',
        deleteFileUrl: '{$deleteFileUrl}',
    });
JS);
?>
<div class="row my-files-page" id="my-files">
    <div class="col-md-7">
        <?= Autocomplete::widget([
            'input' => Html::input('search', 'name', '', [
                'id' => 'search-file-input',
                'class' => 'form-control search-photo',
                'placeholder' => 'Search File',
            ]),
            'url' => Url::toRoute(['file/find-by-keywords'])
        ]) ?>
        <?php Pjax::begin([
            'options' => ['class' => 'my-photos'],
            'timeout' => false,
        ]); ?>
            <?= $this->render('my-files-ajax', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
            ]) ?>
        <?php Pjax::end(); ?>
    </div>
    <div class="col-md-5">
        <p class="lead text-warning">Image Properties</p>
        <table class="table table-bordered font-size-sm">
            <tbody>
                <tr>
                    <th>Name</th>
                    <td id="td-name"> None </td>
                </tr>
                <tr>
                    <th>Extension</th>
                    <td id="td-extension"> None </td>
                </tr>
                <tr>
                    <th>Size</th>
                    <td id="td-size"> None </td>
                </tr>
                <tr>
                    <th>Width</th>
                    <td id="td-width"> None </td>
                </tr>
                <tr>
                    <th>Height</th>
                    <td id="td-height"> None </td>
                </tr>
                <tr>
                    <th>Location</th>
                    <td id="td-location"> None </td>
                </tr>
                <tr>
                    <th>Token</th>
                    <td id="td-token"> None </td>
                </tr>
                <tr>
                    <th width="30%">Created At</th>
                    <td id="td-created_at"> None </td>
                </tr>
                <tr>
                    <th> Action </th>
                    <td id="td-action-btn"> None</td>
                </tr>
            </tbody>
        </table>

        
    </div>
</div>
 
<!-- Modal-->
<div class="modal fade" id="modal-rename-file" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Rename File</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <?php $form = ActiveForm::begin([
                    'id' => 'file-rename-form',
                    'enableAjaxValidation' => true,
                    'action' => ['file/rename'],
                    'validationUrl' => ['file/rename', 'ajaxValidate' => true]
                ]); ?>
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'token')->hiddenInput()->label(false) ?>
                    <div class="form-group">
                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                    </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
 
