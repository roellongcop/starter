<?php

use app\helpers\App;
use app\helpers\Html;
use app\helpers\Url;
use app\widgets\Autocomplete;
use app\widgets\Webcam;
use yii\widgets\Pjax;

$this->registerWidgetJsFile('autocomplete');
$this->registerWidgetCssFile('image-gallery');
$this->registerWidgetJsFile('image-gallery');

$this->registerJs(<<< JS
    new imageGalleryWidget({
        widgetId: '{$widgetId}',
        uploadFileName: '{$uploadFileName}',
        finalCropWidth: {$finalCropWidth},
        finalCropHeight: {$finalCropHeight},
        cropperOptions: {$cropperOptions},
        myImageFilesUrl: '{$myImageFilesUrl}',
        ajaxSuccess: function(s) {
            {$ajaxSuccess}
        },
        defaultPhoto: '{$defaultPhoto}',
        parameters: {$parameters},
        uploadUrl: '{$uploadUrl}',
        findByKeywordsImageUrl: '{$findByKeywordsImageUrl}',
        tag: '{$tag}',
    }).init();
JS);
?>
<div id="image-gallery-container-<?= $widgetId ?>" class="image-gallery-container">

    <!-- type, model, model attribute name, options -->
    <?= Html::activeInput('hidden', $model, $attribute, ['class' => 'file-id-input']) ?>

    <div class="button-container">
        <?= Html::button($buttonTitle, $buttonOptions) ?>
    </div>

    <div class="modal fade image-gallery-modal" 
        tabindex="-1" 
        role="dialog" 
        aria-labelledby="staticBackdrop" 
        aria-hidden="true" 
        data-backdrop="static">

        <div class="modal-dialog  modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <?= $modalTitle ?>
                    </h5>
                    <button type="button" class="close btn-close-modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div >
                        <ul class="nav nav-tabs nav-bold nav-tabs-line">
                            <li class="nav-item">
                                <a class="nav-link active my-photos-tab-link" data-toggle="tab" href="#my-photos-tab-<?= $widgetId ?>">
                                    <span class="nav-icon">
                                        <i class="flaticon2-files-and-folders"></i>
                                    </span>
                                    <span class="nav-text">My Photos</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link cropper-tab-link" data-toggle="tab" href="#cropper-tab-<?= $widgetId ?>">
                                    <span class="nav-icon">
                                        <i class="flaticon-upload"></i>
                                    </span>
                                    <span class="nav-text">Upload</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link webcam-tab-link" data-toggle="tab" href="#webcam-tab-<?= $widgetId ?>">
                                    <span class="nav-icon">
                                        <i class="fas fa-camera"></i>
                                    </span>
                                    <span class="nav-text">Webcam</span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content pt-10">
                            <div class="tab-pane fade show active my-photos-tab-container" 
                                id="my-photos-tab-<?= $widgetId ?>" 
                                role="tabpanel">
                                <div class="row">
                                    <div class="col-md-7 col-sm-6 br-dashed">
                                        <!-- type, input name, input value, options -->
                                        <?= Autocomplete::widget([
                                            'input' => Html::input('search', 'search', '', [
                                                'class' => 'form-control search-input',
                                                'placeholder' => 'Search Photo',
                                            ]),
                                            'url' => Url::toRoute(['file/find-by-keywords-image', 'tag' => $tag]),
                                            'submitOnclick' => false
                                        ]) ?>
                                        <?php Pjax::begin([
                                            'options' => ['class' => 'my-photos-container'],
                                            'enablePushState' => false,
                                            'timeout' => false
                                        ]); ?>
                                        <?php Pjax::end(); ?>
                                    </div>
                                    <div class="col-md-5 col-sm-6 image-properties-panel">
                                        <p class="lead text-warning">Image Properties</p>
                                        <table class="table-bordered font-size-sm">
                                            <tbody>
                                                <tr>
                                                    <th>Name</th>
                                                    <td class="td-name"> None </td>
                                                </tr>
                                                <tr>
                                                    <th>Extension</th>
                                                    <td class="td-extension"> None </td>
                                                </tr>
                                                <tr>
                                                    <th>Size</th>
                                                    <td class="td-size"> None </td>
                                                </tr>
                                                <tr>
                                                    <th>Width</th>
                                                    <td class="td-width"> None </td>
                                                </tr>
                                                <tr>
                                                    <th>Height</th>
                                                    <td class="td-height"> None </td>
                                                </tr>
                                                <tr>
                                                    <th>Location</th>
                                                    <td class="td-location"> None </td>
                                                </tr>
                                                <tr>
                                                    <th>Token</th>
                                                    <td class="td-token"> None </td>
                                                </tr>
                                                <tr>
                                                    <th width="30%">Created At</th>
                                                    <td class="td-created_at"> None </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="tab-pane fade cropper-tab-container" id="cropper-tab-<?= $widgetId ?>" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-7 col-sm-6 br-dashed">
                                        <?= Html::img($defaultPhoto, [
                                            'id' => 'cropper-image-' . $widgetId
                                        ]) ?>
                                        <div class="input-group mt-2">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Filename</span>
                                            </div>
                                            <input type="text" class="image-name form-control" placeholder="File Name">
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-sm-6 image-properties-panel-crop pl-8">
                                        <p class="lead text-warning">Image Properties</p>
                                        <table class="table-bordered font-size-sm">
                                            <tbody>
                                                <tr>
                                                    <th>Name</th>
                                                    <td class="crop-td-name"> None </td>
                                                </tr>
                                                <tr>
                                                    <th>Extension</th>
                                                    <td class="crop-td-extension"> None </td>
                                                </tr>
                                                <tr>
                                                    <th>Size</th>
                                                    <td class="crop-td-size"> None </td>
                                                </tr>
                                                <tr>
                                                    <th>Width</th>
                                                    <td class="crop-td-width"> None </td>
                                                </tr>
                                                <tr>
                                                    <th>Height</th>
                                                    <td class="crop-td-height"> None </td>
                                                </tr>
                                                <tr>
                                                    <th>Location</th>
                                                    <td class="crop-td-location"> None </td>
                                                </tr>
                                                <tr>
                                                    <th>Token</th>
                                                    <td class="crop-td-token"> None </td>
                                                </tr>
                                                <tr>
                                                    <th width="30%">Created At</th>
                                                    <td class="crop-td-created_at"> None </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                </div>
                            </div>

                            <div class="tab-pane fade webcam-tab-container" id="webcam-tab-<?= $widgetId ?>" role="tabpanel">
                                <?= Webcam::widget([
                                    'tag' => $tag,
                                    'withNameInput' => false,
                                    'withInput' => false,
                                    'model' => $model,
                                    'videoOptions' => [
                                        'width' => $finalCropWidth,
                                        'height' => $finalCropHeight,
                                        'autoplay' => true,
                                        'style' => 'margin: 0 auto;width: 100%; height: auto;max-width: 400px;'
                                    ],
                                    'buttonOptions' => [
                                        'class' => 'btn btn-primary btn-sm mt-3',
                                        'value' => 'Capture',
                                        'style' => 'max-width: 200px;margin: 0 auto;',
                                    ],
                                    'ajaxSuccess' => $ajaxSuccess . <<< JS
                                        let container = '#image-gallery-container-{$widgetId}',
                                        fileIdInput = [container, '.file-id-input'].join(' '),
                                        imageGalleryModal = [container, '.image-gallery-modal'].join(' ');

                                        $(fileIdInput).val(s.file.token);
                                        $(imageGalleryModal).modal('hide');
                                    JS
                                ]) ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold btn-close-modal">Close</button>

                    <div class="btn-group btn-options">
                        <button type="button" class="btn btn-light-info rotate-left-btn" title="Rotate Left">
                            <span data-toggle="tooltip" title="" data-original-title="Rotate Left">
                                <span class="fa fa-undo-alt"></span>
                                Rotate Left
                            </span>
                        </button>
                        <button type="button" class="btn btn-light-info rotate-right-btn" title="Rotate Right">
                            <span data-toggle="tooltip" title="" data-original-title="Rotate Right">
                                <span class="fa fa-redo-alt"></span>
                                Rotate Right
                            </span>
                        </button>
                    </div>

                    <div class="btn-group  btn-options">
                        <button type="button" class="btn btn-light-info reset-cropper-btn" title="Reset">
                            <span data-toggle="tooltip" title="" data-original-title="Reset">
                                <span class="fa fa-sync-alt"></span>
                                Reset
                            </span>
                        </button>
                        <input type="file" class="sr-only select-image-input" name="file" accept="image/*">
                        <button type="button" class="btn btn-light-info btn-upload select-image-btn" title="Upload image file">
                            <span class="kt-tooltip" data-toggle="tooltip" title="" data-original-title="Import image">
                                <span class="fa fa-upload"></span>
                                Import
                            </span>
                        </button>
                    </div> 

                    <div class="btn-group btn-options">
                        <button type="button" class="save-image-btn btn btn-success btn-upload" title="Save Photo">
                            <span class="kt-tooltip" data-toggle="tooltip" title="" data-original-title="Save Photo">
                                <span class="fa fa-save"></span> Save
                            </span>
                        </button>
                    </div> 

                    <?= Html::button('Crop', [
                        'class' => 'btn btn-primary font-weight-bold edit-btn'
                    ]) ?>

                    <?= Html::button('Confirm', [
                        'class' => 'btn btn-success font-weight-bold confirm-btn',
                        // 'data-dismiss' => 'modal'
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>