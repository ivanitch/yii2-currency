<?php

namespace api\models;

use core\entities\Currency;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class CurrencySearch extends Model
{
    public ?int $id = null;
    public string $name = '';

    public function rules(): array
    {
        return [
            [['id'], 'integer'],
            [['name'], 'string'],
        ];
    }

    public function scenarios(): array
    {
        return Model::scenarios();
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Currency::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_ASC]
            ],
            'pagination' => [
                'pageSize' => Yii::$app->params['pageSize'],
                'pageParam' => 'page',
                'forcePageParam' => false,
                'pageSizeParam'  => false,
                'validatePage'   => false,
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
