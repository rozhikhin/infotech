<?php

use backend\services\FileServices;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var frontend\models\Book $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Книги', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="book-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('На главную', ['index', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'year',
            'description:ntext',
            'isbn',
            'count',
        ],
    ]) ?>

    <?php if($model->photo): ?>
        <img src="<?= FileServices::getDataURI($model->photo)?>" alt="<?=$model->name ?>" width="500" >
    <?php endif; ?>
</div>
