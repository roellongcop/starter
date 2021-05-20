<?php

namespace app\models;

use Yii;
use app\helpers\App;
use app\helpers\Html;
use app\models\query\SettingQuery;
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

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%settings}}';
    }

    public function controllerID()
    {
        return 'setting';
    }

    public function mainAttribute()
    {
        return 'name';
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
        return [
            [['name', 'record_status', 'type'], 'required'],
            [['value'], 'safe'],
            [['record_status'], 'default', 'value' => 1],
            ['record_status', 'in', 'range' => [parent::RECORD_ACTIVE, parent::RECORD_INACTIVE]],
            [['record_status', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at', 'type', 'options', 'sort_order'], 'safe'],
            [['name', 'slug'], 'string', 'max' => 255],
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
            [
                'label' => 'Value',
                'format' => 'raw',
                'value' => 'formattedValue'
            ],
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
     * @return \app\models\query\SettingQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SettingQuery(get_called_class());
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
                        'link' => ['setting/view', 'id' => $model->id],
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
