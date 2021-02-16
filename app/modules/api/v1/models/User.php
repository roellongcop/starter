<?php

namespace app\modules\api\v1\models;

use Yii;

/**
 * This is the model class for table "{{%users}}".
 *
 * @property int $id
 * @property int $role_id
 * @property string $username
 * @property string $email
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_hint
 * @property string|null $password_reset_token
 * @property string|null $verification_token
 * @property int $status
 * @property string $slug
 * @property int $is_blocked
 * @property int $record_status
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%users}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['role_id', 'status', 'is_blocked', 'record_status', 'created_by', 'updated_by'], 'integer'],
            [['username', 'email', 'auth_key', 'password_hash', 'password_hint', 'slug'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['username'], 'string', 'max' => 64],
            [['email', 'password_hash', 'password_hint', 'password_reset_token', 'verification_token', 'slug'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['slug'], 'unique'],
            [['password_reset_token'], 'unique'],
            [['verification_token'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role_id' => 'Role ID',
            'username' => 'Username',
            'email' => 'Email',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_hint' => 'Password Hint',
            'password_reset_token' => 'Password Reset Token',
            'verification_token' => 'Verification Token',
            'status' => 'Status',
            'slug' => 'Slug',
            'is_blocked' => 'Is Blocked',
            'record_status' => 'Record Status',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function fields()
    {
        return [
            // field name is the same as the attribute name
            // 'id',
            // field name is "email", the corresponding attribute name is "email_address"
            'email' => 'email',
            // field name is "name", its value is defined by a PHP callback
            'passsword' => function ($model) {
                return $model->email;
            },
        ];
    }

    
}
