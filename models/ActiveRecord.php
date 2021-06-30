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
use yii\helpers\Url;
 
abstract class ActiveRecord extends \yii\db\ActiveRecord
{
    public abstract function config();
    
    const RECORD_ACTIVE = 1;
    const RECORD_INACTIVE = 0;

    public $_startDate;
    public $_endDate;
    public $_createdByEmail;
    public $_updatedByEmail;

    public $_modelImageFiles;
    public $_modelImageFile;

    public $_modelDocumentFiles;
    public $_modelDocumentFile;

    public $_modelSqlFiles;
    public $_modelSqlFile;

    public $errorSummary;

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
            // 'required' => ['record_status', 'required'],
            'default' => ['record_status', 'default', 'value' => 1],
            'range' => ['record_status', 'in', 'range' => [self::RECORD_ACTIVE, self::RECORD_INACTIVE]],
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

            if ($this->isInactive && !$this->canDeactivate) {
                $this->addError($attribute, 'Cannot be Deactivated');
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
        return self::updateAll(['record_status' => 1], $condition);
    }

    public static function inactiveAll($condition = '')
    {
        return self::updateAll(['record_status' => 0], $condition);
    }

    public static function deleteAll($condition = null, $params = []) 
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

    public function activate()
    {
        $this->setActive();
    }

    public function deactivate()
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
        return [
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
            'recordStatusHtml' => [
                'attribute' => 'recordStatusHtml',
                'format' => 'raw'
            ]
        ];
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
        return [
            'created_at' => ['attribute' => 'created_at', 'format' => 'fulldate'],
            'last_updated' => [
                'attribute' => 'updated_at',
                'label' => 'last updated',
                'format' => 'ago',
            ],
            'active' => [
                'attribute' => 'record_status',
                'label' => 'active',
                'format' => 'raw', 
                'value' => 'recordStatusHtml'
            ],
        ];
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

        if (App::isLogin() && $filterColumns) {
            foreach ($gridColumns as $key => &$column) {
                if (! isset($column['visible'])) {
                    $column['visible'] = in_array($key, $filterColumns)? true: false;
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
            ->andFilterWhere(['extension' => $extension ])
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
        if ($this->_modelImageFiles) {
            return $this->_modelImageFiles;
        }

        $this->_modelImageFiles = $this->getModelFiles(App::params('file_extensions')['image']);

        return $this->_modelImageFiles; 
    }

    public function getModelImageFile()
    {
        if ($this->_modelImageFile) {
            return $this->_modelImageFile;
        }

        $this->_modelImageFile = $this->getModelFile(App::params('file_extensions')['image']);

        return $this->_modelImageFile; 
    }

    public function getImageFiles()
    {
        if (($modelImageFiles = $this->modelImageFiles) != null) {
            $files = [];

            foreach ($modelImageFiles as $modelFile) {
                array_push($files, $modelFile->file);
            }
            return $files;
        }
    }

    public function getImageFile()
    {
        if (($modelImageFile = $this->modelImageFile) != null) {
            return $modelImageFile->file;
        }
    }

    public function getImagePath($params=[])
    {
        if(($modelFile = $this->modelImageFile) != null) {
            $path = array_merge(['file/display', 'token' => $modelFile->fileToken], $params);
            return Url::to($path, true);
        }
        return App::setting('image_holder');
    }

    public function getModelDocumentFiles()
    {
        if ($this->_modelDocumentFiles) {
            return $this->_modelDocumentFiles;
        }

        $this->_modelDocumentFiles = $this->getModelFiles(App::params('file_extensions')['file']);

        return $this->_modelDocumentFiles; 
    }

    public function getModelDocumentFile()
    {
        if ($this->_modelDocumentFile) {
            return $this->_modelDocumentFile;
        }

        $this->_modelDocumentFile = $this->getModelFile(App::params('file_extensions')['file']);

        return $this->_modelDocumentFile; 
    }

    public function getModelSqlFiles()
    {
        if ($this->_modelSqlFiles) {
            return $this->_modelSqlFiles;
        }

        $this->_modelSqlFiles = $this->getModelFiles(['sql']);

        return $this->_modelSqlFiles; 
    }

    public function getModelSqlFile()
    {
        if ($this->_modelSqlFile) {
            return $this->_modelSqlFile;
        }

        $this->_modelSqlFile = $this->getModelFile(['sql']);

        return $this->_modelSqlFile; 
    }

    public function getSqlFileLocation()
    {
        if(($modelFile = $this->modelSqlFile) != null) {
            return $modelFile->fileLocation;
        }
    }

    public function getSqlFilePath()
    {
        if(($modelFile = $this->modelSqlFile) != null) {
            return Url::to(['file/display', 'token' => $modelFile->fileToken], true);
        }
    }

    public function getRecordStatus()
    {
        return App::params('record_status')[$this->record_status] ?? [];
    }

    public function getRecordStatusLabel()
    {
        return $this->recordStatus['label'] ?? '';
    }

    public function getRecordStatusHtml()
    {

        if (App::isGuest()) {
            return $this->recordStatusLabel;
        }

        $controller = $this->controllerID();
        if (in_array(App::actionID(), App::params('export_actions'))) {
            return $this->recordStatusLabel;
        }

        if ($this->canActivate && $this->canDeactivate && $this->canUpdate) {
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
        if ($this->created_by == 0) {
            return;
        }
        if ($this->_createdByEmail) {
            return $this->_createdByEmail;
        }

        if(($model = $this->createdBy) != null) {
            $this->_createdByEmail = $model->email;
            return $this->_createdByEmail;
        }
    }

    public function getUpdatedByEmail()
    {
        if ($this->updated_by == 0) {
            return;
        }

        if ($this->_updatedByEmail) {
            return $this->_updatedByEmail;
        }

        if(($model = $this->updatedBy) != null) {
            $this->_updatedByEmail = $model->email;
            return $this->_updatedByEmail;
        }
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
        return [
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
            'delete' => [
                'label' => 'Delete',
                'process' => 'delete',
                'icon' => 'delete',
            ]
        ];
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
        $model = static::find()
            ->andFilterWhere([$key => $value]);

        $model = ($array) ? $model->asArray()->all(): $model->all();

        return ($model)? $model: '';
    }

    public static function dropdown($key='id', $value='name', $condition=[], $map=true)
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

    public function getStartDate($from_database = false)
    {
        if ($this->date_range && $from_database == false) {
            $date = App::dateRange($this->date_range, 'start');
            return date('F d, Y', strtotime($date));
        }
        else {
            $model = $this->_startDate ?: static::find()
                ->visible()
                ->min('created_at');

            $this->_startDate = $model;

            $date = ($model)? $model: 'today';
        }

        return App::formatter()->asDateToTimezone($date, 'F d, Y');
    }

    public function getEndDate($from_database = false)
    {
        if ($this->date_range && $from_database == false) {
            $date = App::dateRange($this->date_range, 'end');
            return date('F d, Y', strtotime($date));
        }
        else {
            $model = $this->_endDate ?: static::find()
                ->visible()
                ->max('created_at');

            $this->_endDate = $model;

            $date = ($model)? $model: 'today';
        }

        return App::formatter()->asDateToTimezone($date, 'F d, Y');
    }
}