<?php

/**
 * Handles the creation of table `{{%users}}`.
 */
class m200912_033904_create_users_table extends \app\migrations\Migration
{
    public function tableName()
    {
        return '{{%users}}';
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName(), $this->attributes([
            'role_id' => $this->bigInteger(20)->notNull()->defaultValue(0),
            'username' => $this->string(64)->notNull()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_hint' => $this->string(),
            'password_reset_token' => $this->string()->unique(),
            'verification_token' => $this->string()->unique(),
            'access_token' => $this->string()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'slug' => $this->string()->notNull()->unique(),
            'is_blocked' => $this->tinyInteger(2)->notNull()->defaultValue(0),
            'photo' => $this->text(),
        ]));

        $this->createIndexes($this->tableName(), [
            'role_id' => 'role_id',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName());
    }
}