<?php

namespace app\models;

use Yii;
use app\behaviors\JsonBehavior;
use app\helpers\App;
use app\models\search\SettingSearch;
use app\widgets\Anchor;
use app\widgets\RecordHtml;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\Inflector;
use yii\helpers\Json;
use yii\helpers\Url;
 
abstract class ActiveRecord extends \yii\db\ActiveRecord
{
    public $logAfterSave = true;
    public $logAfterDelete = true;


    public function getMainAttribute()
    {
        return $this->name ?? $this->id;
    }

    public function getModelFiles()
    {
        return $this->hasMany(ModelFile::className(), ['model_id' => 'id'])
            ->onCondition(['model_name' => App::getModelName($this)])
            ->orderBy(['id' => SORT_DESC]);
    }

    public function getModelFile()
    {
        return $this->hasOne(ModelFile::className(), ['model_id' => 'id'])
            ->onCondition(['model_name' => App::getModelName($this)])
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

    public function getCreatedAt()
    {
        return App::date_timezone($this->created_at);
    }

    public function getUpdatedAt()
    {
        return App::date_timezone($this->updated_at); 
    }

    public function getLastUpdated()
    {
        return App::ago($this->updated_at);
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
        if (in_array(App::actionID(), App::params('export_actions'))) {
            return $this->recordStatusLabel;
        }

        if (App::isLogin() && App::component('access')->userCan('change-record-status')) {
            return RecordHtml::widget([
                'model' => $this,
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
        if (($relatedModels = $this->relatedModels) != null) {
            foreach ($relatedModels as $model) {
                if ($this->{$model}) {
                    $res[] = $model;
                }
            }
        }

        return ($res)? false: true;
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
        $controller = Inflector::camel2id(App::getModelName($this));
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
            [
                'label' => 'Set as Active',
                'process' => 'active',
                'icon' => 'active',
            ],
            [
                'label' => 'Set as In-active',
                'process' => 'in_active',
                'icon' => 'in_active',
            ],
            [
                'label' => 'Delete',
                'process' => 'delete',
                'icon' => 'delete',
            ]
        ];
    }

    public function upload()
    {
        if ($this->imageInput) {
            App::component('file')->upload($this, 'imageInput');
        } 
    }  

    // public function beforeSave($insert)
    // {
    //     if (parent::beforeSave($insert)) {
    //         $this->encodeModelAttribute();
    //         $this->updated_at = App::timestamp();
    //         $this->updated_by = App::isLogin()? App::identity('id'): 0;
    //         if ($this->isNewRecord) {
    //             $this->created_by = $this->created_by ?: $this->updated_by;
    //             $this->created_at = $this->created_at ?: $this->updated_at;
    //         }
    //         return true;
    //     }
    // }

    private function encodeModelAttribute()
    {
        if (isset($this->arrayAttr)) {
            foreach ($this->arrayAttr as $e) {
                if (is_array($this->{$e})) {
                    $this->{$e} = Json::encode($this->{$e});
                }
            }
        }
    }
    private function decodeModelAttribute()
    {
        if (isset($this->arrayAttr)) {
            foreach ($this->arrayAttr as $e) {
                $this->{$e} = $this->{$e}? Json::decode($this->{$e}, TRUE): [];
            }
        }
    }


    public function afterFind()
    {
        parent::afterFind();

        $this->decodeModelAttribute();
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ($this->logAfterSave) {
            parent::afterSave($insert, $changedAttributes);
            App::component('logbook')->log($this, $changedAttributes);
        }
        
        return false;
    }

    public function afterDelete()
    {
        if ($this->logAfterDelete) {
            parent::afterDelete();
            App::component('logbook')->log($this, $this->attributes);
        }
        return false;
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('UTC_TIMESTAMP'),
            ],
            [
                'class' => BlameableBehavior::className(),
            ],
            [
                'class' => JsonBehavior::className(),
            ],
        ];
    }
 
}
