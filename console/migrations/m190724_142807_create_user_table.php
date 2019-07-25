<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m190724_142807_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%bitcoin_user}}', [
            'id' => $this->primaryKey(),
            'login' => $this->string(255),
            'apikey' => $this->string(255),
            'secretkey' => $this->string(255),
            'status' => $this->integer(1),
            'dt_add' => $this->integer(11),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
