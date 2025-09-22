<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Reserva;

/**
 * ReservaSearch represents the model behind the search form of `app\models\Reserva`.
 */
class ReservaSearch extends Reserva
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'sala_id', 'user_id'], 'integer'],
            [['titulo_evento', 'publico_alvo', 'data_do_evento', 'hora_de_inicio_do_evento', 'hora_final_do_evento', 'evento_publico'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @param string|null $formName Form name to be used into `->load()` method.
     *
     * @return ActiveDataProvider
     */
    public function search($params, $formName = null)
    {
        $query = Reserva::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'sala_id' => $this->sala_id,
            'user_id' => $this->user_id,
            'data_do_evento' => $this->data_do_evento,
            'hora_de_inicio_do_evento' => $this->hora_de_inicio_do_evento,
            'hora_final_do_evento' => $this->hora_final_do_evento,
        ]);

        $query->andFilterWhere(['like', 'titulo_evento', $this->titulo_evento])
            ->andFilterWhere(['like', 'publico_alvo', $this->publico_alvo])
            ->andFilterWhere(['like', 'evento_publico', $this->evento_publico]);

        return $dataProvider;
    }
}
