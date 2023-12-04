<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Author $model */

$this->title = 'Новый автор';
$this->params['breadcrumbs'][] = ['label' => 'Авторы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="author-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
