<?php

use yii\db\Migration;

class m191122_152000_change_auth_key_to_text extends Migration
{
	public function safeUp()
	{
        $this->alterColumn(Yii::$app->getModule('user-management')->user_table, 'auth_key', $this->text());

		if (Yii::$app->cache) {
			Yii::$app->cache->flush();
		}
	}

	public function safeDown()
	{
		return false;
	}
}
