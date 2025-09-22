<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sala".
 *
 * @property int $id
 * @property string $nome_da_sala
 * @property string|null $descricao_da_sala
 * @property string|null $mensagem_de_aviso
 *
 * @property Reserva[] $reservas
 */
class Sala extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sala';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descricao_da_sala', 'mensagem_de_aviso'], 'default', 'value' => null],
            [['nome_da_sala'], 'required'],
            [['descricao_da_sala', 'mensagem_de_aviso'], 'string'],
            [['nome_da_sala'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome_da_sala' => 'Nome Da Sala',
            'descricao_da_sala' => 'Descricao Da Sala',
            'mensagem_de_aviso' => 'Mensagem De Aviso',
        ];
    }

    /**
     * Gets query for [[Reservas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReservas()
    {
        return $this->hasMany(Reserva::class, ['sala_id' => 'id']);
    }

}
