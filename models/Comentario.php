<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comentario".
 *
 * @property integer $id
 * @property string $comentario
 * @property integer $id_pokemon
 *
 * @property Pokemon $idPokemon
 */
class Comentario extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comentario';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['comentario', 'id_pokemon'], 'required'],
            [['id_pokemon'], 'integer'],
            [['comentario'], 'string', 'max' => 150],
            [['id_pokemon'], 'exist', 'skipOnError' => true, 'targetClass' => Pokemon::className(), 'targetAttribute' => ['id_pokemon' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'comentario' => 'Comentario',
            'id_pokemon' => 'Id Pokemon',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPokemon()
    {
        return $this->hasOne(Pokemon::className(), ['id' => 'id_pokemon']);
    }
}
