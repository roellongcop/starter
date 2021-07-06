<?php

namespace app\models;

use Yii;
use app\helpers\App;
use app\helpers\Url;
use app\widgets\Anchor;
use app\widgets\JsonEditor;
use app\widgets\Label;
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
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%backups}}';
    }

    public function config()
    {
        return [
            'controllerID' => 'backup',
            'mainAttribute' => 'filename',
            'paramName' => 'slug',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return $this->setRules([
            [['filename'], 'required'],
            [['description'], 'string'],
            [['tables'], 'safe'],
            [['filename'], 'string', 'max' => 255],
            [['filename'], 'unique'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return $this->setAttributeLabels([
            'id' => 'ID',
            'filename' => 'Filename',
            'tables' => 'Tables',
            'description' => 'Description',
        ]);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\BackupQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\BackupQuery(get_called_class());
    }

    public function gridColumns()
    {
        return [
            'filename' => [
                'attribute' => 'filename', 
                'format' => 'raw',
                'value' => function($model) {
                    return Anchor::widget([
                        'title' => $model->filename,
                        'link' => $model->viewUrl,
                        'text' => true
                    ]);
                }
            ],
            'description' => [
                'attribute' => 'description', 
                'format' => 'raw'
            ],
            'status' => [
                'attribute' => 'id', 
                'format' => 'raw',
                'label' => 'Status',
                'value' => function($model) {
                    $options = $model->isGenerating ? 
                        ['class' => 'warning', 'label' => 'Generating']
                        : ['class' => 'success', 'label' => 'Generated'];

                    return Label::widget([
                        'options' => $options,
                    ]);
                }
            ],
        ];
    }

    public function detailColumns()
    {
        return [
            'filename:raw',
            'tables:jsonEditor',
            'description:raw',
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

    public function getCanUpdate()
    {
        return true;
    }

    public function getSqlFileLocation()
    {
        $sqlFileLocation = parent::getSqlFileLocation();

        $root = App::isWeb()? Yii::getAlias('@webroot'): Yii::getAlias('@consoleWebroot');

        return implode('/', [$root, $sqlFileLocation]);
    }

    public function download()
    {
        $file = $this->sqlFileLocation;
        if (file_exists($file) && $this->generated) {
            App::response()->sendFile($file);

            return true;
        }
        return false;
    }

    public function restore()
    {
        ini_set('max_execution_time', 0);
        
        $file = $this->sqlFileLocation;
        if (file_exists($file) && $this->generated) {
            $sql = file_get_contents($file);
            App::execute($sql);

            return true;
        }
        
        return false;
    }

    public function getGenerated()
    {
        return $this->modelSqlFile;
    }

    public function getIsGenerating()
    {
        return !$this->generated;
    }

    public function getDownloadUrl($fullpath=true)
    {
        if ($this->checkLinkAccess('download')) {
            $paramName = $this->paramName();
            $url = [
                implode('/', [$this->controllerID(), 'download']),
                $paramName => $this->{$paramName}
            ];
            return ($fullpath)? Url::to($url, true): $url;
        }
    }
}