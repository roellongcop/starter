<?php

namespace app\models;

use Yii;
use app\helpers\App;
use app\widgets\Anchor;

/**
 * This is the model class for table "tbl_visitors".
 *
 * @property int $id
 * @property int|null $expire
 * @property string $cookie
 * @property string $ip
 * @property string $browser
 * @property string $os
 * @property string $device
 * @property string|null $location
 * @property int $record_status
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class Visitor extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%visitors}}';
    }

    public function config()
    {
        return [
            'controllerID' => 'visitor',
            'mainAttribute' => 'cookie',
            'paramName' => 'cookie',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return $this->setRules([
            [['expire'], 'integer'],
            [['cookie', 'ip', 'browser', 'os', 'device', 'session_id'], 'required'],
            [['cookie'], 'string', 'max' => 255],
            [['ip'], 'string', 'max' => 32],
            [['session_id'], 'string', 'max' => 40],
            [['browser', 'os', 'device'], 'string', 'max' => 128],
            [['server', 'location'], 'safe'],
            [['cookie', 'session_id'], 'unique'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return $this->setAttributeLabels([
            'id' => 'ID',
            'expire' => 'Expire',
            'cookie' => 'Cookie',
            'ip' => 'Ip',
            'browser' => 'Browser',
            'os' => 'Os',
            'device' => 'Device',
            'location' => 'Location',
        ]);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\VisitorQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\VisitorQuery(get_called_class());
    }

    public function init()
    {
        parent::init();
        $this->record_status = parent::RECORD_ACTIVE;
    }
     
    public function gridColumns()
    {
        return [
            'country' => [
                'attribute' => 'location', 
                'format' => 'raw', 
                'value' => 'countryName',
                'label' => 'Country'
            ],
            'session_id' => ['attribute' => 'session_id', 'format' => 'raw'],
            'expire' => [
                'attribute' => 'expire', 
                'format' => 'raw',
                'value' => function($model) {
                    return Anchor::widget([
                        'title' => $model->expire,
                        'link' => $model->viewUrl,
                        'text' => true
                    ]);
                }
            ],
            'cookie' => ['attribute' => 'cookie', 'format' => 'raw'],
            'ip' => ['attribute' => 'ip', 'format' => 'raw'],
            'browser' => ['attribute' => 'browser', 'format' => 'raw'],
            'os' => ['attribute' => 'os', 'format' => 'raw'],
            'device' => ['attribute' => 'device', 'format' => 'raw'],
        ];
    }

    public function detailColumns()
    {
        return [
            'expire:raw',
            'session_id:raw',
            'cookie:raw',
            'ip:raw',
            'browser:raw',
            'os:raw',
            'device:raw',
            'location:jsonEditor',
            'server:jsonEditor',
        ];
    }

    public function createCookieValue()
    {
        $cookie = implode('-', [App::randomString(5), time()]);

        if (($model = Visitor::findOne(['cookie' => $cookie])) == null) {
            return $cookie;
        }

        return $this->createCookieValue();
    }

    public static function findByCookie($cookie='')
    {
       return self::findOne(['cookie' => $cookie]);
    }

    public function isExpire()
    {
        return time() >= $this->expire;
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        
        $behaviors['JsonBehavior'] = [
            'class' => 'app\behaviors\JsonBehavior',
            'fields' => ['location', 'server']
        ];
        return $behaviors;
    }

    public function getCountryName()
    {
        if ($this->location) {
            return $this->location['country'] ?? '';
        }
    }
}