<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;
?>

<?php
    $f = ActiveForm::begin([
            "method"    =>  "get",
            "action"    =>  Url::toRoute("pokemon/index"),
            "enableClientValidation"    =>  true,
    ]);
?>

<div class="form-group">
    <?= 
        $f->field($form,"q")->input("search")   
    ?>
</div>
<?= Html::submitButton("Buscar", ["class" => "btn btn-primary"])    ?>
<?php   
    $f->end()   
?>

<h3><?= $search ?></h3>
<h1>Pokemon</h1>
<table  class="table table-bordered">
                <tr>
                    <th>ID</th>
                    <th>Número</th>
                    <th>Nombre</th>
                    <th>Tipo 1</th>
                    <th>Tipo 2</th>
                    <th>Total</th>
                    <th>HP</th>
                    <th>Ataque</th>
                    <th>Defensa</th>
                    <th>Coste de Ataque</th>
                    <th>Coste de Defensa</th>
                    <th>Velocidad</th>
                    <th>Generación</th>
                    <th>Legendario</th>
                    <th>Acciones</th>
                </tr>
                <?php foreach($pokemons as  $pokemon):  ?>
                <tr>
                    <td><?= $pokemon->id    ?></td>
                    <td><?= Html::encode("{$pokemon->number}")  ?></td>
                    <td><?= Html::encode("{$pokemon->name}")    ?></td>
                    <td><?= Html::encode("{$pokemon->type1}")   ?></td>
                    <td><?= Html::encode("{$pokemon->type2}")   ?></td>
                    <td><?= Html::encode("{$pokemon->total}")   ?></td>
                    <td><?= Html::encode("{$pokemon->hp}")  ?></td>
                    <td><?= Html::encode("{$pokemon->attach}")  ?></td>
                    <td><?= Html::encode("{$pokemon->defense}") ?></td>
                    <td><?= Html::encode("{$pokemon->spatk}")   ?></td>
                    <td><?= Html::encode("{$pokemon->spdef}")   ?></td>
                    <td><?= Html::encode("{$pokemon->speed}")   ?></td>
                    <td><?= Html::encode("{$pokemon->generation}")  ?></td>
                    <td><?= Html::encode("{$pokemon->legendary}")   ?></td>
                    <td><?= Html::a('Ver', ['view', 'id' => $pokemon->id]) ?>
                        <?= Html::a('Comentar', ['comentario/create', 'id_pokemon'=>$pokemon->id])?>

                    </td>
                </tr>
                <?php endforeach    ?>
</table>
<?= LinkPager::widget(['pagination' =>  $pagination])   ?>