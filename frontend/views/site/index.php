<?php

use backend\services\FileServices;
use backend\services\SubscribeServices;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Книги';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label'=>'Название',
                'format' => 'raw',
                'value'=>function ($data) {
                    return Html::a($data->name ,['site/view', 'id' => $data->id]);
                },
            ],
            'year',
            'description:ntext',
            'isbn',
            [
                'label'=>'Фото',
                'format' => 'raw',
                'value'=>function ($model) {
                        if($model->photo) {
                            return '<img src="' . FileServices::getDataURI($model->photo) . '"  width="50" >';
                        } else {
                            return '';
                        }
                },
            ],
            'count',
            [
                'header' => 'Сообщить и поступлении',
                'content' => function($model) {
                    if ($model->count) {
                        return '';
                    } elseif(SubscribeServices::checkSubscribe($model->id)) {
                        return 'Вы подписаны';
                    } else {
                        return Html::a(
                                'Сообщить о поступлении',
                                Url::to(['/subscribe', 'id' => $model->id]),
                                [
                                        'data-book-id' => $model->id,
                                        'class' => 'subscribe btn btn-success btn-xs' . (false ? '' : 'd-none')
                                ]
                        );
                    }

                }
            ],
        ],
    ]); ?>


</div>

<?php
    $js = <<<JS
        $('.subscribe').on('click', function(event){
            event.preventDefault();
            const currentButton = $(this);
            const id = currentButton.data('book-id');
        $.ajax({
            url: '/site/subscribe?id=' + id,
            type: 'get',
            success: function(res){
                currentButton.parent().html('Вы подписаны');
            },
            error: function(){
                currentButton.parent().html('Ошибка');
            }
        });
            return false;
        });
    JS;

    $this->registerJs($js);
?>
