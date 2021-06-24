<?php

namespace app\models;

use Yii;
use app\helpers\App;
use app\helpers\Html;
use app\widgets\Anchor;
use app\widgets\BootstrapSelect;
use yii\behaviors\SluggableBehavior;
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
    const TYPE_GENERAL = 'general';
    
    public $options;
    public $imageInput;
    public $fileLocation; 
    public $withImageInput = [
        'primary_logo',
        'secondary_logo',
        'image_holder',
        'favicon'
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%settings}}';
    }

    public function config()
    {
        return [
            'controllerID' => 'setting',
            'mainAttribute' => 'name',
            'paramName' => 'name',
        ];
    }


    public function getArrayAttributes()
    {
        return [

        ];
    }

    public function getFormattedValue()
    {
        if (in_array($this->name, $this->arrayAttributes)) {
            return App::formatter('asJsonEditor', $this->value);
        }

        return $this->value;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return $this->setRules([
            [['name', 'type'], 'required'],
            [['value'], 'safe'],
            [['type', 'options', 'sort_order'], 'safe'],
            [['name', 'slug'], 'string', 'max' => 255],
            [['type'], 'in', 'range' => [self::TYPE_GENERAL]],
            [
                ['imageInput'], 
                'image', 
                'maxSize' => 1024 * 1024 * 2,
                'skipOnEmpty' => true, 
                'extensions' => App::params('file_extensions')['image'], 
                'checkExtensionByMimeType' => false
            ],
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
            [
                'label' => 'Value',
                'format' => 'raw',
                'value' => 'formattedValue'
            ],
        ]);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\SettingQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\SettingQuery(get_called_class());
    }

    public function getHasImageInput()
    {
        return in_array($this->name, $this->withImageInput);
    }
     
    public function getLabel()
    {
        return Inflector::camel2words($this->name);
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
            'value' => ['attribute' => 'value', 'format' => 'raw'],
        ];
    }

    public function detailColumns()
    {
        $columns = [
            'name:raw',
            'value:raw',
        ];

        if (in_array($this->name, $this->withImageInput)) {
            $columns[] = [
                'label' => 'Image',
                'value' => Html::img($this->imagePath . '&w=200'),
                'format' => 'raw'
            ];
        }

        return $columns;
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
        $behaviors = parent::behaviors();
        
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