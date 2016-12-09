<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MisUser */

$this->title = 'Create Mis User';
$this->params['breadcrumbs'][] = ['label' => 'Mis Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mis-user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
