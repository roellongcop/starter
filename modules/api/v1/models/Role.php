<?php

namespace app\modules\api\v1\models;

use Yii;

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
class Role extends \yii\db\ActiveRecord
{
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
            [['name', 'slug'], 'required'],
            [['main_navigation', 'role_access', 'module_access'], 'string'],
            [['record_status', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'slug'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['slug'], 'unique'],
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
        ];
    }

    /**
     * {@inheritdoc}
     * @return \app\modules\api\v1\models\query\RoleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\modules\api\v1\models\query\RoleQuery(get_called_class());
    }
}
