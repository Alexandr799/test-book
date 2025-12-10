<?php

use yii\helpers\Html;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Авторы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="author-index">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="bi bi-person-lines-fill"></i> <?= Html::encode($this->title) ?></h1>
        <?php if (!Yii::$app->user->isGuest): ?>
            <?= Html::a('<i class="bi bi-plus-circle"></i> Создать автора', ['create'], ['class' => 'btn btn-success']) ?>
        <?php endif; ?>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'tableOptions' => ['class' => 'table table-hover'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'id',
                    [
                        'attribute' => 'full_name',
                        'format' => 'html',
                        'label' => 'ФИО',
                        'value' => function ($model) {
                            return '<i class="bi bi-person"></i> ' . Html::encode($model->full_name);
                        },
                    ],
                    'created_at:datetime',

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

