<?php

namespace webvimark\modules\UserManagement\models\search;

use webvimark\modules\UserManagement\models\UserTokens;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * UserTokensSearch represents the model behind the search form about `webvimark\modules\UserManagement\models\UserTokens`.
 */
class UserTokensSearch extends UserTokens
{
    public function rules()
    {
        return [
            [['user_id','id'], 'integer'],
            [['token'], 'string'],
            [['banned'], 'boolean'],
            [['created_at','updated_at'],'safe']
        ];
    }

	public function scenarios()
	{
		// bypass scenarios() implementation in the parent class
		return Model::scenarios();
	}

	public function search($params)
	{
		$query = UserTokens::find();

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'pagination' => [
				'pageSize' => Yii::$app->request->cookies->getValue('_grid_page_size', 20),
			],
			'sort'=>[
				'defaultOrder'=>['user_id'=> SORT_DESC],
			],
		]);

		if (!($this->load($params) && $this->validate())) {
			return $dataProvider;
		}

		$query->andFilterWhere([
			$this->tableName() . '.id' => $this->id,
			$this->tableName() . '.user_id' => $this->user_id,
			$this->tableName() . '.token' => $this->token,
			$this->tableName() . '.banned' => $this->banned,
		]);

		return $dataProvider;
	}
}
