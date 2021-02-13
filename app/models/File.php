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

/**
 * This is the model class for table "{{%files}}".
 *
 * @property int $id
 * @property string $name
 * @property string $extension
 * @property int $size
 * @property string|null $location
 * @property string $token
 * @property int $record_status
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class File extends ActiveRecord
{
    public $relatedModels = [];
    //public $excel_ignore_attr = [];
    //public $fileInput;
    // public $imageInput;
    //public $fileLocation; 

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%files}}';
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['size', 'record_status', 'created_by', 'updated_by'], 'integer'],
            [['record_status'], 'default', 'value' => 1],
            [['name', 'extension', 'size', 'record_status'], 'required'],
            [['token'], 'unique'],
            [['location'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'token'], 'string', 'max' => 255],
            [['extension'], 'string', 'max' => 16],
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
            'model_id' => 'Model ID',
            'model' => 'Model',
            'name' => 'Name',
            'extension' => 'Extension',
            'size' => 'Size',
            'location' => 'Location',
            'token' => 'Token',
            'record_status' => 'Record Status',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'recordStatusHtml' => 'Record Status',
            'recordStatusLabel' => 'Record Status',
        ];
    }
     
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->token = $this->token ?: $this->generateToken();
            }
            return true;
        }
    }


    public function getPreviewIcon($w=60)
    {
        $path = App::publishedUrl() . '/media/svg/files/';
        switch ($this->extension) {
            case 'css':
                $path .= 'css.svg';
                break;
            case 'zip':
            case 'sql':
                $path .= 'zip.svg';
                break;

            case 'csv':
                $path .= 'csv.svg';
                break;

            case 'docx':
            case 'doc':
            case 'txt':
                $path .= 'doc.svg';
                break;

            case 'html':
                $path .= 'html.svg';
                break;

            case 'javacript':
                $path .= 'javacript.svg';
                break;

            case 'mp4':
                $path .= 'mp4.svg';
                break;

            case 'pdf':
                $path .= 'pdf.svg';
                break;

            case 'xml':
                $path .= 'xml.svg';
                break;
            
            default:
                $path = $this->imagePath;
                break;
        }


        if (in_array($this->extension, App::params('file_extensions')['image'])) {
            return Html::img($path. "&w={$w}", [
                'class' => 'img-thumbnail'
            ]) ;
        }

        return Html::img($path, [
            'style' => "width:{$w}px;height:auto",
            'class' => 'img-thumbnail'
        ]) ;
    }

    public function getImageFiles()
    {
        return Files::find()
            ->where(['extension' => App::params('file_extensions')['image']])
            ->all();
    }

    public function getImagePath()
    {
        if($this->token) {
            return Url::to(['file/display', 'token' => $this->token], true);
        }
        return SettingSearch::defaultImage('image_holder');
    }

    public function tableColumns()
    {
        return [
            'serial' => [
                'class' => 'yii\grid\SerialColumn',
            ],
            'checkbox' => ['class' => 'app\widgets\CheckboxColumn'],
            'icon' => [
                'attribute' => 'name', 
                'label' => 'Preview', 
                'format' => 'raw',
                'value' => 'previewIcon',
            ],

            'name' => [
                'attribute' => 'name', 
                'format' => 'raw',
                'value' => function($model) {
                    return Anchor::widget([
                        'title' => $model->name,
                        'link' => ['file/view', 'id' => $model->id],
                        'text' => true
                    ]);
                }
            ],
            
            'extension' => ['attribute' => 'extension', 'format' => 'raw'],
            'size' => ['attribute' => 'size', 'format' => 'raw'],
            'location' => ['attribute' => 'location', 'format' => 'raw'],
            // 'token' => ['attribute' => 'token', 'format' => 'raw'],
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
            'extension:raw',
            'size:raw',
            'location:raw',
            'token:raw',
			'created_at:fulldate',
            'updated_at:fulldate',
            'createdByEmail',
            'updatedByEmail',
            'recordStatusHtml:raw'
        ];
    }


    public function generateToken() 
    {
        $token = Yii::$app->security->generateRandomString(32) . time();

        if (($model = File::findOne(['token' => $token])) != null) {
            return $this->generateToken();
        }

        return $token;
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
