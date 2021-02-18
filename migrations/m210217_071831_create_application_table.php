<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%application}}`.
 */
class m210217_071831_create_application_table extends Migration
{
    private $tableName = '{{%application}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id'      => $this->primaryKey(),
            'name'    => $this->string(),
            'surname' => $this->string(),
            'address' => $this->string(),
            'country' => $this->string(),
            'email'   => $this->string(),
            'phone'   => $this->string(13),
            'age'     => $this->integer(),
            'hired'   => $this->boolean()->defaultValue(false),
            'status'  => $this->tinyInteger()->defaultValue(1),
            'date'       => $this->dateTime(),
            'note'       => $this->text(),
            'admin_id'   => $this->integer(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime()
        ]);

        $this->addForeignKey(
            'fk-user-application-admin_id',
            $this->tableName,
            'admin_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-user-application-admin_id', $this->tableName);
        $this->dropTable($this->tableName);
    }
}
