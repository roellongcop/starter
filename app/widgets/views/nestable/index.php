<?php

use yii\helpers\Url;
$this->registerJs(<<<SCRIPT
var zero = 0;

var addMainNavigation = function() {
    zero ++;
    var html = '';
    html += '<li class="dd-item dd3-item" data-id="'+ (zero) +'-new">';
        html += '<div class="dd-handle dd3-handle"> <i class="flaticon-squares"></i></div>';
        html += '<div class="dd3-content">';
            html += '<div class="row">';
                
                html += '<div class="col-md-3">';
                    html += '<input data-id="label" type="text" class="form-control"  placeholder="Label" required>';
                html += '</div>';
                html += '<div class="col-md-3">';
                    html += '<input list="link-list-{$widget_id}" data-id="link" type="text" class="form-control"  placeholder="Link" required>';
                html += '</div>';
                html += '<div class="col-md-3">';
                    html += '<textarea  data-id="icon" type="text" class="form-control"  placeholder="Icon" rows="1" required></textarea>';
                html += '</div>';


                html += '<div class="col-md-2">';
                   html += '<div class="checkbox-list">';
                       html += '<label class="checkbox">';
                            html += '<input class="checkbox" data-id="new_tab" type="checkbox"value="1">';
                                html += '<span></span>New Tab';
                        html += '</label>';
                    html += '</div>';
                html += '</div>';


                html += '<span  style="position: absolute; right: 5px;">';
                    html += '<a onclick="removeMainNavigation(this)" href="#!" class="btn btn-danger btn-sm btn-icon mr-2">';
                        html += '<i class="fa fa-trash"></i>';
                    html += '</a>';
                html += '</span>';
            html += '</div>';
        html += '</div>';
    html += '</li>';

    $('#ol-dd-list-{$widget_id}').prepend(html);
    $('.dd').trigger('change');
    // initNestable();
}


var removeMainNavigation = function(self) {
    var confirm_dialog = confirm('Are you sure?');

    if (confirm_dialog) {
        $(self).closest('li').remove();
    }
}


var collapseNavigation = function(self) {
    var action = $(self).data('action');

    if (action == 'collapse-all') {
        $(self).data('action', 'expand-all')
    }
    else {
        $(self).data('action', 'collapse-all')
    }
}

var initNestable = function() {
    if ($('#nestable-menu-{$widget_id}').length) {
        $('#nestable-menu-{$widget_id}').on('click', function(e) {
            var target = $(e.target),
                action = target.data('action');
            if (action === 'expand-all') {
                $('.dd').nestable('expandAll');
            }
            if (action === 'collapse-all') {
                $('.dd').nestable('collapseAll');
            }
        });

        $('.dd').nestable({maxDepth: 4, default_name: 'Role[main_navigation]'});
        $('.dd').nestable('createName')

        $('.dd').on('change', function() {
            $(this).nestable('createName')
        });
    }
}

initNestable();

SCRIPT, \yii\web\View::POS_END);

?>
<div class="row">
    <div class="col-md-12">
        <datalist id="link-list-<?= $widget_id ?>">
            <?php foreach ($controller_actions as $controller => $actions) : ?>
                <?php foreach ($actions as $action) : ?>
                    <option value="<?= Url::to(["{$controller}/{$action}"]) ?>">
                    </option>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </datalist>
        <a href="#!" onclick="addMainNavigation()" class="btn btn-secondary">
            Add Menu
        </a>
        <menu id="nestable-menu-<?= $widget_id ?>" class="btn btn-group pull-right">
          
            <button class="btn btn-secondary" 
                type="button" 
                data-action="collapse-all" onclick="collapseNavigation(this)">
                Toggle
            </button>
        </menu>
        <div class="dd">
            <ol class="dd-list" id="ol-dd-list-<?= $widget_id ?>">
                <?= $this->render('_navigation', [
                    'data_id' => [],
                    'navigations' => $role->main_navigation,
                    'widget_id' => $widget_id,
                ]) ?>
            </ol>
        </div>
    </div>
</div>