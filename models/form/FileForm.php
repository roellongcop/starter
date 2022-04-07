<?php

namespace app\models\form;

use Yii;
use app\models\File;

class FileForm extends \yii\base\Model
{
    public $token;
    public $name;

    public $_file;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['token', 'name'], 'required'],
            ['token', 'exist', 'targetClass' => 'app\models\File', 'targetAttribute' => 'token'],
            [['token', 'name'], 'string'],
        ];
    }

    public function getFile()
    {
        if ($this->_file == null) {
            $this->_file = File::findByToken($this->token);
        }

        return $this->_file;
    }

    public function rename()
    {
        if ($this->validate()) {
            $file = $this->getFile();
            $file->name = $this->name;

            if ($file->save()) {
                return $file;
            }
            else {
                $this->addError('file', $file->errors);
            }
        }

        return false;
    }
}