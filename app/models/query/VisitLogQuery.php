<?php

namespace app\models\query;

/**
 * This is the ActiveQuery class for [[\app\models\VisitLog]].
 *
 * @see \app\models\VisitLog
 */
class VisitLogQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere([
            'record_status' => 1
        ]);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\VisitLog[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\VisitLog|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
