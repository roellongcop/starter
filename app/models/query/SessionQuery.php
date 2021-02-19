<?php

namespace app\models\query;

/**
 * This is the ActiveQuery class for [[\app\models\Session]].
 *
 * @see \app\models\Session
 */
class SessionQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere([
            'record_status' => 1
        ]);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\Session[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\Session|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
