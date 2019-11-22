<?php

use yii\db\Schema;
use yii\db\Migration;

class m191122_155739_create_user_tokens_table extends Migration
{
	public function safeUp()
	{
		$tableOptions = null;
		if ( $this->db->driverName === 'mysql' )
		{
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
		}

	        // Check if user Table exist
	        $tablename = \Yii::$app->getModule('user-management')->user_tokens_table;

		// Create user table
		$this->createTable($tablename, array(
			'user_id'            => 'int(11)',
			'token'              => 'text not null',
			'banned'             => 'tinyint(1) default 0 not null',
			'created_at'         => 'datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
			'updated_at'         => 'datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
		), $tableOptions);
        $this->addPrimaryKey('user_tokens_pk', $tablename, ['user_id', 'token']);
	}

	public function safeDown()
	{
		$this->dropTable(Yii::$app->getModule('user-management')->user_tokens_table);
	}
}
