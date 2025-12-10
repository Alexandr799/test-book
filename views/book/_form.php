<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Book $model */
/** @var yii\widgets\ActiveForm $form */
/** @var array $authors */
?>

<div class="book-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'year')->textInput() ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'isbn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'author_ids')->dropDownList($authors, [
        'multiple' => true,
        'size' => 5,
        'prompt' => 'Выберите авторов'
    ])->label('Авторы') ?>

    <?= $form->field($model, 'coverFile')->fileInput()->label('Загрузить обложку') ?>

    <?php if ($model->cover_image): ?>
        <div class="form-group">
            <label>Текущая обложка:</label><br>
            <?= Html::img('@web/uploads/' . $model->cover_image, ['width' => '200']) ?>
        </div>
    <?php endif; ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

