<?php

namespace app\models;

use Yii;
use app\helpers\App;
use app\helpers\Html;
use app\widgets\Anchor;
use app\helpers\Url;

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
    const TYPE_BLACKLIST = 0;
    const TYPE_WHITELIST = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%ips}}';
    }

    public function config()
    {
        return [
            'controllerID' => 'ip',
            'mainAttribute' => 'name',
            'paramName' => 'slug',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return $this->setRules([
            [['name', 'type',], 'required'],
            [['description'], 'string'],
            [['type',], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['name'], 'ip'],
            [['type'], 'in', 'range' => [self::TYPE_BLACKLIST, self::TYPE_WHITELIST]],
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
            'description' => 'Description',
            'type' => 'Type',
        ]);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\IpQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\IpQuery(get_called_class());
    }
     
    public function getIpType()
    {
        return App::params('ip_types')[$this->type];
    }

    public function getIpTypeLabel()
    {
        return $this->ipType['label'];
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
        $bulkActions = parent::getBulkActions();
        $bulkActions['white_list'] = [
            'label' => 'White List',
            'process' => 'white_list',
            'icon' => 'plus',
            'function' => function($id) {
                self::whitelistAll(['id' => $id]);
            },
        ];
        $bulkActions['black_list'] = [
            'label' => 'Black List',
            'process' => 'black_list',
            'icon' => 'minus',
            'function' => function($id) {
                self::blacklistAll(['id' => $id]);
            },
        ];
        return $bulkActions;
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['SluggableBehavior'] = [
            'class' => 'yii\behaviors\SluggableBehavior',
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