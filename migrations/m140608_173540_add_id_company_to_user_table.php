<?php

	use yii\db\Schema;
	use yii\db\Migration;

	class m140608_173540_add_id_company_to_user_table extends Migration
	{
		public function safeUp()
		{
			// Check if user Table exist
			// $tablename = \Yii::$app->db->tablePrefix.'user';
			$tablename = \Yii::$app->getModule('user-management')->user_table;

			// Create user table
			$this->addColumn($tablename,'id_company','varchar(10)');
		}

		public function safeDown()
		{
			$this->dropColumn(Yii::$app->getModule('user-management')->user_table,'id_company');
		}
	}
