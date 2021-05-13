<?php

namespace app\models;

use Yii;
use app\helpers\App;
use app\models\query\BackupQuery;
use app\widgets\Anchor;
use app\widgets\JsonEditor;
use yii\behaviors\SluggableBehavior;

/**
 * This is the model class for table "{{%backup}}".
 *
 * @property int $id
 * @property string $filename
 * @property string|null $tables
 * @property string|null $description
 * @property int $record_status
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class Backup extends ActiveRecord
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
        return '{{%backups}}';
    }

    public function getMainAttribute()
    {
        return $this->filename;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['filename', 'record_status'], 'required'],
            [['description'], 'string'],
            [['record_status', 'created_by', 'updated_by'], 'integer'],
            [['record_status'], 'default', 'value' => 1],
            ['record_status', 'in', 'range' => [parent::RECORD_ACTIVE, parent::RECORD_INACTIVE]],
            [['created_at', 'updated_at', 'tables'], 'safe'],
            [['filename'], 'string', 'max' => 255],
            [['filename'], 'unique'],
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
            'filename' => 'Filename',
            'tables' => 'Tables',
            'description' => 'Description',
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
     * @return \app\models\query\BackupQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BackupQuery(get_called_class());
    }
    
  
    public function getCanUpdate()
    {
        return true;
    }

    

    public function download()
    {
        $file = $this->sqlFileLocation;
        if (file_exists($file)) {
            App::response()->sendFile($file);

            return true;
        }
        return false;
    }


    public function getTableColumns()
    {
        return [
            'serial' => [
                'class' => 'yii\grid\SerialColumn',
            ],
            'checkbox' => ['class' => 'app\widgets\CheckboxColumn'],
            'filename' => [
                'attribute' => 'filename', 
                'format' => 'raw',
                'value' => function($model) {
                    return Anchor::widget([
                        'title' => $model->filename,
                        'link' => ['backup/view', 'slug' => $model->slug],
                        'text' => true
                    ]);
                }
            ],
            // 'tables' => ['attribute' => 'tables', 'format' => 'raw'],
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


    public function getJsonTables()
    {
        return JsonEditor::widget([
            'data' => $this->tables,
        ]);
    }

    public function getDetailColumns()
    {
        return [
            'filename:raw',
            'tables:jsonEditor',
            'description:raw',
			'created_at:fulldate',
			'updated_at:fulldate',
            'createdByEmail',
            'updatedByEmail',
            'recordStatusHtml:raw'
        ];
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['JsonBehavior']['fields'] = [
            'tables'
        ];

        $behaviors['SluggableBehavior'] = [
            'class' => SluggableBehavior::className(),
            'attribute' => 'filename',
            'ensureUnique' => true,
        ];
        return $behaviors;
    }
}
