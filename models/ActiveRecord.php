<?php

namespace app\models;

use Yii;
use app\helpers\App;
use app\helpers\Html;
use app\helpers\Url;
use app\models\Log;
use app\models\form\export\ExportForm;
use app\models\search\SettingSearch;
use app\widgets\Anchor;
use app\widgets\Detail;
use app\widgets\RecordHtml;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

abstract class ActiveRecord extends \yii\db\ActiveRecord
{
    public abstract function config();
    
    const RECORD_ACTIVE = 1;
    const RECORD_INACTIVE = 0;

    public $_startDate;
    public $_endDate;
    public $_createdByEmail;
    public $_updatedByEmail;

    public $_canCreate;
    public $_canView;
    public $_canUpdate;
    public $_canDelete;
    public $_canActivate;
    public $_canInactivate;

    public $errorSummary;
    public $date_range;

    public function addError($attribute, $error = '')
    {
        $error = is_array($error)? json_encode($error): $error;

        parent::addError($attribute, $error);
    }
    
    public static function mapRecords()
    {
        return App::keyMapParams('record_status');
    }

    public function getRelatedModels()
    {
        $config = $this->config();
        
        return $config['relatedModels'] ?? [];
    }

    public function getExcelIgnoreAttributes()
    {
        $config = $this->config();

        return $config['excelIgnoreAttributes'] ?? ['photo'];
    }

    public function getExportColumns()
    {
        return [];
    }

    public function exportColumns()
    {
        return [];
    }

    public function gridColumns()
    {
        return [];
    }

    public function detailColumns()
    {
        return [];
    }

    public function paramName()
    {
        $config = $this->config();
        
        return $config['paramName'] ?? 'id';
    }

    public function mainAttribute()
    {
        $config = $this->config();

        return $config['mainAttribute'] ?? 'id';
    }

    public function controllerID()
    {
        $config = $this->config();

        return $config['controllerID'] ?? App::controllerID();
    }

    public function setAttributeLabels($labels)
    {
        $labels['record_status'] = $labels['record_status'] ?? 'Record Status';
        $labels['created_by'] = $labels['created_by'] ?? 'Created By';
        $labels['updated_by'] = $labels['updated_by'] ?? 'Updated By';
        $labels['created_at'] = $labels['created_at'] ?? 'Created At';
        $labels['updated_at'] = $labels['updated_at'] ?? 'Updated At';
        $labels['recordStatusHtml'] = $labels['recordStatusHtml'] ?? 'Record Status';
        $labels['recordStatusLabel'] = $labels['recordStatusLabel'] ?? 'Record Status';

        return $labels;
    }

    public function setRules($rules)
    {
        return array_merge($rules, [
            // 'blameable' => [['created_by', 'updated_by'], 'integer'],
            // 'timestamp' => [['created_at', 'updated_at'], 'safe'],
            'integer' => [['record_status'], 'integer'],
            'default' => ['record_status', 'default', 'value' => self::RECORD_ACTIVE],
            'range' => ['record_status', 'in', 'range' => [
                self::RECORD_ACTIVE, 
                self::RECORD_INACTIVE
            ]],
            'custom' => ['record_status', 'validateRecordStatus'],
        ]);
    }

    public function validateRecordStatus($attribute, $params)
    {
        if ($this->isNewRecord) {
            if (App::isGuest() && $this->isInactive) {
                $this->addError($attribute, 'Guest Cannot create deactivated data.');
            }
            else {
                if ($this->isInactive && !App::identity()->can('in-active-data', $this->controllerID())) {
                    $this->addError($attribute, 'Dont have access to create deactivated data.');
                }
            }
        }
        else {
            if ($this->isActive && !$this->beforeCanActivate) {
                $this->addError($attribute, 'Cannot be Activated');
            }

            if ($this->isInactive && !$this->beforeCanInactivate) {
                $this->addError($attribute, 'Cannot be Inactivated');
            }
        }
    }

    public function validate($attributeNames = null, $clearErrors = true)
    {
        $validate = parent::validate($attributeNames, $clearErrors);

        if (!$validate) {
            $this->errorSummary = Html::errorSummary($this, ['class' => 'error-summary']);
        }

        return $validate;
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        $save = parent::save($runValidation, $attributeNames);

        if (!$save) {
            $this->errorSummary = Html::errorSummary($this, ['class' => 'error-summary']);
        }

        return $save;
    }

    public static function activeAll($condition = '')
    {
        $models = static::findAll($condition);
        $result = static::updateAll(['record_status' => self::RECORD_ACTIVE], $condition);

        Log::record(new static(), ArrayHelper::map($models, 'id', 'attributes'));

        return $result;
    }

    public static function inactiveAll($condition = '')
    {
        $models = static::findAll($condition);
        $result = static::updateAll(['record_status' => self::RECORD_INACTIVE], $condition);

        Log::record(new static(), ArrayHelper::map($models, 'id', 'attributes'));
        
        return $result;
    }

    public static function deleteAll($condition = null, $params = []) 
    {
        $models = static::findAll($condition);
        $result = parent::deleteAll($condition);

        Log::record(new static(), ArrayHelper::map($models, 'id', 'attributes'));

        return $result;
    }

    public static function findInactive($condition)
    {
        $condition = is_array($condition)? $condition: ['id' => $condition];
        return static::find()
            ->where($condition)
            ->inActive()
            ->one();
    } 

    public static function findActive($condition)
    {
        $condition = is_array($condition)? $condition: ['id' => $condition];
        return static::find()
            ->where($condition)
            ->active()
            ->one();
    }

    public static function findVisible($condition)
    {
        $condition = is_array($condition)? $condition: ['id' => $condition];

        return static::find()
            ->where($condition)
            ->visible()
            ->one();
    }

    public static function findOrCreate($condition)
    {
        $condition = is_array($condition)? $condition: ['id' => $condition];

        return static::findOne($condition) ?: new static($condition);
    }

    public static function updateAll($attributes, $condition = '', $params = [])
    {
        $models = static::findAll($condition);

        $attributes['updated_at'] = App::timestamp();
        $attributes['updated_by'] = App::identity('id') ?: 0;

        $updateAll = parent::updateAll($attributes, $condition, $params);

        Log::record(new static(), ArrayHelper::map($models, 'id', 'attributes'));

        return $updateAll;
    }

    public function getCanDuplicate()
    {
        return true;
    }

    public function getCanDelete()
    {
        if ($this->_canDelete === null) {
            $res = [];
            if (($relatedModels = $this->relatedModels) != null) {
                foreach ($relatedModels as $model) {
                    if ($this->{$model}) {
                        $res[] = $model;
                    }
                }
            }
            $this->_canDelete = ($res)? false: true;
        }

        return $this->_canDelete;
    }

    public function getCanCreate()
    {
        if ($this->_canCreate === null) {
            $this->_canCreate = true;
        }
        
        return $this->_canCreate;
    }
    
    public function getCanView()
    {
        if ($this->_canView === null) {
            $this->_canView = true;
        }
        
        return $this->_canView;
    }

    public function getCanUpdate()
    {
        if ($this->_canUpdate === null) {
            $this->_canUpdate = true;
        }
        
        return $this->_canUpdate;
    }

    public function getCanActivate()
    {
        if ($this->_canActivate === null) {
            if (App::isGuest()) {
                $this->_canActivate = true;
            }
            else {
                if (App::identity()->can('change-record-status', $this->controllerID())) {
                    $this->_canActivate = true;
                }
                else {
                    $this->_canActivate = false;
                }
            }
        }
        return $this->_canActivate;
    }

    public function getCanInactivate()
    {
        if ($this->_canInactivate === null) {
            if (App::isLogin()
                && App::identity()->can('in-active-data', $this->controllerID())
                && App::identity()->can('change-record-status', $this->controllerID())) {
                    $this->_canInactivate = true;
            }
            else {
                $this->_canInactivate = false;
            }
        }

        return $this->_canInactivate;
    }

    public function getBeforeCanDuplicate()
    {
        if (App::isLogin()) {
            return App::identity()->can('duplicate', $this->controllerID());
        }

        return $this->canDuplicate;
    }

    public function getBeforeCanDelete()
    {
        if (App::isLogin()) {
            return App::identity()->can('delete', $this->controllerID());
        }

        return $this->canDelete;
    }

    public function getBeforeCanCreate()
    {
        if (App::isLogin()) {
            return App::identity()->can('create', $this->controllerID());
        }

        return $this->canCreate;
    }

    public function getBeforeCanView()
    {
        if (App::isLogin()) {
            return App::identity()->can('view', $this->controllerID());
        }

        return $this->canView;
    }

    public function getBeforeCanUpdate()
    {
        if (App::isLogin()) {
            return App::identity()->can('update', $this->controllerID());
        }

        return $this->canUpdate;
    }

    public function getBeforeCanActivate()
    {
        return $this->canActivate;
    }

    public function getBeforeCanInactivate()
    {
        return $this->canInactivate;
    }

    public function activate()
    {
        $this->setActive();
    }

    public function inactivate()
    {
        $this->setInactive();
    }

    public function setActive()
    {
        if ($this->hasProperty('record_status')) {
            $this->record_status = self::RECORD_ACTIVE;
        }
    }

    public function setInactive()
    {
        if ($this->hasProperty('record_status')) {
            $this->record_status = self::RECORD_INACTIVE;
        }
    }
    public function getIsActive()
    {
        if ($this->hasProperty('record_status')) {
            return $this->record_status == self::RECORD_ACTIVE;
        }
    }

    public function getIsInactive()
    {
        if ($this->hasProperty('record_status')) {
            return $this->record_status == self::RECORD_INACTIVE;
        }
    }

    public function getHeaderDetailColumns()
    {
        return [
        ];
    }

    public function getFooterDetailColumns()
    {
        $columns = [
            'created_at' => [
                'attribute' => 'created_at',
                'format' => 'fulldate'
            ],
            'updated_at' => [
                'attribute' => 'updated_at',
                'format' => 'fulldate'
            ],
            'createdByEmail' => [
                'attribute' => 'createdByEmail',
                'format' => 'raw'
            ],
            'updatedByEmail' => [
                'attribute' => 'updatedByEmail',
                'format' => 'raw'
            ],
        ];

        if (App::isLogin() && App::identity()->can('in-active-data', $this->controllerID())) {
            $columns['recordStatusHtml'] = [
                'attribute' => 'recordStatusHtml',
                'format' => 'raw'
            ];
        }

        return $columns;
    }

    public function getDetailView()
    {
        return Detail::widget(['model' => $this]);
    }

    public function getDetailColumns()
    {
        return array_merge(
            $this->getHeaderDetailColumns(),
            $this->detailColumns(),
            $this->getFooterDetailColumns(),
        );
    }

    public function getHeaderGridColumns()
    {
        $columns['serial'] = ['class' => 'yii\grid\SerialColumn'];

        if ($this->bulkActions) {
            $columns['checkbox'] = ['class' => 'app\widgets\CheckboxColumn'];
        }
        
        return $columns;
    }

    public function getFooterGridColumns()
    {
        $columns = [
            'created_at' => ['attribute' => 'created_at', 'format' => 'fulldate'],
            'last_updated' => [
                'attribute' => 'updated_at',
                'label' => 'last updated',
                'format' => 'ago',
            ],
        ];

        if (App::isLogin() && App::identity()->can('in-active-data', $this->controllerID())) {
            $columns['active'] = [
                'attribute' => 'record_status',
                'label' => 'active',
                'format' => 'raw', 
                'value' => 'recordStatusHtml'
            ];
        }
        
        return $columns;
    }

    public function getGridColumns()
    {
        return array_merge(
            $this->getHeaderGridColumns(),
            $this->gridColumns(),
            $this->getFooterGridColumns(),
        );
    }

    public function getTableColumns()
    {
        $gridColumns = $this->getGridColumns();
        $filterColumns = App::identity()->filterColumns($this, false);
        $filterColumns = $filterColumns ?: $this->defaultGridColumns;

        if (App::isLogin()) {
            foreach ($gridColumns as $key => &$column) {

                if ($filterColumns && ! in_array($key, $filterColumns)) {
                    $column['headerOptions']['style'] = 'display:none';
                    $column['contentOptions']['style'] = 'display:none';
                } 

                $column['headerOptions']['data-key'] = $key;
                $column['contentOptions']['data-key'] = $key;

                $column['headerOptions']['class'] = 'table-th';
                $column['contentOptions']['class'] = 'table-td';
            }
        }

        return $gridColumns;
    }

    protected function checkLinkAccess($action, $controllerID='')
    {
        $controllerID = $controllerID ?: $this->controllerID();

        if (App::isLogin()) {
            return App::identity()->can($action, $controllerID);
        }
    }

    public function getLogUrl($fullpath=true)
    {
        if ($this->checkLinkAccess('index', 'log')) {
            $url = [
                'log/index', 
                'model_id' => ($this->id ?? ''),
                'model_name' => App::className($this)
            ];

            return ($fullpath)? Url::to($url, true): $url;
        }
    }

    public function getIndexUrl($fullpath=true)
    {
        if ($this->checkLinkAccess('index')) {
            $paramName = $this->paramName();
            $url = [
                implode('/', [$this->controllerID(), 'index']),
            ];
            return ($fullpath)? Url::to($url, true): $url;
        }
    }

    public function getCreateUrl($fullpath=true)
    {
        if ($this->checkLinkAccess('create')) {
            $paramName = $this->paramName();
            $url = [
                implode('/', [$this->controllerID(), 'create']),
            ];
            return ($fullpath)? Url::to($url, true): $url;
        }
    }

    public function getPrintUrl($fullpath=true)
    {
        if ($this->checkLinkAccess('print')) {
            $url = [implode('/', [$this->controllerID(), 'print'])];
            return ($fullpath)? Url::to($url, true): $url;
        }
    }

    public function getExportPdfUrl($fullpath=true)
    {
        if ($this->checkLinkAccess('export-pdf')) {
            $url = [implode('/', [$this->controllerID(), 'export-pdf'])];
            return ($fullpath)? Url::to($url, true): $url;
        }
    }

    public function getExportCsvUrl($fullpath=true)
    {
        if ($this->checkLinkAccess('export-csv')) {
            $url = [implode('/', [$this->controllerID(), 'export-csv'])];
            return ($fullpath)? Url::to($url, true): $url;
        }
    }

    public function getExportXlsUrl($fullpath=true)
    {
        if ($this->checkLinkAccess('export-xls')) {
            $url = [implode('/', [$this->controllerID(), 'export-xls'])];
            return ($fullpath)? Url::to($url, true): $url;
        }
    }

    public function getExportXlsxUrl($fullpath=true)
    {
        if ($this->checkLinkAccess('export-xlsx')) {
            $url = [
                implode('/', [$this->controllerID(), 'export-xlsx']),
            ];
            return ($fullpath)? Url::to($url, true): $url;
        }
    }

    public function getChangeRecordStatusUrl($fullpath=true)
    {
        if ($this->checkLinkAccess('change-record-status')) {
            $url = [
                implode('/', [$this->controllerID(), 'change-record-status']),
            ];
            return ($fullpath)? Url::to($url, true): $url;
        }
    }

    public function getViewUrl($fullpath=true)
    {
        if ($this->checkLinkAccess('view')) {
            $paramName = $this->paramName();
            $url = [
                implode('/', [$this->controllerID(), 'view']),
                $paramName => $this->{$paramName}
            ];
            return ($fullpath)? Url::to($url, true): $url;
        }
    }

    public function getUpdateUrl($fullpath=true)
    {
        if ($this->checkLinkAccess('update')) {
            $paramName = $this->paramName();
            $url = [
                implode('/', [$this->controllerID(), 'update']),
                $paramName => $this->{$paramName}
            ];
            return ($fullpath)? Url::to($url, true): $url;
        }
    }

    public function getDuplicateUrl($fullpath=true)
    {
        if ($this->checkLinkAccess('duplicate')) {
            $paramName = $this->paramName();
            $url = [
                implode('/', [$this->controllerID(), 'duplicate']),
                $paramName => $this->{$paramName}
            ];
            return ($fullpath)? Url::to($url, true): $url;
        }
    }
    
    public function getDeleteUrl($fullpath=true)
    {
        if ($this->checkLinkAccess('delete')) {
            $paramName = $this->paramName();
            $url = [
                implode('/', [$this->controllerID(), 'delete']),
                $paramName => $this->{$paramName}
            ];
            return ($fullpath)? Url::to($url, true): $url;
        }
    }

    public function getMainAttribute()
    {
        $mainAttribute = $this->mainAttribute();

        if ($this->hasProperty($mainAttribute)) {
            return $this->{$mainAttribute};
        }
    }

    public function getRecordStatus()
    {
        return App::params('record_status')[$this->record_status];
    }

    public function getRecordStatusLabel()
    {
        return $this->recordStatus['label'];
    }

    public function getRecordStatusHtml()
    {
        if (App::isGuest()) {
            return $this->recordStatusLabel;
        }

        $controller = $this->controllerID();
        if (in_array(App::actionID(), ExportForm::EXPORT_ACTIONS)) {
            return $this->recordStatusLabel;
        }

        if (($this->beforeCanActivate || $this->beforeCanInactivate) && $this->beforeCanUpdate) {
            return RecordHtml::widget([
                'model' => $this,
                'controller' => $controller
            ]);
        }

        return RecordHtml::widget([
            'model' => $this,
            'labelOnly' => true
        ]);
    }

    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    public function getCreatedByEmail()
    {
        if ($this->_createdByEmail === null) {
            if(($model = $this->createdBy) != null) {
                $this->_createdByEmail = $model->email;
            }
        }

        if ($this->created_by == 0) {
            $this->_createdByEmail = '';
        }

        return $this->_createdByEmail;
    }

    public function getUpdatedByEmail()
    {
        if ($this->_updatedByEmail === null) {
            if(($model = $this->updatedBy) != null) {
                $this->_updatedByEmail = $model->email;
            }
        }

        if ($this->updated_by == 0) {
            $this->_updatedByEmail = '';
        }

        return $this->_updatedByEmail;
    }

    public function getPreview()
    {
        $url = $this->viewUrl;

        return Anchor::widget([
            'title' => Url::to($url, true),
            'link' => $url,
            'text' => true
        ]);
    }

    public function getBulkActions()
    {
        $columns = [];

        if (App::isLogin() && App::identity()->can('in-active-data', $this->controllerID())) {
            $columns = [
                'active' => [
                    'label' => 'Set as Active',
                    'process' => 'active',
                    'icon' => 'active',
                    'function' => function($id) {
                        static::activeAll(['id' => $id]);
                    }
                ],
                'in_active' => [
                    'label' => 'Set as In-active',
                    'process' => 'in_active',
                    'icon' => 'in_active',
                    'function' => function($id) {
                        static::inactiveAll(['id' => $id]);
                    }
                ],
            ];
        }

        if (App::isLogin() && App::identity()->can('delete', $this->controllerID())) {
            $columns['delete'] = [
                'label' => 'Delete',
                'process' => 'delete',
                'icon' => 'delete',
                'function' => function($id) {
                    static::deleteAll(['id' => $id]);
                }
            ];
        }
        
        return $columns;
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['TimestampBehavior'] = [
            'class' => 'yii\behaviors\TimestampBehavior',
            'value' => new Expression('UTC_TIMESTAMP'),
        ];
        $behaviors['BlameableBehavior'] = [
            'class' => 'yii\behaviors\BlameableBehavior',
            'defaultValue' => 0
        ];
        $behaviors['AttributeTypecastBehavior'] = [
            'class' => 'yii\behaviors\AttributeTypecastBehavior'
        ];
        $behaviors['LogBehavior'] = [
            'class' => 'app\behaviors\LogBehavior'
        ];
        $behaviors['ProcessBehavior'] = [
            'class' => 'app\behaviors\ProcessBehavior'
        ];
        $behaviors['TokenBehavior'] = [
            'class' => 'app\behaviors\TokenBehavior'
        ];
        $behaviors['JsonBehavior'] = [
            'class' => 'app\behaviors\JsonBehavior'
        ];

        return $behaviors;
    }

    public static function one($value, $key='id', $array=false)
    {
        $model = static::find()
            ->visible()
            ->andWhere([$key => $value]);

        $model = ($array) ? $model->asArray()->one(): $model->one();

        return ($model)? $model: '';
    }

    public static function all($value='', $key='id', $array=false)
    {
        $models = static::find()
            ->andFilterWhere([$key => $value]);

        $models = ($array) ? $models->asArray()->all(): $models->all();

        return ($models)? $models: '';
    }

    public static function dropdown($key='id', $value='name', $condition=[], $map=true, $limit=false)
    {
        $models = static::find()
            ->andFilterWhere($condition)
            ->orderBy([$value => SORT_ASC])
            ->limit($limit)
            ->all();

        $models = ($map)? ArrayHelper::map($models, $key, $value): $models;

        return $models;
    }

    public static function filter($key='id', $condition=[], $limit=false, $andFilterWhere=[])
    {
        $models = static::find()
            ->andFilterWhere($condition)
            ->andFilterWhere($andFilterWhere)
            ->orderBy([$key => SORT_ASC])
            ->limit($limit)
            ->groupBy($key)
            ->asArray()
            ->all();

        $models = ArrayHelper::map($models, $key, $key);

        $models = array_filter($models);

        return $models;
    }

    public function getDateAttribute()
    {
        $config = $this->config();
        
        return $config['dateAttribute'] ?? 'created_at';
    }

    public function getStartDate($from_database = false)
    {
        if ($this->date_range && $from_database == false) {
            $date = App::formatter()->asDaterangeToSingle($this->date_range, 'start');
            return date('F d, Y', strtotime($date));
        }
        else {
            if ($this->_startDate === null) {
                $this->_startDate = static::find()
                    ->visible()
                    ->min($this->dateAttribute);
            }
            $date = $this->_startDate ?: 'today';
        }

        return App::formatter()->asDateToTimezone($date, 'F d, Y');
    }

    public function getEndDate($from_database = false)
    {
        if ($this->date_range && $from_database == false) {
            $date = App::formatter()->asDaterangeToSingle($this->date_range, 'end');
            return date('F d, Y', strtotime($date));
        }
        else {
            if ($this->_endDate === null) {
                $this->_endDate = static::find()
                    ->visible()
                    ->max($this->dateAttribute);
            }
            $date = ($this->_endDate)? $this->_endDate: 'today';
        }

        return App::formatter()->asDateToTimezone($date, 'F d, Y');
    }

    public static function findByKeywordsData($attributes, $function)
    {
        $data = [];
        foreach ($attributes as $attribute) {

            $models = call_user_func($function, $attribute);

            $data = array_merge($data, array_values(ArrayHelper::map($models, 'data', 'data')));
        }

        $data = array_values(array_unique(array_map('trim', $data)));
        
        sort($data);

        return $data;
    }

    public static function findByKeywords($keywords='', $attributes='', $limit=10, $andFilterWhere=[])
    {
        $data = [];
        foreach ($attributes as $attribute) {
            $data = array_merge($data, array_values(
                static::filter($attribute, ['LIKE', $attribute, $keywords], $limitl, $andFilterWhere)
            ));
        }

        $data = array_values(array_unique(array_map('trim', $data)));
        $data = array_filter($data);
        
        sort($data);

        return $data;
    }

    public static function findOrFailed($value, $field='id', $action='')
    {
        $action = $action ?: App::actionID();

        if (($model = static::findVisible([$field => $value])) != null) {
            return $model;
        }
        
        throw new NotFoundHttpException('Page not found.');
    }

    public static function controllerFind($value, $field='id', $action='')
    {
        $action = $action ?: App::actionID();
        $model = self::findOrFailed($value, $field, $action);

        if (App::modelBeforeCan($model, $action)) {
            return $model;
        }
        throw new ForbiddenHttpException('Forbidden action to data');
    }

    public function getDefaultGridColumns()
    {
        return array_keys($this->gridColumns);
    }

    public function flashErrors()
    {
        if ($this->errors) {
            App::danger($this->errorSummary);
        }
    }
}