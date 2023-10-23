<?php

use yii\db\Migration;

/**
 * Class m200201_150659_init
 */
class m200201_150659_init extends Migration
{
    public function up(): void
    {
        $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%user}}', [
          'id' => $this->primaryKey(),
          'username' => $this->string()->notNull()->unique(),
          'auth_key' => $this->string(32)->notNull(),
          'password_hash' => $this->string()->notNull(),
          'password_reset_token' => $this->string()->unique(),
          'email' => $this->string()->notNull()->unique(),
          'phone' => $this->string()->unique(),
          'email_confirm_token' => $this->string()->unique(),
          'status' => $this->smallInteger()->notNull()->defaultValue(10),
          'created_at' => $this->integer()->notNull(),
          'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        /**
         * user: admin
         * password: admin
         */
        $this->insert('{{%user}}', [
            'id' => 1,
            'username' => 'admin',
            'auth_key' => 'cVtYb9-hWnQ0LUaODi4kbdyYKNAae5UT',
            'password_hash' => '$2y$13$zXc2P13ZBkbIeJRIl3.vhu5BI5hh8jTd1XObbU2RQFYFwSB90xfzi',
            'password_reset_token' => null,
            'email' => 'admin@gmail.com',
            'phone' => '+7(999)999-99-99',
            'status' => 10,
            'created_at' => 1599301331,
            'updated_at' => 1599301331,

        ]);
    }

    public function down(): void
    {
        $this->dropTable('{{%user}}');
    }
}
