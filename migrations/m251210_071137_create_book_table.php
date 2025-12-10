<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%book}}`.
 */
class m251210_071137_create_book_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%book}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull()->comment('Название книги'),
            'year' => $this->integer()->notNull()->comment('Год издания'),
            'description' => $this->text()->comment('Краткое описание'),
            'isbn' => $this->string(20)->unique()->comment('ISBN'),
            'cover_image' => $this->string(255)->comment('Изображение обложки'),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex('idx-book-title', '{{%book}}', 'title');
        $this->createIndex('idx-book-year', '{{%book}}', 'year');
        $this->createIndex('idx-book-isbn', '{{%book}}', 'isbn');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%book}}');
    }
}
