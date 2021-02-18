<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m210216_124526_create_user_table extends Migration
{
    private $tableName = '{{%user}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id'            => $this->primaryKey(),
            'username'      => $this->string(),
            'password_hash' => $this->string(),
            'auth_token'    => $this->string(),
            'auth_key'      => $this->string(),
            'status'        => $this->smallInteger()->defaultValue(1),
            'created_at'    => $this->dateTime(),
            'updated_at'    => $this->dateTime(),
        ]);
        $this->createIndex(
            'idx-user-id',
            'user',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx-user-id', $this->tableName);
        $this->dropTable($this->tableName);
    }
}
