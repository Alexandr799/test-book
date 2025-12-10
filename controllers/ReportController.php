<?php

namespace app\controllers;

use Yii;
use app\models\Author;
use yii\web\Controller;
use yii\db\Expression;

/**
 * ReportController handles report pages.
 */
class ReportController extends Controller
{
    /**
     * Displays report of top 10 authors by book count for specified year.
     * @return mixed
     */
    public function actionTopAuthors()
    {
        $year = Yii::$app->request->get('year', date('Y'));

        // Получаем топ-10 авторов, выпустивших наибольшее количество книг за указанный год
        $authors = Author::find()
            ->select([
                'author.id',
                'author.full_name',
                'COUNT(book.id) as book_count'
            ])
            ->innerJoinWith('books')
            ->where(['book.year' => $year])
            ->groupBy(['author.id', 'author.full_name'])
            ->orderBy(['book_count' => SORT_DESC])
            ->limit(10)
            ->asArray()
            ->all();

        return $this->render('top-authors', [
            'authors' => $authors,
            'year' => $year,
        ]);
    }
}

