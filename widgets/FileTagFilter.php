<?php

namespace app\widgets;

use Yii;
use app\models\File;
 
class FileTagFilter extends BaseWidget
{
    public $activeTag;
    public $type = 'all';

    public $tags;

    public function init() 
    {
        // your logic here
        parent::init();

        $this->activeTag = $this->activeTag ?: 'Filter Tag';

        $this->tags =  File::filter('tag', [
            'extension' => ($this->type == 'all' ? '': File::EXTENSIONS['image'])
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        if (!$this->tags) {
            return;
        }

        return $this->render('file-tag-filter', [
            'activeTag' => $this->activeTag,
            'type' => $this->type,
            'tags' => $this->tags,
            'action' => ($this->type == 'all')? 'my-files': 'my-image-files',
        ]);
    }
}
