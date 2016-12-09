<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<h3><?= $msg ?></h3>
<h1>Recuperar Password</h1>
<?php $form = ActiveForm::begin([
 'method' => 'post',
 'enableClientValidation' => true,
]);
?>
<div class="form-group">
<?= $form->field($model, "email")->input("email") ?>
</div>
<?= Html::submitButton("Recuperar Password", ["class"=> "btn btn-primary"]) ?>
<?php $form->end() ?>