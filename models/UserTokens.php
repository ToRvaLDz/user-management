<?php

namespace webvimark\modules\UserManagement\models;

use webvimark\modules\UserManagement\components\UserIdentity;
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
 * @property User $user
 */
class UserTokens extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return Yii::$app->getModule('user-management')->user_tokens;
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
            [['created_at','updated_at'],'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'         => UserManagementModule::t('back', 'ID'),
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
