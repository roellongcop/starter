<?php
namespace app\models;

use Yii;
use app\helpers\App;
use app\models\form\ProfileForm;
use app\widgets\Anchor;
use app\widgets\Label;
use yii\behaviors\SluggableBehavior;
use app\helpers\Html;
use yii\helpers\Url;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $verification_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;
    const SCENARIO_ADMIN_CREATE = 'admin_create';

    public $_tableColumnsMeta = false;
    public $_currentTheme;

    public $password;
    public $password_repeat;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%users}}';
    }

    public function config()
    {
        return [
            'controllerID' => 'user',
            'mainAttribute' => 'username',
            'paramName' => 'slug',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [

            [['password', 'password_repeat'], 'required', 'on' => self::SCENARIO_ADMIN_CREATE],
            ['password', 'string', 'min' => 6],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message'=>"Passwords don't match" ],

            [['username', 'role_id', 'status', 'record_status', 'is_blocked'], 'required'],
            [['record_status'], 'default', 'value' => 1],
            ['record_status', 'in', 'range' => [parent::RECORD_ACTIVE, parent::RECORD_INACTIVE]],
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            [
                'status', 
                'in', 
                'range' => [
                    self::STATUS_ACTIVE, 
                    self::STATUS_INACTIVE, 
                    self::STATUS_DELETED
                ]
            ],
            ['email', 'email'],
            ['email', 'trim'],
            ['email', 'unique'],
            ['username', 'unique'],
            [['slug', 'role_id'], 'safe'],
            [['created_at', 'updated_at', 'password_hint', 'password_reset_token', 'password_hash'], 'safe'],
            ['role_id', 'exist', 'targetRelation' => 'role'],
            ['role_id', 'validateRoleId'],
        ];
    }
 
    public function attributeLabels()
    {
        return [
            'role_id' => 'Role',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\UserQuery(get_called_class());
    }

    public function validateRoleId($attribute, $params)
    {
        if (App::isGuest() && $this->role->isInactive) {
            $this->addError($attribute, 'Cannot access inactive role');
        }

        if (App::isLogin() && $this->role->isInactive) {
            if (! App::identity()->can('in-active-data', 'role')) {
                $this->addError($attribute, 'User don\'t have access to role');
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::find()
            ->alias('u')
            ->joinWith('role r')
            ->where([
                'u.access_token' => $token,
                'u.status' => self::STATUS_ACTIVE,
                'u.record_status' => 1,
                'r.record_status' => 1,
            ])
            ->one();
        // throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
        // return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
        // return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }
    
    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token) {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Generates new access token
     */
    public function generateAccessToken()
    {
        $this->access_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Generates new token for email verification
     */
    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function getUserStatus()
    {
        return App::params('user_status')[$this->status] ?? [];
    }

    public function getUserStatusLabel()
    {
        return $this->userStatus['label'] ?? '';
    }

    public function getBlockedStatus()
    {
        return App::params('is_blocked')[$this->is_blocked] ?? [];
    }

    public function getBlockedStatusLabel()
    {
        return $this->blockedStatus['label'] ?? '';
    }

    public function getBlockedStatusHtml()
    {
        if (in_array(App::actionID(), App::params('export_actions'))) {
            return $this->blockedStatus['label'];
        } 
        
        return Label::widget([
            'options' => $this->blockedStatus
        ]);
    }

    public function getUserStatusHtml()
    { 
        return Label::widget([
            'options' => $this->userStatus
        ]);
    }
   
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        
        if ($this->isNewRecord) {
            $this->generateAuthKey();
            $this->generatePasswordResetToken();
            $this->generateEmailVerificationToken();
            $this->generateAccessToken();
        }

        return true;
    }

    public function getThemeMeta()
    {
        return $this->hasOne(UserMeta::className(), ['user_id' => 'id'])
            ->onCondition(['meta_key' => 'theme'])
            ->orderBy(['id' => SORT_DESC]);
    }

    public function getTheme()
    {
        return $this->hasOne(Theme::className(), ['id' => 'meta_value'])
            ->via('themeMeta');
    }

    public function getCurrentTheme()
    {
        if ($this->_currentTheme) {
            return $this->_currentTheme;
        }
        if (($theme = $this->theme) != null) {
            $this->_currentTheme = $theme;
            return $this->_currentTheme;
        }

        $this->_currentTheme = Theme::findOne(App::setting('theme'));

        return $this->_currentTheme;
    }

    public function getRole()
    {
        return $this->hasOne(Role::className(), ['id' => 'role_id']);
    } 

    public function getTableColumnsMeta($model)
    {
        $user_meta = ($this->_tableColumnsMeta !== false) ? $this->_tableColumnsMeta: UserMeta::findOne([
            'user_id' => $this->id,
            'meta_key' => 'table_columns'
        ]);

        $this->_tableColumnsMeta = $user_meta;

        $table_name = App::tableName($model, false);

        if ($user_meta) {
            $table_columns = json_decode($user_meta->meta_value, true);

            if (in_array($table_name, array_keys($table_columns))) {
                return $table_columns[$table_name];
            }
        }
    }

    public function filterColumns($model, $default=true)
    {
        $table_columns = $this->getTableColumnsMeta($model);

        if ($default) {
            return $table_columns ?: array_keys($model->tableColumns);
        }
        return $table_columns ?: [];
    }


    public function getMain_navigation()
    {
        if (($model = $this->role) != null) {
            return $model->main_navigation;
        }
    }

    public function getModule_access()
    {
        if (($model = $this->role) != null) {
            return $model->module_access;
        }
    }

    public function getRole_access()
    {
        if (($model = $this->role) != null) {
            return $model->role_access;
        }
    }

    public function getRoleName()
    {
        if (($model = $this->role) != null) {
            return $model->name;
        }
    }

    public function getModuleAccess()
    {
        if (($model = $this->role) != null) {
            return $model->module_access;
        }
    }

    public function getMainNavigation()
    {
        if (($model = $this->role) != null) {
            return $model->main_navigation;
        }
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
  
        $behaviors['SluggableBehavior'] = [
            'class' => SluggableBehavior::className(),
            'attribute' => 'username',
            'slugAttribute' => 'slug',
            'immutable' => false,
            'ensureUnique' => true,
        ];

        return $behaviors;
    }

    public function gridColumns()
    {
        return [
            'photo' => [
                'attribute' => 'id', 
                'label' => 'Photo',
                'format' => 'raw',
                'value' => function($model) {
                    return Html::image($model->imagePath, 
                        [
                            'w' => 50,
                            'h' => 50,
                            'quality' => 90,
                            'ratio' => 'false',
                        ], 
                        [
                            'loading' => 'lazy',
                            'style' => 'border-radius: 50%;max-width:40px'
                        ]
                    );
                }
            ],
            'username' => [
                'attribute' => 'username', 
                'format' => 'raw',
                'value' => function($model) {
                    return Anchor::widget([
                        'title' => $model->username,
                        'link' => $model->viewUrl,
                        'text' => true
                    ]);
                }
            ],
            'email' => ['attribute' => 'email', 'format' => 'raw'],
            'role' => [
                'attribute' => 'roleName', 
                'format' => 'raw',
                'label' => 'Role',
                'value' => function($model) {
                    return Anchor::widget([
                        'title' => $model->roleName,
                        'link' => $model->role->viewUrl,
                        'text' => true
                    ]);
                }
            ],
            // 'auth_key' => ['attribute' => 'auth_key', 'format' => 'raw'],
            // 'password_hash' => ['attribute' => 'password_hash', 'format' => 'raw'],
            // 'password_reset_token' => ['attribute' => 'password_reset_token', 'format' => 'raw'],
            // 'verification_token' => ['attribute' => 'verification_token', 'format' => 'raw'],
            // 'slug' => ['attribute' => 'slug', 'format' => 'raw'],
            'is_blocked' => [
                'attribute' => 'is_blocked',
                'label' => 'is blocked',
                'format' => 'raw', 
                'value' => function($model) {
                    return $model->blockedStatusHtml;
                }
            ],
        ];
    }

    public function detailColumns()
    {
        return [
            [
                'label' => 'Photo',
                'format' => 'raw',
                'value' => function($model) {
                    if ($model->imagePath) {
                        return Html::image(
                            $model->imagePath,
                            ['w'=>40, 'h'=>40, 'ratio'=>'false', 'quality'=>90],
                            ['style' => 'border-radius: 50%;']
                        );
                    }
                }
            ],

            'roleName:raw',
            'username:raw',
            'email:raw',
            'auth_key:raw',
            'password_hash:raw',
            'password_hint:raw',
            'password_reset_token:raw',
            'verification_token:raw',
            // 'slug:raw',
            'userStatusHtml:raw',
            'blockedStatusHtml:raw',
        ];
    }

    public function getBulkActions()
    {
        $getBulkActions = parent::getBulkActions();
        $getBulkActions['allowed'] = [
            'label' => 'Allowed',
            'process' => 'allowed',
            'icon' => 'check',
        ];
        $getBulkActions['blocked'] = [
            'label' => 'Blocked',
            'process' => 'blocked',
            'icon' => 'close',
        ];
        return $getBulkActions;
    }

    public function can($action, $controller='')
    {
        return App::component('access')
            ->userCan($action, $controller);
    }

    public function getMyImageFiles()
    {
        return $this->hasMany(File::className(), ['created_by' => 'id'])
            ->onCondition(['extension' => App::params('file_extensions')['image']])
            ->groupBy(['name', 'size', 'extension'])
            ->orderBy(['id' => SORT_DESC]);
    }

    public function getProfile()
    {
        return new ProfileForm(['user_id' => $this->id]);
    }
    
    public function metas($meta_key='')
    {
        $meta_key = is_array($meta_key)? $meta_key: [$meta_key];

        $meta = UserMeta::dropdown('meta_key', 'meta_value', [
            'user_id' => $this->id,
            'meta_key' => $meta_key
        ]);

        return $meta;
    }

    public function meta($meta_key='')
    {
        $meta = $this->metas($meta_key);

        return $meta[$meta_key] ?? '';
    }

    public function saveMeta($data)
    {
        $success = [];
        $failed = [];

        foreach ($data as $meta_key => $meta_value) {
            $condition = [
                'user_id' => $this->id,
                'meta_key' => $meta_key,
            ];
            $meta = UserMeta::findOne($condition);

            $meta = $meta ?: new UserMeta($condition);
            $meta->meta_value = is_array($meta_value)? json_encode($meta_value): $meta_value;
            if ($meta->save()) {
                $success[] = $meta->attributes;
            }
            else {
                $failed[] = $meta->errors;
            }
        }

        return [
            'success' => $success,
            'failed' => $failed,
        ];
    }

    public function getIsDeleted()
    {
        return $this->status == self::STATUS_DELETED;
    }

    public function getIsNotVerified()
    {
        return $this->status == self::STATUS_INACTIVE;
    }

    public function getIsVerified()
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    public function getIsBlocked()
    {
        return $this->is_blocked == 1;
    }

    public static function allowedAll($condition='')
    {
        return parent::updateAll(['is_blocked' => 0], $condition);
    }

    public static function blockedAll($condition='')
    {
        return parent::updateAll(['is_blocked' => 1], $condition);
    }
}