<?php

namespace app\models;

use Yii;
use app\behaviors\JsonBehavior;
use app\behaviors\LogBehavior;
use app\behaviors\ProcessBehavior;
use app\behaviors\TokenBehavior;
use app\helpers\App;
use app\helpers\Html;
use app\models\Log;
use app\models\search\SettingSearch;
use app\widgets\Anchor;
use app\widgets\RecordHtml;
use yii\behaviors\AttributeTypecastBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use app\helpers\Url;
 
abstract class ActiveRecord extends \yii\db\ActiveRecord
{
    public abstract function config();
    
    const RECORD_ACTIVE = 1;
    const RECORD_INACTIVE = 0;

    const RECORDS = [
        1 => [
            'id' => 1,
            'label' => 'Active',
            'class' => 'success'
        ],
        0 => [
            'id' => 0,
            'label' => 'In-active',
            'class' => 'danger'
        ],
    ];

    public $_startDate;
    public $_endDate;
    public $_createdByEmail;
    public $_updatedByEmail;

    public $_modelImageFiles;
    public $_modelImageFile;

    public $_modelDocumentFiles;
    public $_modelDocumentFile;

    public $_canCreate;
    public $_canView;
    public $_canUpdate;
    public $_canDelete;
    public $_canActivate;
    public $_canInactivate;

    public $errorSummary;

    public static function mapRecords()
    {
        return ArrayHelper::map(self::RECORDS, 'id', 'label');
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
            'integer' => [['created_by', 'updated_by', 'record_status'], 'integer'],
            'safe' => [['created_at', 'updated_at'], 'safe'],
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
            if ($this->isActive && !$this->canActivate) {
                $this->addError($attribute, 'Cannot be Activated');
            }

            if ($this->isInactive && !$this->canInactivate) {
                $this->addError($attribute, 'Cannot be Inactivated');
            }
        }
    }

    public function validate($attributeNames = NULL, $clearErrors = TRUE)
    {
        $validate = parent::validate($attributeNames, $clearErrors);

        if (!$validate) {
            $this->errorSummary = Html::errorSummary($this, ['class' => 'error-summary']);
        }

        return $validate;
    }

    public function save($runValidation = TRUE, $attributeNames = NULL)
    {
        $save = parent::save($runValidation, $attributeNames);

        if (!$save) {
            $this->errorSummary = Html::errorSummary($this, ['class' => 'error-summary']);
        }

        return $save;
    }

    public static function activeAll($condition = '')
    {
        return self::updateAll(['record_status' => 1], $condition);
    }

    public static function inactiveAll($condition = '')
    {
        return self::updateAll(['record_status' => 0], $condition);
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

    public static function deleteAll($condition = NULL, $params = []) 
    {
        $models = static::findAll($condition);
        $deleteAll = parent::deleteAll($condition);

        Log::record(new static(), ArrayHelper::map($models, 'id', 'attributes'));

        return $deleteAll;
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

    public function getCanDelete()
    {
        if ($this->_canDelete === NULL) {
            $res = [];
            if (($relatedModels = $this->relatedModels) != NULL) {
                foreach ($relatedModels as $model) {
                    if ($this->{$model}) {
                        $res[] = $model;
                    }
                }
            }
            $this->_canDelete = ($res)? FALSE: TRUE;
        }

        return $this->_canDelete;
    }

    public function getCanCreate()
    {
        if ($this->_canCreate === NULL) {
            $this->_canCreate = TRUE;
        }
        
        return $this->_canCreate;
    }
    
    public function getCanView()
    {
        if ($this->_canView === NULL) {
            $this->_canView = TRUE;
        }
        
        return $this->_canView;
    }

    public function getCanUpdate()
    {
        if ($this->_canUpdate === NULL) {
            $this->_canUpdate = TRUE;
        }
        
        return $this->_canUpdate;
    }

    public function getCanActivate()
    {
        if ($this->_canActivate === NULL) {
            if (App::isGuest()) {
                $this->_canActivate = TRUE;
            }
            else {
                if (App::identity()->can('change-record-status', $this->controllerID())) {
                    $this->_canActivate = TRUE;
                }
                else {
                    $this->_canActivate = FALSE;
                }
            }
        }
        return $this->_canActivate;
    }

    public function getCanInactivate()
    {
        if ($this->_canInactivate === NULL) {
            if (App::isLogin()
                && App::identity()->can('in-active-data', $this->controllerID())
                && App::identity()->can('change-record-status', $this->controllerID())) {
                    $this->_canInactivate = TRUE;
            }
            else {
                $this->_canInactivate = FALSE;
            }
        }

        return $this->_canInactivate;
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
        return [
            'serial' => ['class' => 'yii\grid\SerialColumn'],
            'checkbox' => ['class' => 'app\widgets\CheckboxColumn'],
        ];
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
        $filterColumns = App::identity()->filterColumns($this, FALSE);

        if (App::isLogin() && $filterColumns) {
            foreach ($gridColumns as $key => &$column) {
                if (! isset($column['visible'])) {
                    $column['visible'] = in_array($key, $filterColumns)? TRUE: FALSE;
                }
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

    public function getLogUrl($fullpath=TRUE)
    {
        if ($this->checkLinkAccess('index', 'log')) {
            $url = [
                'log/index', 
                'model_id' => ($this->id ?? ''),
                'model_name' => App::className($this)
            ];

            return ($fullpath)? Url::to($url, TRUE): $url;
        }
    }

    public function getIndexUrl($fullpath=TRUE)
    {
        if ($this->checkLinkAccess('index')) {
            $paramName = $this->paramName();
            $url = [
                implode('/', [$this->controllerID(), 'index']),
            ];
            return ($fullpath)? Url::to($url, TRUE): $url;
        }
    }

    public function getCreateUrl($fullpath=TRUE)
    {
        if ($this->checkLinkAccess('create')) {
            $paramName = $this->paramName();
            $url = [
                implode('/', [$this->controllerID(), 'create']),
            ];
            return ($fullpath)? Url::to($url, TRUE): $url;
        }
    }

    public function getPrintUrl($fullpath=TRUE)
    {
        if ($this->checkLinkAccess('print')) {
            $url = [implode('/', [$this->controllerID(), 'print'])];
            return ($fullpath)? Url::to($url, TRUE): $url;
        }
    }

    public function getExportPdfUrl($fullpath=TRUE)
    {
        if ($this->checkLinkAccess('export-pdf')) {
            $url = [implode('/', [$this->controllerID(), 'export-pdf'])];
            return ($fullpath)? Url::to($url, TRUE): $url;
        }
    }

    public function getExportCsvUrl($fullpath=TRUE)
    {
        if ($this->checkLinkAccess('export-csv')) {
            $url = [implode('/', [$this->controllerID(), 'export-csv'])];
            return ($fullpath)? Url::to($url, TRUE): $url;
        }
    }

    public function getExportXlsUrl($fullpath=TRUE)
    {
        if ($this->checkLinkAccess('export-xls')) {
            $url = [implode('/', [$this->controllerID(), 'export-xls'])];
            return ($fullpath)? Url::to($url, TRUE): $url;
        }
    }

    public function getExportXlsxUrl($fullpath=TRUE)
    {
        if ($this->checkLinkAccess('export-xlsx')) {
            $url = [
                implode('/', [$this->controllerID(), 'export-xlsx']),
            ];
            return ($fullpath)? Url::to($url, TRUE): $url;
        }
    }

    public function getViewUrl($fullpath=TRUE)
    {
        if ($this->checkLinkAccess('view')) {
            $paramName = $this->paramName();
            $url = [
                implode('/', [$this->controllerID(), 'view']),
                $paramName => $this->{$paramName}
            ];
            return ($fullpath)? Url::to($url, TRUE): $url;
        }
    }

    public function getUpdateUrl($fullpath=TRUE)
    {
        if ($this->checkLinkAccess('update')) {
            $paramName = $this->paramName();
            $url = [
                implode('/', [$this->controllerID(), 'update']),
                $paramName => $this->{$paramName}
            ];
            return ($fullpath)? Url::to($url, TRUE): $url;
        }
    }

    public function getDuplicateUrl($fullpath=TRUE)
    {
        if ($this->checkLinkAccess('duplicate')) {
            $paramName = $this->paramName();
            $url = [
                implode('/', [$this->controllerID(), 'duplicate']),
                $paramName => $this->{$paramName}
            ];
            return ($fullpath)? Url::to($url, TRUE): $url;
        }
    }
    
    public function getDeleteUrl($fullpath=TRUE)
    {
        if ($this->checkLinkAccess('delete')) {
            $paramName = $this->paramName();
            $url = [
                implode('/', [$this->controllerID(), 'delete']),
                $paramName => $this->{$paramName}
            ];
            return ($fullpath)? Url::to($url, TRUE): $url;
        }
    }

    public function getMainAttribute()
    {
        $mainAttribute = $this->mainAttribute();

        if ($this->hasProperty($mainAttribute)) {
            return $this->{$mainAttribute};
        }
    }

    public function getFiles()
    {
        return $this->hasMany(File::ClassName(), ['id' => 'file_id'])
            ->viaTable('{{%model_files}}', ['model_id' => 'id']);
    }

    public function getModelFiles($extension = [])
    {
        return ModelFile::find()
            ->select([
                'MAX(id) AS id',
                'model_id',
                'file_id',
                'model_name',
                'extension',
                'record_status',
                'created_by',
                'updated_by',
                'created_at',
                'updated_at',
            ])
            ->where([
                'model_id' => $this->id,
                'model_name' => App::getModelName($this)
            ])
            ->andFilterWhere(['extension' => $extension])
            ->groupBy(['file_id'])
            ->orderBy(['MAX(id)' => SORT_DESC])
            ->all();
    }

    public function getModelFile($extension = [])
    {
        return ModelFile::find()
            ->select([
                'MAX(id) AS id',
                'model_id',
                'file_id',
                'model_name',
                'extension',
                'record_status',
                'created_by',
                'updated_by',
                'created_at',
                'updated_at',
            ])
            ->where([
                'model_id' => $this->id,
                'model_name' => App::getModelName($this)
            ])
            ->andFilterWhere(['extension' => $extension])
            ->groupBy(['file_id'])
            ->orderBy(['MAX(id)' => SORT_DESC])
            ->one();
    }

    public function getModelImageFiles()
    {
        if ($this->_modelImageFiles === NULL) {
            $this->_modelImageFiles = $this->getModelFiles(App::file('file_extensions')['image']);
        }

        return $this->_modelImageFiles; 
    }

    public function getModelImageFile()
    {
        if ($this->_modelImageFile === NULL) {
            $this->_modelImageFile = $this->getModelFile(App::file('file_extensions')['image']);
        }

        return $this->_modelImageFile; 
    }

    public function getImageFiles()
    {
        if (($modelImageFiles = $this->modelImageFiles) != NULL) {
            $files = [];

            foreach ($modelImageFiles as $modelFile) {
                array_push($files, $modelFile->file);
            }
            return $files;
        }
    }

    public function getImageFile()
    {
        if (($modelImageFile = $this->modelImageFile) != NULL) {
            return $modelImageFile->file;
        }
    }

    public function getImagePath($params=[])
    {
        if(($modelFile = $this->modelImageFile) != NULL) {
            if ($modelFile->file) {
                return $modelFile->file->getDisplay($params);
            }
        }
        return App::generalSetting('image_holder');
    }

    public function getModelDocumentFiles()
    {
        if ($this->_modelDocumentFiles === NULL) {
            $this->_modelDocumentFiles = $this->getModelFiles(App::file('file_extensions')['file']);
        }

        return $this->_modelDocumentFiles; 
    }

    public function getModelDocumentFile()
    {
        if ($this->_modelDocumentFile === NULL) {
            $this->_modelDocumentFile = $this->getModelFile(App::file('file_extensions')['file']);
        }

        return $this->_modelDocumentFile; 
    }

    public function getModelSqlFiles()
    {
        return $this->getModelFiles(['sql']);
    }

    public function getModelSqlFile()
    {
        return $this->getModelFile(['sql']);
    }

    public function getSqlFileLocation()
    {
        if(($modelFile = $this->modelSqlFile) != NULL) {
            return $modelFile->fileLocation;
        }
    }

    public function getSqlFilePath()
    {
        if(($modelFile = $this->modelSqlFile) != NULL) {
            if ($modelFile->file) {
                return $modelFile->file->display;
            }
        }
    }

    public function getRecordStatus()
    {
        return self::RECORDS[$this->record_status];
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
        if (in_array(App::actionID(), App::export('export_actions'))) {
            return $this->recordStatusLabel;
        }

        if ($this->canActivate && $this->canInactivate && $this->canUpdate) {
            return RecordHtml::widget([
                'model' => $this,
                'controller' => $controller
            ]);
        }

        return RecordHtml::widget([
            'model' => $this,
            'labelOnly' => TRUE
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
        if ($this->_createdByEmail === NULL) {
            if(($model = $this->createdBy) != NULL) {
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
        if ($this->_updatedByEmail === NULL) {
            if(($model = $this->updatedBy) != NULL) {
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
            'title' => Url::to($url, TRUE),
            'link' => $url,
            'text' => TRUE
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
                ],
                'in_active' => [
                    'label' => 'Set as In-active',
                    'process' => 'in_active',
                    'icon' => 'in_active',
                ],
            ];
        }

        $columns['delete'] = [
            'label' => 'Delete',
            'process' => 'delete',
            'icon' => 'delete',
        ];
        
        return $columns;
    }

    public function upload()
    {
        if (isset($this->imageInput) && $this->imageInput) {
            return App::component('file')->upload($this, 'imageInput');
        } 
    }

    public function behaviors()
    {
        return [
            'TimestampBehavior' => [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('UTC_TIMESTAMP'),
            ],
            'BlameableBehavior' => [
                'class' => BlameableBehavior::className(),
                'defaultValue' => 0
            ],
            'AttributeTypecastBehavior' => ['class' => AttributeTypecastBehavior::className()],
            'LogBehavior' => ['class' => LogBehavior::className()],
            'ProcessBehavior' => ['class' => ProcessBehavior::className()],
            'TokenBehavior' => ['class' => TokenBehavior::className()],
            'JsonBehavior' => ['class' => JsonBehavior::className()],
        ];
    }

    public static function one($value, $key='id', $array=FALSE)
    {
        $model = static::find()
            ->visible()
            ->andWhere([$key => $value]);

        $model = ($array) ? $model->asArray()->one(): $model->one();

        return ($model)? $model: '';
    }

    public static function all($value='', $key='id', $array=FALSE)
    {
        $model = static::find()
            ->andFilterWhere([$key => $value]);

        $model = ($array) ? $model->asArray()->all(): $model->all();

        return ($model)? $model: '';
    }

    public static function dropdown($key='id', $value='name', $condition=[], $map=TRUE)
    {
        $models = static::find()
            ->andFilterWhere($condition)
            ->orderBy([$value => SORT_ASC])
            ->all();

        $models = ($map)? ArrayHelper::map($models, $key, $value): $models;

        return $models;
    }

    public static function filter($key='id', $condition=[])
    {
        $models = static::find()
            ->andFilterWhere($condition)
            ->orderBy([$key => SORT_ASC])
            ->groupBy($key)
            ->all();

        $models = ArrayHelper::map($models, $key, $key);

        return $models;
    }

    public function getStartDate($from_database = FALSE)
    {
        if ($this->date_range && $from_database == FALSE) {
            $date = App::dateRange($this->date_range, 'start');
            return date('F d, Y', strtotime($date));
        }
        else {
            if ($this->_startDate === NULL) {
                $this->_startDate = static::find()
                    ->visible()
                    ->min('created_at');
            }
            $date = $this->_startDate ?: 'today';
        }

        return App::formatter()->asDateToTimezone($date, 'F d, Y');
    }

    public function getEndDate($from_database = FALSE)
    {
        if ($this->date_range && $from_database == FALSE) {
            $date = App::dateRange($this->date_range, 'end');
            return date('F d, Y', strtotime($date));
        }
        else {
            if ($this->_endDate === NULL) {
                $this->_endDate = static::find()
                    ->visible()
                    ->max('created_at');
            }
            $date = ($this->_endDate)? $this->_endDate: 'today';
        }

        return App::formatter()->asDateToTimezone($date, 'F d, Y');
    }
}