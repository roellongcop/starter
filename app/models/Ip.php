<?php

namespace app\models;

use Yii;
use app\behaviors\LogBehavior;
use app\behaviors\JsonBehavior;
use app\helpers\App;
use app\models\search\SettingSearch;
use app\widgets\Anchor;
use yii\behaviors\AttributeTypecastBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\query\IpQuery;

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

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'type', 'record_status'], 'required'],
            [['record_status'], 'default', 'value' => 1],
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
                        'link' => ['ip/view', 'id' => $model->id],
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
            'description:raw',
            'ipTypeLabel:raw',
			'created_at:fulldate',
            'updated_at:fulldate',
            'createdByEmail',
            'updatedByEmail',
            'recordStatusHtml:raw'
        ];
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
            ],
            [
                'label' => 'White List',
                'process' => 'white_list',
                'icon' => 'plus',
            ],
            [
                'label' => 'Black List',
                'process' => 'black_list',
                'icon' => 'minus',
            ],
        ];
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
                'defaultValue' => 0
            ],
            ['class' => AttributeTypecastBehavior::className()],
            ['class' => JsonBehavior::className()], 
            ['class' => LogBehavior::className()], 
        ];
    }

}
