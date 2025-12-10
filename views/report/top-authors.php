<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var array $authors */
/** @var int $year */

$this->title = 'Топ-10 авторов за ' . $year . ' год';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-top-authors">

    <h1><i class="bi bi-graph-up"></i> <?= Html::encode($this->title) ?></h1>

    <div class="mb-4 card p-3 shadow-sm">
        <?= Html::beginForm(['report/top-authors'], 'get', ['class' => 'row g-3 align-items-center']) ?>
            <div class="col-auto">
                <label for="year" class="col-form-label"><i class="bi bi-calendar"></i> Выберите год:</label>
            </div>
            <div class="col-auto">
                <input type="number" name="year" id="year" value="<?= Html::encode($year) ?>" min="1900" max="<?= date('Y') + 10 ?>" class="form-control" required>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> Показать</button>
            </div>
        <?= Html::endForm() ?>
    </div>

    <?php if (empty($authors)): ?>
        <div class="alert alert-info">
            <strong>Информация:</strong> За <?= $year ?> год книги не найдены.
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Место</th>
                        <th>ФИО автора</th>
                        <th>Количество книг</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $position = 1; ?>
                    <?php foreach ($authors as $author): ?>
                        <tr>
                            <td><strong><?= $position++ ?></strong></td>
                            <td>
                                <i class="bi bi-person"></i>
                                <?= Html::a(Html::encode($author['full_name']), ['/author/view', 'id' => $author['id']]) ?>
                            </td>
                            <td>
                                <span class="badge bg-primary rounded-pill">
                                    <i class="bi bi-book"></i> <?= $author['book_count'] ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

</div>

