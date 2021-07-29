<?php

namespace app\models;

use Yii;
use app\helpers\App;
use app\widgets\Anchor;
use app\widgets\JsonEditor;
use yii\behaviors\SluggableBehavior;
use app\helpers\Url;

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
    const DEVELOPER = 1;
    const SUPERADMIN = 2;
    const ADMIN = 3;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%roles}}';
    }

    public function config()
    {
        return [
            'controllerID' => 'role',
            'mainAttribute' => 'name',
            'paramName' => 'slug',
            'relatedModels' => ['users']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return $this->setRules([
            [['name',], 'required'],
            [['main_navigation', 'role_access', 'module_access'], 'safe'],
            [['name', 'slug'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['slug'], 'unique'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return $this->setAttributeLabels([
            'id' => 'ID',
            'name' => 'Name',
            'main_navigation' => 'Main Navigation',
            'role_access' => 'Role Access',
            'module_access' => 'Module Access',
            'slug' => 'Slug',
            'jsonMainNavigation' => 'Main Navigation',
            'jsonRoleAccess' => 'Role Access',
            'jsonModuleAccess' => 'Module Access',
        ]);
    }

    public function getIsDeveloper()
    {
        return $this->id == self::DEVELOPER;
    }

    public function getIsSuperadmin()
    {
        return $this->id == self::SUPERADMIN;
    }

    public function getIsAdmin()
    {
        return $this->id == self::ADMIN;
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\RoleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\RoleQuery(get_called_class());
    }

    public function getUsers()
    {
        return $this->hasMany(User::ClassName(), ['role_id' => 'id']);
    }
      
    public function getCanDelete()
    {
        $dontDelete = parent::getCanDelete();

        if (App::identity('role_id') == $this->id) {
            $dontDelete = false;
        }

        return $dontDelete;
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

    public function gridColumns()
    {
        return [
            'name' => [
                'attribute' => 'name', 
                'format' => 'raw',
                'value' => function($model) {
                    return Anchor::widget([
                        'title' => $model->name,
                        'link' => $model->viewUrl,
                        'text' => true
                    ]);
                }
            ],
            // 'main_navigation' => ['attribute' => 'main_navigation', 'format' => 'raw'],
            // 'role_access' => ['attribute' => 'role_access', 'format' => 'raw'],
            // 'module_access' => ['attribute' => 'module_access', 'format' => 'raw'],
            // 'slug' => ['attribute' => 'slug', 'format' => 'raw'],
        ];
    }

    public function detailColumns()
    {
        return [
            'name:raw',
            'main_navigation:jsonEditor',
            'role_access:jsonEditor',
            'module_access:jsonEditor',
        ];
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['JsonBehavior']['fields'] = [
            'role_access', 
            'main_navigation',
            'module_access',
        ];
        $behaviors['SluggableBehavior'] = [
            'class' => SluggableBehavior::className(),
            'attribute' => 'name',
            'slugAttribute' => 'slug',
            'immutable' => false,
            'ensureUnique' => true,
        ];

        return $behaviors;
    }
}