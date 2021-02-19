<?php

namespace app\models\query;

/**
 * This is the ActiveQuery class for [[\app\models\Setting]].
 *
 * @see \app\models\Setting
 */
class SettingQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere([
            'record_status' => 1
        ]);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\Setting[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\Setting|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
