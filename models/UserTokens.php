<?php

namespace webvimark\modules\UserManagement\models;

use sizeg\jwt\Jwt;
use webvimark\modules\UserManagement\UserManagementModule;
use Yii;

/**
 * This is the model class for table "user_tokens".
 *
 * @property integer $user_id
 * @property string $token
 * @property bool $banned
 * @property integer $created_at
 * @property integer $updated_at
 * @property datetime $expire_at
 * @property User $user
 * @property int $id [int(11)]
 */
class UserTokens extends \webvimark\components\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return Yii::$app->getModule('user-management')->user_tokens_table;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['token', 'user_id'], 'required'],
            [['user_id'], 'integer'],
            [['token'], 'string'],
            [['banned'], 'boolean'],
            [['expire_at'],'integer'],
            [['created_at','updated_at','id'],'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'         => UserManagementModule::t('back', 'ID'),
            'user_id'    => UserManagementModule::t('back', 'User ID'),
            'token'      => UserManagementModule::t('back', 'Token'),
            'banned'     => UserManagementModule::t('back', 'Banned'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
