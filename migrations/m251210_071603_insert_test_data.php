<?php

use yii\db\Migration;

class m251210_071603_insert_test_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $time = time();

        // Создаём тестового пользователя admin/admin123
        $this->insert('{{%user}}', [
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password_hash' => Yii::$app->security->generatePasswordHash('admin123'),
            'auth_key' => Yii::$app->security->generateRandomString(),
            'status' => 10,
            'created_at' => $time,
            'updated_at' => $time,
        ]);

        // Создаём авторов
        $authors = [
            'Александр Пушкин',
            'Лев Толстой',
            'Фёдор Достоевский',
            'Антон Чехов',
            'Михаил Булгаков',
            'Иван Тургенев',
            'Николай Гоголь',
            'Максим Горький',
            'Иван Бунин',
            'Владимир Набоков',
        ];

        foreach ($authors as $authorName) {
            $this->insert('{{%author}}', [
                'full_name' => $authorName,
                'created_at' => $time,
                'updated_at' => $time,
            ]);
        }

        // Создаём книги
        $books = [
            ['Евгений Онегин', 1833, 'Роман в стихах', '978-5-17-114589-0', 1],
            ['Капитанская дочка', 1836, 'Исторический роман', '978-5-17-114590-6', 1],
            ['Война и мир', 2025, 'Роман-эпопея', '978-5-17-114591-3', 2],
            ['Анна Каренина', 2024, 'Роман', '978-5-17-114592-0', 2],
            ['Преступление и наказание', 2025, 'Социально-психологический роман', '978-5-17-114593-7', 3],
            ['Братья Карамазовы', 2024, 'Философский роман', '978-5-17-114594-4', 3],
            ['Вишнёвый сад', 2025, 'Пьеса', '978-5-17-114595-1', 4],
            ['Мастер и Маргарита', 2024, 'Роман', '978-5-17-114596-8', 5],
            ['Отцы и дети', 2025, 'Роман', '978-5-17-114597-5', 6],
            ['Мёртвые души', 2023, 'Поэма', '978-5-17-114598-2', 7],
        ];

        foreach ($books as $book) {
            $this->insert('{{%book}}', [
                'title' => $book[0],
                'year' => $book[1],
                'description' => $book[2],
                'isbn' => $book[3],
                'created_at' => $time,
                'updated_at' => $time,
            ]);

            $bookId = $this->db->getLastInsertID();
            $this->insert('{{%book_author}}', [
                'book_id' => $bookId,
                'author_id' => $book[4],
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m251210_071603_insert_test_data cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m251210_071603_insert_test_data cannot be reverted.\n";

        return false;
    }
    */
}
