<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Book $model */
/** @var array $authors */

$this->title = 'Создать книгу';
$this->params['breadcrumbs'][] = ['label' => 'Книги', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-create">

    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0"><i class="bi bi-plus-circle"></i> <?= Html::encode($this->title) ?></h4>
        </div>
        <div class="card-body">
            <?= $this->render('_form', [
                'model' => $model,
                'authors' => $authors,
            ]) ?>
        </div>
    </div>

</div>

