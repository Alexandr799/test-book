<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Subscription $model */
/** @var yii\widgets\ActiveForm $form */

$this->title = 'Подписка на уведомления о новых книгах';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-subscribe">

    <h1><i class="bi bi-bell"></i> <?= Html::encode($this->title) ?></h1>

    <div class="alert alert-info d-flex align-items-start">
        <i class="bi bi-info-circle me-2" style="font-size: 1.5rem;"></i>
        <div>
            <strong>Информация:</strong> Подпишитесь, чтобы получать SMS-уведомления при появлении новых книг в каталоге.
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card shadow-sm">
                <div class="card-body">
                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'phone')->textInput([
                        'maxlength' => true,
                        'placeholder' => '+79XXXXXXXXX',
                        'class' => 'form-control form-control-lg'
                    ])->hint('Формат: +79XXXXXXXXX')->label('<i class="bi bi-phone"></i> Номер телефона') ?>

                    <div class="form-group mt-3">
                        <?= Html::submitButton('<i class="bi bi-check-circle"></i> Подписаться', ['class' => 'btn btn-success btn-lg w-100']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>

</div>

