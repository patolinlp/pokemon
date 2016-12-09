<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Pokemon */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Pokemons', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pokemon-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'number',
            'name',
            'type1',
            'type2',
            'total',
            'hp',
            'attach',
            'defense',
            'spatk',
            'spdef',
            'speed',
            'generation',
            'legendary',
        ],
    ]) ?>

    <h1>Comentarios: </h1>

    <?php foreach($comentarios as  $comentario):  ?>
    <h4>Anónimo</h4>
    <label><?= Html::encode("{$comentario->comentario}")  ?></label>
    <?php endforeach    ?>

</div>
