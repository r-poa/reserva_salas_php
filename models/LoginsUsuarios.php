<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "logins_usuarios".
 *
 * @property string $login
 * @property string $nome
 * @property string $e_mail
 * @property string $setor
 *
 * @property Reserva[] $reservas
 */
class LoginsUsuarios extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'logins_usuarios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['login', 'nome', 'e_mail', 'setor'], 'required'],
            [['login', 'nome', 'e_mail', 'setor'], 'string', 'max' => 100],
            [['login'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'login' => 'Login',
            'nome' => 'Nome',
            'e_mail' => 'E Mail',
            'setor' => 'Setor',
        ];
    }

    /**
     * Gets query for [[Reservas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReservas()
    {
        return $this->hasMany(Reserva::class, ['user_id' => 'login']);
    }

}
