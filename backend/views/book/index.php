<?php

use backend\models\Book;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Books';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Book', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'year',
            'description:ntext',
            'isbn',
            'photo',
            'count',
            [
                'class' => ActionColumn::class,
                'urlCreator' => function ($action, Book $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
            [
                'header' => 'Button',
                'content' => function($model) {
                    if ($model->count) {
                        return '';
                    } else {
                        return Html::a('Сообщить о поступлении', '/subscribe', ['class' => 'btn btn-success btn-xs'
                            . (false ? '' : 'd-none')]);
                    }

                }
            ],
        ],
    ]); ?>


</div>
