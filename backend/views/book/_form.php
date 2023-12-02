<?php

use backend\FileServices;
use backend\models\Author;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\Book $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="book-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="form-group mb-3">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="form-group mb-3">
        <?= $form->field($model, 'year')->textInput() ?>
    </div>

    <div class="form-group mb-3">
        <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
    </div>

    <div class="form-group mb-3">
        <?= $form->field($model, 'isbn')->textInput(['maxlength' => true]) ?>
    </div>
<!--    --><?php //= $form->field($model, 'photo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'count')->textInput() ?>
    <div class="form-group mb-3">
        <?= $form->field($model, 'authorBooks')->dropDownList(
           ArrayHelper::map(Author::find()->all(),'id','fio'),
            [
                'multiple'=>'multiple'
            ]
        );
        ?>
    </div>


    <?php if($model->photo): ?>
        <img src="<?= FileServices::getDataURI($model->photo)?>" alt="<?=$model->name ?>" width="500" >
    <?php endif; ?>
    
    <div class="form-group mb-3">
        <?= $form->field($model, 'imageFile')->fileInput(['class' => 'form-control']) ?>
    </div>

    <div class="form-group mb-3">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
