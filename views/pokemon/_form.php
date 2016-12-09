<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Pokemon */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pokemon-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'number')->textInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'total')->textInput() ?>

    <?= $form->field($model, 'hp')->textInput() ?>

    <?= $form->field($model, 'attach')->textInput() ?>

    <?= $form->field($model, 'defense')->textInput() ?>

    <?= $form->field($model, 'spatk')->textInput() ?>

    <?= $form->field($model, 'spdef')->textInput() ?>

    <?= $form->field($model, 'speed')->textInput() ?>

    <?= $form->field($model, 'generation')->textInput() ?>

    <?= $form->field($model, 'legendary')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
