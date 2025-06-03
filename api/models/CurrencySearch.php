<?php

namespace api\models;

use core\entities\Currency;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class CurrencySearch extends Model
{
    public ?int $num_code = null;
    public string $char_code = '';
    public ?int $nominal = 1;
    public string $name = '';
    public float $value = 0.0000;
    public float $rate = 0.0000;

    public function rules(): array
    {
        return [
            [['num_code', 'nominal', 'value', 'rate'], 'integer'],
            [['char_code'], 'string'],
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
            'query'      => $query,
            'sort'       => [
                'defaultOrder' => ['num_code' => SORT_ASC]
            ],
            'pagination' => [
                'pageSize'       => Yii::$app->params['pageSize'],
                'pageParam'      => 'page',
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
            'num_code' => $this->num_code,
        ]);

        $query->andFilterWhere(['like', 'num_code', $this->num_code]);

        return $dataProvider;
    }
}
