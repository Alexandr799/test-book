<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var app\models\Book $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Книги', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="book-view">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="bi bi-book"></i> <?= Html::encode($this->title) ?></h1>
        <?php if (!Yii::$app->user->isGuest): ?>
            <div>
                <?= Html::a('<i class="bi bi-pencil"></i> Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('<i class="bi bi-trash"></i> Удалить', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Вы уверены, что хотите удалить эту книгу?',
                        'method' => 'post',
                    ],
                ]) ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <?php if ($model->cover_image): ?>
                        <?= Html::img('@web/uploads/' . $model->cover_image, ['class' => 'img-fluid book-cover']) ?>
                    <?php else: ?>
                        <div class="text-muted p-5">
                            <i class="bi bi-image" style="font-size: 4rem;"></i>
                            <p class="mt-2">Нет обложки</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="card-body">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            'title',
                            'year',
                            'description:ntext',
                            'isbn',
                            [
                                'label' => 'Авторы',
                                'value' => implode(', ', ArrayHelper::getColumn($model->authors, 'full_name')),
                            ],
                            'created_at:datetime',
                            'updated_at:datetime',
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

</div>

