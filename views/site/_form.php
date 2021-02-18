<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model app\models\Application */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="application-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="col-md-6">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true,'disabled'=>!Yii::$app->user->isGuest]) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'surname')->textInput(['maxlength' => true, 'disabled'=>!Yii::$app->user->isGuest]) ?>
    </div>
    <div class="col-md-8">
        <?= $form->field($model, 'address')->textInput(['maxlength' => true,'disabled'=>!Yii::$app->user->isGuest]) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'country')->textInput(['maxlength' => true, 'disabled'=>!Yii::$app->user->isGuest]) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'email')->textInput(['maxlength' => true,'disabled'=>!Yii::$app->user->isGuest]) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'phone')->widget(MaskedInput::class, [
            'mask' => '(99)-999-99-99',
            // 'disabled'=>!Yii::$app->user->isGuest
        ]) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'age')->textInput(['maxlength' => true, 'disabled'=>!Yii::$app->user->isGuest,'type'=>'number']) ?>
    </div>
    <?php if(!Yii::$app->user->isGuest):?>
    <?= $form->field($model, 'hired')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'date')->textInput() ?>

    <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>

    <?php endif;?>

    <div class="col-md-12">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
