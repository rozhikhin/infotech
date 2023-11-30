<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%author_book}}`.
 */
class m231130_110424_create_author_book_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%author_book}}', [
            'id' => $this->primaryKey(),
            'author_id' => $this->integer(),
            'book_id' => $this->integer()
        ]);

        $this->createIndex(
            'idx-author_book-author_id',
            'author_book',
            'author_id'
        );

        $this->addForeignKey(
            'fk-author_book-author_id',
            'author_book',
            'author_id',
            'author',
            'id',
            'RESTRICT'
        );

        $this->createIndex(
            'idx-author_book-book_id',
            'author_book',
            'book_id'
        );

        $this->addForeignKey(
            'fk-author_book-book_id',
            'author_book',
            'book_id',
            'book',
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
            'fk-author_book-author_id',
            'author_book'
        );
        $this->dropForeignKey(
            'fk-author_book-book_id',
            'author_book'
        );

        $this->dropIndex(
            'idx-author_book-author_id',
            'author_book'
        );

        $this->dropIndex(
            'idx-author_book-book_id',
            'author_book'
        );

        $this->dropTable('{{%author_book}}');
    }
}
