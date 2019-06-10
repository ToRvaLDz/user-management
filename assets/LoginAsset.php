<?php


namespace webvimark\modules\UserManagement\assets;
use yii\web\AssetBundle;


class LoginAsset extends AssetBundle
{
    public $sourcePath = '@vendor/user-management/assets/';

    public $js = [
		"login.js"
    ];

}

