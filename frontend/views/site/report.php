<?php

use backend\services\FileServices;
use backend\services\SubscribeServices;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var int $year */

$this->title = 'Отчет ТОП 10';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="author-report">

    <?= Html::beginForm(['/site/report'], 'POST', ['class' => 'justify-content-center align-items-center d-flex mb-5']); ?>
    <?=Html::label("Выберите год ", $year, ['style' => 'margin: 20px']) ?>
    <?= Html::dropDownList('year', $year,
        ArrayHelper::map(
                \backend\models\Book::find()->select('year')
                    ->distinct()
                    ->orderBy('year')
                    ->asArray()
                    ->all(), 'year', 'year')
    , ['id' => 'year', 'rows' => 6,  'style' => 'width: 200px; margin: 20px', 'class' => 'form-select mr-3']); ?>
    <div class="form-group">
        <?= Html::submitButton('Получить', ['class' => 'btn btn-primary ml-3']); ?>
    </div>
    <?= Html::endForm(); ?>
</div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'fio',
        ],
    ]); ?>


