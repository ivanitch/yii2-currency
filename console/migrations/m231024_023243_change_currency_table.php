<?php

use yii\db\Migration;

/**
 * Class m231024_023243_change_currency_table
 */
class m231024_023243_change_currency_table extends Migration
{
    private string $table = '{{%currency}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->dropTable($this->table);

        $this->createTable($this->table, [
            'num_code' => $this->smallInteger(3)->notNull()->unique(),
            'char_code' => $this->string(3)->notNull()->unique(),
            'nominal' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'value' => $this->decimal(11, 4)->notNull(),
            'rate' => $this->decimal(11, 4)->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropTable($this->table);

        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'name' => $this->string(3)->notNull(),
            'rate' => $this->decimal(11, 4)->notNull(),
        ]);
    }
}
