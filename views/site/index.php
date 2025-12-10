<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Каталог книг';
?>
<div class="site-index">

    <div class="jumbotron text-center bg-light p-5 rounded-3 mb-4">
        <h1 class="display-4">📚 Добро пожаловать в каталог книг!</h1>
        <p class="lead">Удобная система управления библиотекой книг и авторов</p>
        <hr class="my-4">
        <p>Просматривайте книги, узнавайте об авторах и подписывайтесь на уведомления о новинках</p>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-book" style="font-size: 3rem; color: #0d6efd;"></i>
                    </div>
                    <h5 class="card-title">Каталог книг</h5>
                    <p class="card-text">Просмотрите наш полный каталог книг с описаниями и обложками</p>
                    <?= Html::a('Открыть каталог', ['/book/index'], ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-person-lines-fill" style="font-size: 3rem; color: #198754;"></i>
                    </div>
                    <h5 class="card-title">Авторы</h5>
                    <p class="card-text">Познакомьтесь с авторами и их произведениями</p>
                    <?= Html::a('Список авторов', ['/author/index'], ['class' => 'btn btn-success']) ?>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-graph-up" style="font-size: 3rem; color: #ffc107;"></i>
                    </div>
                    <h5 class="card-title">Статистика</h5>
                    <p class="card-text">Топ-10 авторов по количеству книг за выбранный год</p>
                    <?= Html::a('Посмотреть отчёт', ['/report/top-authors'], ['class' => 'btn btn-warning']) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-sm border-info">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="bi bi-bell"></i> Подписка на уведомления
                    </h5>
                    <p class="card-text">Получайте SMS-уведомления о новых книгах в нашем каталоге</p>
                    <?= Html::a('Подписаться', ['/site/subscribe'], ['class' => 'btn btn-info text-white']) ?>
                </div>
            </div>
        </div>
    </div>

    <?php if (Yii::$app->user->isGuest): ?>
        <div class="row mt-4">
            <div class="col-md-8 mx-auto">
                <div class="alert alert-primary d-flex align-items-center" role="alert">
                    <i class="bi bi-info-circle me-2" style="font-size: 1.5rem;"></i>
                    <div>
                        <strong>Для редакторов:</strong> 
                        <?= Html::a('Войдите в систему', ['/site/login'], ['class' => 'alert-link']) ?>, 
                        чтобы добавлять и редактировать книги и авторов
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

</div>

<style>
.card {
    transition: transform 0.2s;
}
.card:hover {
    transform: translateY(-5px);
}
</style>
