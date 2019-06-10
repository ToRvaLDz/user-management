<?php


namespace webvimark\modules\UserManagement\assets;
use app\assets\AppAsset;
use yii\web\AssetBundle;


class LoginAsset extends AssetBundle
{
    public $sourcePath = '@vendor/webvimark/module-user-management/assets/';

    public $js = [
		"login.js"
    ];

    public $css =[
        "login.css"
    ];

    public $depends = [
        AppAsset::class,
    ];

}

