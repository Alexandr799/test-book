<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;

/** @var yii\web\View $this */
/** @var app\models\Author $model */

$this->title = $model->full_name;
$this->params['breadcrumbs'][] = ['label' => 'Авторы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="author-view">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="bi bi-person"></i> <?= Html::encode($this->title) ?></h1>
        <?php if (!Yii::$app->user->isGuest): ?>
            <div>
                <?= Html::a('<i class="bi bi-pencil"></i> Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('<i class="bi bi-trash"></i> Удалить', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Вы уверены, что хотите удалить этого автора?',
                        'method' => 'post',
                    ],
                ]) ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'full_name',
                    'created_at:datetime',
                    'updated_at:datetime',
                ],
            ]) ?>
        </div>
    </div>

    <h3><i class="bi bi-book-half"></i> Книги автора</h3>

    <?php 
    $dataProvider = new ActiveDataProvider([
        'query' => $model->getBooks(),
    ]);
    
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'title',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a($model->title, ['/book/view', 'id' => $model->id]);
                },
            ],
            'year',
            'isbn',
        ],
    ]);
    ?>

</div>

