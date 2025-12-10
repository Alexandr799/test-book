<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%subscription}}`.
 */
class m251210_071140_create_subscription_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%subscription}}', [
            'id' => $this->primaryKey(),
            'phone' => $this->string(20)->notNull()->comment('Телефон для SMS-уведомлений'),
            'is_active' => $this->boolean()->defaultValue(true)->comment('Активна ли подписка'),
            'created_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex('idx-subscription-phone', '{{%subscription}}', 'phone');
        $this->createIndex('idx-subscription-is_active', '{{%subscription}}', 'is_active');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%subscription}}');
    }
}
