<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reserva".
 *
 * @property int $id
 * @property int $sala_id
 * @property int $user_id
 * @property string $titulo_evento
 * @property string $publico_alvo
 * @property string $data_do_evento
 * @property string $hora_de_inicio_do_evento
 * @property string $hora_final_do_evento
 * @property string $evento_publico
 *
 * @property Sala $sala
 * @property LoginsUsuarios $user
 */
class Reserva extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reserva';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['titulo_evento',  'data_do_evento', 'hora_de_inicio_do_evento'  ], 'required'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoginsUsuarios::class, 'targetAttribute' => ['user_id' => 'login']],
            [['sala_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sala::class, 'targetAttribute' => ['sala_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sala_id' => 'Sala ID',
            'user_id' => 'User ID',
            'titulo_evento' => 'Titulo Evento',
            'publico_alvo' => 'Publico Alvo',
            'data_do_evento' => 'Data Do Evento',
            'hora_de_inicio_do_evento' => 'Hora De Inicio Do Evento',
            'hora_final_do_evento' => 'Hora Final Do Evento',
            'evento_publico' => 'Evento Publico',
        ];
    }


		public function getDataDoEventoISO()
		{
			$date = \DateTime::createFromFormat('d/m/Y', $this->data_do_evento);
			return $date ? $date->format('Y-m-d') : null;
		}



    /**
     * Gets query for [[Sala]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSala()
    {
        return $this->hasOne(Sala::class, ['id' => 'sala_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(LoginsUsuarios::class, ['login' => 'user_id']);
    }

}
