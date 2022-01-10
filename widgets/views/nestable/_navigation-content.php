<?php

use app\helpers\Html;
?>
<li class="dd-item dd3-item" data-id="<?= end($data_id) ?>-exist">
    <div class="dd-handle dd3-handle"> 
    	<i class="flaticon-squares"></i>
    </div>
    <div class="dd3-content">
        <div class="row">
            <div class="col-md-3">
                <input data-id="label" 
                    required
                    value="<?= $nav['label'] ?? '' ?>" 
                	type="text" 
                	class="form-control"  
                	placeholder="Label">
            </div>
            <div class="col-md-3">
                <input data-id="link"
                    required
                        list="link-list-<?= $id ?>" 
                    value="<?= $nav['link'] ?? '' ?>" 
                    placeholder="Link"
                    class="form-control">
            </div>
            <div class="col-md-3">
                <textarea data-id="icon"  
                    required
                    type="text" 
                    class="form-control"
                    rows="1" 
                    placeholder="Icon"><?= ($nav['icon'])? $nav['icon']: '' ?> </textarea>
            </div>
            <div class="col-md-2">
                <div class="checkbox-list">
                   <label class="checkbox">
                        <input data-id="new_tab"
                            class="checkbox"
                            type="checkbox" 
                            value="1" 
                            <?= (!empty($nav['new_tab'])) ? 'checked': '' ?>
                            > 
                            <span></span>
                            New Tab
                    </label>
                    <label class="checkbox">
                        <input data-id="group_menu"
                            class="checkbox"
                            type="checkbox" 
                            value="1" 
                            <?= (!empty($nav['group_menu'])) ? 'checked': '' ?>
                            > 
                            <span></span>
                            Group Menu
                    </label>
                </div>
            </div>
            <span  style="position: absolute; right: 5px;">
                <a href="#!" class="btn btn-danger btn-sm btn-icon mr-2 btn-remove-menu">
                    <i class="fa fa-trash"></i>
                </a>
            </span>
        </div>
    </div>
    <?= Html::if(isset($nav['sub']), function() use($data_id, $nav, $id) {
        return Html::tag('ol', 
            $this->render('_navigation', [
                'data_id' => $data_id,
                'navigations' => $nav['sub'] ?? [],
                'id' => $id,
            ]),
            ['class' => 'dd-list']
        );
    }) ?>
</li>