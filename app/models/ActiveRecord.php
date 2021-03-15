<?php

namespace app\models;

use Yii;
use app\behaviors\JsonBehavior;
use app\behaviors\LogBehavior;
use app\behaviors\ProcessBehavior;
use app\behaviors\TokenBehavior;
use app\helpers\App;
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
    public function getMainAttribute()
    {
        if ($this->hasProperty('name')) {
            return $this->name;
        }
        if ($this->hasProperty('id')) {
            return $this->id;
        }
    }

    public function getModelFiles()
    {
        return $this->hasMany(ModelFile::className(), ['model_id' => 'id'])
            ->onCondition(['model_name' => App::getModelName($this)])
            ->groupBy('file_id')
            ->orderBy(['id' => SORT_DESC]);
    }

    public function getModelFile()
    {
        return $this->hasOne(ModelFile::className(), ['model_id' => 'id'])
            ->onCondition(['model_name' => App::getModelName($this)])
            ->groupBy('file_id')
            ->orderBy(['id' => SORT_DESC]);
    }


    public function getFiles()
    {
        return $this->hasMany(File::className(), ['id' => 'file_id'])
            ->via('modelFiles');
    }

    public function getImageFiles()
    {
        return $this->hasMany(File::className(), ['id' => 'file_id'])
            ->onCondition(['extension' => App::params('file_extensions')['image']])
            ->via('modelFiles');
    }

    public function getImageFile()
    {
        return $this->hasOne(File::className(), ['id' => 'file_id'])
            ->onCondition(['extension' => App::params('file_extensions')['image']])
            ->via('modelFile');
    }

    public function getImagePath()
    {
        if(($file = $this->imageFile) != null) {
            if ($file) {
                return Url::to(['file/display', 'token' => $file->token], true);
            }
        } 

        return SettingSearch::defaultImage('image_holder');
    }

    public function getSqlFiles()
    {
        return $this->hasMany(File::className(), ['id' => 'file_id'])
            ->onCondition(['extension' => 'sql'])
            ->via('modelFiles');
    }

    public function getSqlFile()
    {
        return $this->hasOne(File::className(), ['id' => 'file_id'])
            ->onCondition(['extension' => 'sql'])
            ->via('modelFile');
    }


    public function getSqlFileLocation()
    {
        if(($file = $this->sqlFile) != null) {
            if ($file) {
                return  $file->location;
            }
        }
    }

    public function getSqlFilePath()
    {
        if(($sqlFiles = $this->sqlFiles) != null) {
            $file = $sqlFiles[0] ?? '';
            if ($file) {
                return Url::to(['file/display', 'token' => $file->token], true);
            }
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
        $controller = ($this->hasProperty('controllerName'))? $this->controllerName: Inflector::camel2id(App::getModelName($this));


        if (in_array(App::actionID(), App::params('export_actions'))) {
            return $this->recordStatusLabel;
        }

        if (App::isLogin() && App::component('access')->userCan('change-record-status', $controller)) {
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

    public function getCanDelete()
    {
        $res = [];
        if (isset($this->relatedModels)) {
            if (($relatedModels = $this->relatedModels) != null) {
                foreach ($relatedModels as $model) {
                    if ($this->{$model}) {
                        $res[] = $model;
                    }
                }
            }
        }
        return ($res)? false: true;
    }

    public function getCanCreate()
    {
        return true;
    }
    
    public function getCanView()
    {
        return true;
    }

    public function getCanUpdate()
    {
        return true;
    }

    public function getCanActive()
    {
        return true;
    }

    public function getCanIn_active()
    {
        return true;
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
        if(($model = $this->createdBy) != null) {
            return $model->email;
        }
    }

    public function getUpdatedByEmail()
    {
        if(($model = $this->updatedBy) != null) {
            return $model->email;
        }
    }

    public function getPreview()
    {
        $controller = ($this->hasProperty('controllerName'))? $this->controllerName: Inflector::camel2id(App::getModelName($this));

        $url = ["{$controller}/view", 'id' => $this->id];

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
            App::component('file')->upload($this, 'imageInput');
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
            'AttributeTypecastBehavior' => [
                'class' => AttributeTypecastBehavior::className()
            ],
            'LogBehavior' => [
                'class' => LogBehavior::className()
            ], 
            'ProcessBehavior' => [
                'class' => ProcessBehavior::className()
            ], 
            'TokenBehavior' => [
                'class' => TokenBehavior::className()
            ],
            'JsonBehavior' => [
                'class' => JsonBehavior::className()
            ],
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
        }
        else {
            $model = static::find()
                ->visible()
                ->min('created_at');

            $date = ($model)? $model: 'today';
        }

        return App::date_timezone($date, 'F d, Y');
    }

    public function getEndDate($from_database = false)
    {
        if ($this->date_range && $from_database == false) {
            $date = App::dateRange($this->date_range, 'end');
        }
        else {
            $model = static::find()
                ->visible()
                ->max('created_at');

            $date = ($model)? $model: 'today';
        }

        return App::date_timezone($date, 'F d, Y');
    }
}
