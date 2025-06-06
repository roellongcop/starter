<?php

namespace app\models;

use app\helpers\App;
use app\helpers\Url;
use app\widgets\Anchor;
use app\widgets\Label;

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
            [['tables', 'sql'], 'safe'],
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
                'value' => function ($model) {
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
                'value' => function ($model) {
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
            'class' => 'yii\behaviors\SluggableBehavior',
            'attribute' => 'filename',
            'ensureUnique' => true,
        ];
        return $behaviors;
    }

    public function getCanUpdate()
    {
        return true;
    }

    public function getFile()
    {
        return $this->hasOne(File::class, ['token' => 'sql']);
    }

    public function getSqlFileLocation()
    {
        return App::if ($this->file, fn($file) => $file->rootPath);
    }

    public function download()
    {
        return App::if ($this->file, fn($file) => $file->download());
    }

    public function restore()
    {
        // ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');
        $file = $this->file;

        if ($file && $file->exists && $this->generated) {
            $sql = file_get_contents($file->rawUrlRootPath);
            App::execute($sql);

            return true;
        }

        return false;
    }

    public function getGenerated()
    {
        return App::if ($this->file, fn($file) => $file);
    }

    public function getIsGenerating()
    {
        return !$this->generated;
    }

    public function getDownloadUrl($fullpath = true)
    {
        if ($this->checkLinkAccess('download')) {
            $paramName = $this->paramName();
            $url = [
                implode('/', [$this->controllerID(), 'download']),
                $paramName => $this->{$paramName}
            ];
            return ($fullpath) ? Url::toRoute($url, true) : $url;
        }
    }
}