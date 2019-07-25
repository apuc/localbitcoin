<?php

use yii\db\Migration;

/**
 * Handles adding balance to table `{{%bitcoin_user}}`.
 */
class m190725_100902_add_balance_column_to_bitcoin_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('bitcoin_user', 'balance', $this->double()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('bitcoin_user', 'balance');
    }
}
