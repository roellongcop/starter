<?php

namespace app\models;

use Yii;
use app\behaviors\LogBehavior;
use app\behaviors\JsonBehavior;
use app\helpers\App;
use app\models\search\SettingSearch;
use app\widgets\Anchor;
use app\widgets\JsonEditor;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%roles}}".
 *
 * @property int $id
 * @property string $name
 * @property string|null $main_navigation
 * @property string|null $role_access
 * @property string|null $module_access
 * @property string $slug
 * @property int $record_status
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class Role extends ActiveRecord
{
    public $relatedModels = [];
    //public $excel_ignore_attr = [];
    //public $fileInput;
    // public $imageInput;
    //public $fileLocation; 

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%roles}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'record_status'], 'required'],
            [['record_status'], 'default', 'value' => 1],
            [['main_navigation', 'role_access', 'module_access'], 'safe'],
            [['record_status', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'slug'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['slug'], 'unique'],
            /*[
                ['fileInput'], 
                'file', 
                'skipOnEmpty' => true, 
                'extensions' => App::params('file_extensions')['file'], 
                'checkExtensionByMimeType' => false
            ],
            [
                ['imageInput'], 
                'image', 
                'minWidth' => 100,
                'maxWidth' => 200,
                'minHeight' => 100,
                'maxHeight' => 200,
                'maxSize' => 1024 * 1024 * 2,
                'skipOnEmpty' => true, 
                'extensions' => App::params('file_extensions')['image'], 
                'checkExtensionByMimeType' => false
            ],*/
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'main_navigation' => 'Main Navigation',
            'role_access' => 'Role Access',
            'module_access' => 'Module Access',
            'slug' => 'Slug',
            'record_status' => 'Record Status',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'recordStatusHtml' => 'Record Status',
            'recordStatusLabel' => 'Record Status',
            'jsonMainNavigation' => 'Main Navigation',
            'jsonRoleAccess' => 'Role Access',
            'jsonModuleAccess' => 'Module Access',
        ];
    }
      

    public function getCanDelete()
    {
        $dontDelete = [];

        foreach ($this->relatedModels as $model) {
            if ($this->{$model}) {
                $dontDelete[] = $model;
            }
        }

        if (App::identity('role_id') == $this->id) {
            $dontDelete = true;
        }


        return ($dontDelete)? false: true;
    }
    

    public function getJsonRoleAccess()
    {
        return JsonEditor::widget([
            'data' => $this->role_access,
        ]);
    }

    public function getJsonMainNavigation()
    {
        return JsonEditor::widget([
            'data' => $this->main_navigation,
        ]);
    }

    public function getJsonModuleAccess()
    {
        return JsonEditor::widget([
            'data' => $this->module_access,
        ]);
    }

    public function tableColumns()
    {
        return [
            'serial' => [
                'class' => 'yii\grid\SerialColumn',
            ],
            'checkbox' => ['class' => 'app\widgets\CheckboxColumn'],
            'name' => [
                'attribute' => 'name', 
                'format' => 'raw',
                'value' => function($model) {
                    return Anchor::widget([
                        'title' => $model->name,
                        'link' => ['view', 'id' => $model->id],
                        'text' => true
                    ]);
                }
            ],
            // 'main_navigation' => ['attribute' => 'main_navigation', 'format' => 'raw'],
            // 'role_access' => ['attribute' => 'role_access', 'format' => 'raw'],
            // 'module_access' => ['attribute' => 'module_access', 'format' => 'raw'],
            // 'slug' => ['attribute' => 'slug', 'format' => 'raw'],
            'created_at' => [
                'attribute' => 'created_at',
                'format' => 'fulldate',
            ],
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

    public function getDetailColumns()
    {
        return [
            'name:raw',
            'jsonMainNavigation:raw',
            'jsonRoleAccess:raw',
            'jsonModuleAccess:raw',
            'slug:raw',
			'created_at:fulldate',
            'updated_at:fulldate',
            'createdByEmail',
            'updatedByEmail',
            'recordStatusHtml:raw'
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'name',
                'slugAttribute' => 'slug',
                'immutable' => false,
                'ensureUnique' => true,
            ],
            [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('UTC_TIMESTAMP'),
            ],
            [
                'class' => BlameableBehavior::className(),
                'defaultValue' => 0
            ],
            [
                'class' => JsonBehavior::className(),
                'fields' => ['role_access', 'main_navigation', 'module_access']
            ], 
            ['class' => LogBehavior::className()], 
        ];
    }
    
}
