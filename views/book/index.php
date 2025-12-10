<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Книги';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-index">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="bi bi-book"></i> <?= Html::encode($this->title) ?></h1>
        <?php if (!Yii::$app->user->isGuest): ?>
            <?= Html::a('<i class="bi bi-plus-circle"></i> Создать книгу', ['create'], ['class' => 'btn btn-success']) ?>
        <?php endif; ?>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'tableOptions' => ['class' => 'table table-hover'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    [
                        'attribute' => 'cover_image',
                        'format' => 'html',
                        'label' => 'Обложка',
                        'value' => function ($model) {
                            return $model->cover_image
                                ? Html::img('@web/uploads/' . $model->cover_image, ['class' => 'book-cover-thumb'])
                                : '<span class="text-muted"><i class="bi bi-image"></i></span>';
                        },
                    ],
                    'title',
                    'year',
                    [
                        'attribute' => 'authors',
                        'format' => 'html',
                        'label' => 'Авторы',
                        'value' => function ($model) {
                            return implode(', ', ArrayHelper::getColumn($model->authors, 'full_name'));
                        },
                    ],
                    'isbn',

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view} ' . (!Yii::$app->user->isGuest ? '{update} {delete}' : ''),
                        'buttons' => [
                            'view' => function ($url, $model, $key) {
                                return Html::a('<i class="bi bi-eye"></i>', $url, [
                                    'title' => 'Просмотр',
                                    'class' => 'btn btn-sm btn-outline-primary',
                                ]);
                            },
                            'update' => function ($url, $model, $key) {
                                return Html::a('<i class="bi bi-pencil"></i>', $url, [
                                    'title' => 'Редактировать',
                                    'class' => 'btn btn-sm btn-outline-warning',
                                ]);
                            },
                            'delete' => function ($url, $model, $key) {
                                return Html::a('<i class="bi bi-trash"></i>', $url, [
                                    'title' => 'Удалить',
                                    'class' => 'btn btn-sm btn-outline-danger',
                                    'data' => [
                                        'confirm' => 'Вы уверены?',
                                        'method' => 'post',
                                    ],
                                ]);
                            },
                        ],
                    ],
                ],
            ]); ?>
        </div>
    </div>

</div>

