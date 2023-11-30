<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%subscriber}}`.
 */
class m231130_111651_create_subscriber_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%subscriber}}', [
            'id' => $this->primaryKey(),
            'book_id' => $this->integer(),
            'user_id' => $this->integer()
        ]);

        $this->createIndex(
            'idx-subscriber-book_id',
            'subscriber',
            'book_id'
        );

        $this->addForeignKey(
            'fk-subscriber-book_id',
            'subscriber',
            'book_id',
            'book',
            'id',
            'RESTRICT'
        );

        $this->createIndex(
            'idx-subscriber-user_id',
            'subscriber',
            'user_id'
        );

        $this->addForeignKey(
            'fk-subscriber-user_id',
            'subscriber',
            'user_id',
            'user',
            'id',
            'RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-subscriber-book_id',
            'subscriber'
        );
        $this->dropForeignKey(
            'fk-subscriber-user_id',
            'subscriber'
        );

        $this->dropIndex(
            'idx-subscriber-book_id',
            'subscriber'
        );

        $this->dropIndex(
            'idx-subscriber-user_id',
            'subscriber'
        );

        $this->dropTable('{{%subscriber}}');
    }
}
