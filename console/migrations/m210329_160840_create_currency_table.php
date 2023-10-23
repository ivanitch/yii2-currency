<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%currency}}`.
 */
class m210329_160840_create_currency_table extends Migration
{
    public function safeUp(): void
    {
        $this->createTable('{{%currency}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(3)->notNull(),
            'rate' => $this->decimal(11, 4)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropTable('{{%currency}}');
    }
}
