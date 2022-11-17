<?php

use app\helpers\Url;
use app\models\search\FileSearch;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\File */

$this->title = 'My Files';
$this->params['breadcrumbs'][] = 'Files';
$this->params['searchModel'] = new FileSearch();
$this->params['showCreateButton'] = true; 

$myImageFilesUrl = Url::toRoute(['file/my-image-files']);
$deleteFileUrl = Url::toRoute(['file/delete']);
$myFilesUrl =  $myFilesUrl ?? Url::toRoute(['file/my-files']);


$this->addCssFile('css/my-image-files');
$this->addJsFile('css/my-image-files');

$this->registerJs(<<< JS
    myImageFiles({
        myImageFilesUrl: '{$myImageFilesUrl}',
        deleteFileUrl: '{$deleteFileUrl}',
        myFilesUrl: '{$myFilesUrl}',
    });
JS);
$this->registerCss(<<< CSS
    
CSS);
?>
<div class="row my-image-files-page" id="my-image-files">
    <div class="col-md-7">
        <input type="search" class="form-control search-photo" placeholder="Search Photo">
        <?php Pjax::begin([
            'options' => ['class' => 'my-photos'],
            'timeout' => false
        ]); ?>
            <?= $this->render('my-image-files-ajax', [
                'dataProvider' => $dataProvider,
            ]) ?>
        <?php Pjax::end(); ?>
    </div>
    <div class="col-md-5">
        <p class="lead text-warning">Image Properties
            <span class="float-right">
                <button 
                    disabled="disabled"
                    type="button" 
                    class="btn btn-danger btn-sm font-weight-bold"
                    id="remove-file-btn">
                        Remove File
                </button>
            </span>
        </p>
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