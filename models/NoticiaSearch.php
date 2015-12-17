<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Noticia;

/**
 * NoticiaSearch represents the model behind the search form about `app\models\Noticia`.
 */
class NoticiaSearch extends Noticia
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_autor', 'visitas'], 'integer'],
            [['nome_autor', 'titulo', 'introducao', 'imagem', 'corpo', 'fonte', 'tags', 'status', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Noticia::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'id_autor' => $this->id_autor,
            'visitas' => $this->visitas,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'nome_autor', $this->nome_autor])
            ->andFilterWhere(['like', 'titulo', $this->titulo])
            ->andFilterWhere(['like', 'introducao', $this->introducao])
            ->andFilterWhere(['like', 'imagem', $this->imagem])
            ->andFilterWhere(['like', 'corpo', $this->corpo])
            ->andFilterWhere(['like', 'fonte', $this->fonte])
            ->andFilterWhere(['like', 'tags', $this->tags])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
