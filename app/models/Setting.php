<?php

namespace app\models;

use Yii;
use app\behaviors\LogBehavior;
use app\behaviors\JsonBehavior;
use app\helpers\App;
use app\models\search\SettingSearch;
use app\widgets\Anchor;
use app\widgets\BootstrapSelect;
use app\widgets\ThCheckbox;
use yii\behaviors\AttributeTypecastBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\helpers\Url;
/**
 * This is the model class for table "{{%settings}}".
 *
 * @property int $id
 * @property string $name
 * @property string|null $value
 * @property int $record_status
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class Setting extends ActiveRecord
{
    public $relatedModels = [];
    public $options;
    //public $excel_ignore_attr = [];
    //public $fileInput;
    public $imageInput;
    public $fileLocation; 
    public $withImageInput = [
        'primary_logo',
        'secondary_logo',
        'image_holder',
        'favicon'
    ];


    public function getMainAttribute()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%settings}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'record_status'], 'required'],
            [['value'], 'string'],
            [['record_status'], 'default', 'value' => 1],
            [['record_status', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at', 'type', 'options'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
            /*[
                ['fileInput'], 
                'file', 
                'skipOnEmpty' => true, 
                'extensions' => App::params('file_extensions')['file'], 
                'checkExtensionByMimeType' => false
            ],
            */
            [
                ['imageInput'], 
                'image', 
                // 'minWidth' => 100,
                // 'maxWidth' => 200,
                // 'minHeight' => 100,
                // 'maxHeight' => 200,
                'maxSize' => 1024 * 1024 * 2,
                'skipOnEmpty' => true, 
                'extensions' => App::params('file_extensions')['image'], 
                'checkExtensionByMimeType' => false
            ],
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
            'value' => 'Value',
            'record_status' => 'Record Status',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'recordStatusHtml' => 'Record Status',
            'recordStatusLabel' => 'Record Status',
        ];
    }

    public function getHasImageInput()
    {
        return in_array($this->name, $this->withImageInput);
    }
     
    public function getLabel()
    {
        return Inflector::camel2words($this->name);
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
                        'link' => ['setting/view', 'id' => $model->id],
                        'text' => true
                    ]);
                }
            ],
            'value' => ['attribute' => 'value', 'format' => 'raw'],
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
            'value:raw',
			'created_at:fulldate',
            'updated_at:fulldate',
            'createdByEmail',
            'updatedByEmail',
            'recordStatusHtml:raw',
            [
                'label' => 'Image',
                'value' => Html::img($this->imagePath . '&w=200'),
                'format' => 'raw'
            ]
        ];
    }
    
    public function getIsInput()
    {
        return $this->isType('input');
    }

    public function getIsTextarea()
    {
        return $this->isType('textarea');
    }

    public function getIsSelect()
    {
        return $this->isType('select');
    }

    public function getIsFile()
    {
        return $this->isType('file');
    }

    public function isType($type)
    {
        return $this->type == $type;
    }

    public function getFormInput($form)
    {
        switch ($this->name)  {
            case 'pagination':
                $input = BootstrapSelect::widget([
                    'label' => 'Number of Records',
                    'model' => $this,
                    'form' => $form,
                    'attribute' => 'value',
                    'data' => App::params('pagination'),
                    'searchable' => false,
                    'options' => ['class' => 'kt-selectpicker form-control']
                ]);
                break;
            case 'auto_logout_timer':
                $input = $form->field($this, 'value')->textInput([
                    'maxlength' => true,
                    'type' => 'number'
                ])->label('Number of seconds');
                break;
            
            default:
                $input = $form->field($this, 'value')->textarea([
                    'rows' => 6
                ]);
                break;
        }

        return $input;
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
