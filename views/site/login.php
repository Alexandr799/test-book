<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Вход в систему';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0"><i class="bi bi-box-arrow-in-right"></i> <?= Html::encode($this->title) ?></h4>
                </div>
                <div class="card-body p-4">

                    <?php $form = ActiveForm::begin([
                        'id' => 'login-form',
                    ]); ?>

                    <?= $form->field($model, 'username')->textInput([
                        'autofocus' => true,
                        'placeholder' => 'Введите логин',
                        'class' => 'form-control form-control-lg'
                    ])->label('<i class="bi bi-person"></i> Логин') ?>

                    <?= $form->field($model, 'password')->passwordInput([
                        'placeholder' => 'Введите пароль',
                        'class' => 'form-control form-control-lg'
                    ])->label('<i class="bi bi-lock"></i> Пароль') ?>

                    <?= $form->field($model, 'rememberMe')->checkbox()->label('Запомнить меня') ?>

                    <div class="form-group mt-3">
                        <?= Html::submitButton('<i class="bi bi-box-arrow-in-right"></i> Войти', [
                            'class' => 'btn btn-primary btn-lg w-100',
                            'name' => 'login-button'
                        ]) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
                <div class="card-footer bg-light">
                    <div class="alert alert-info mb-0">
                        <i class="bi bi-info-circle"></i> 
                        <strong>Тестовый доступ:</strong><br>
                        Логин: <code>admin</code><br>
                        Пароль: <code>admin123</code>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
