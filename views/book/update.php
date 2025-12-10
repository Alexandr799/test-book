<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Book $model */
/** @var array $authors */

$this->title = 'Редактировать книгу: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Книги', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="book-update">

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="bi bi-pencil"></i> <?= Html::encode($this->title) ?></h4>
        </div>
        <div class="card-body">
            <?= $this->render('_form', [
                'model' => $model,
                'authors' => $authors,
            ]) ?>
        </div>
    </div>

</div>

