<?php

namespace app\models;

use Yii;
use app\helpers\App;
use app\helpers\Html;
use app\models\query\IpQuery;
use app\widgets\Anchor;
use yii\behaviors\SluggableBehavior;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%ips}}".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $type
 * @property int $record_status
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class Ip extends ActiveRecord
{
    public $relatedModels = [];
    //public $excel_ignore_attr = [];
    //public $fileInput;
    //public $imageInput;
    //public $fileLocation; 

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%ips}}';
    }

    public function controllerID()
    {
        return 'ip';
    }

    public function mainAttribute()
    {
        return 'name';
    }
    public function paramName()
    {
        return 'slug';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'type', 'record_status'], 'required'],
            [['record_status'], 'default', 'value' => 1],
            ['record_status', 'in', 'range' => [parent::RECORD_ACTIVE, parent::RECORD_INACTIVE]],
            [['description'], 'string'],
            [['type', 'record_status', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['name'], 'ip'],
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
            ],
            */
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
            'description' => 'Description',
            'type' => 'Type',
            'record_status' => 'Record Status',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'recordStatusHtml' => 'Record Status',
            'recordStatusLabel' => 'Record Status',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\IpQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new IpQuery(get_called_class());
    }
     
 

    public function getIpType()
    {
        return App::params('ip_type')[$this->type] ?? [];
    }

    public function getIpTypeLabel()
    {
        return $this->ipType['label'] ?? '';
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
            'ip_type' => [
                'attribute' => 'type', 
                'format' => 'raw',
                'value' => function($model) {
                    return $model->ipTypeLabel;
                },
            ],

            'description' => ['attribute' => 'description', 'format' => 'raw'],
        ];
    }

    public function detailColumns()
    {
        return [
            'name:raw',
            'description:raw',
            'ipTypeLabel:raw',
        ];
    }
 

    public function getBulkActions()
    {
        $getBulkActions = parent::getBulkActions();
        $getBulkActions['white_list'] = [
            'label' => 'White List',
            'process' => 'white_list',
            'icon' => 'plus',
        ];
        $getBulkActions['black_list'] = [
            'label' => 'Black List',
            'process' => 'black_list',
            'icon' => 'minus',
        ];
        return $getBulkActions;
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['SluggableBehavior'] = [
            'class' => SluggableBehavior::className(),
            'attribute' => 'name',
            'ensureUnique' => true,
        ];

        return $behaviors;
    }

    public static function whitelistAll($condition='')
    {
        return parent::updateAll(['type' => 1], $condition);
    }

    public static function blacklistAll($condition='')
    {
        return parent::updateAll(['type' => 0], $condition);
    }
}
