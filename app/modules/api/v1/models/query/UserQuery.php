<?php

namespace app\modules\api\v1\models\query;

/**
 * This is the ActiveQuery class for [[Backups]].
 *
 * @see Backups
 */
class UserQuery extends \yii\db\ActiveQuery
{
    public function available()
    {
        return $this->andWhere([
            'record_status' => 1,
            'status' => 10,
            'is_blocked' => 0
        ]);
    }

    /**
     * {@inheritdoc}
     * @return Backups[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Backups|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
