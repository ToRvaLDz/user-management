<?php
/**
 * @var $this yii\web\View
 * @var $model webvimark\modules\UserManagement\models\forms\LoginForm
 */
use webvimark\modules\UserManagement\assets\LoginAsset;
use app\assets\AppAsset;
AppAsset::register($this);
LoginAsset::register($this);
?>

<!-- BEGIN LOGIN FORM -->
<div class="kt-grid kt-grid--ver kt-grid--root">
    <div class="kt-grid kt-grid--hor kt-grid--root kt-login kt-login--v2 kt-login--signin" id="kt_login">
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" style="background-image: url(./assets/media//bg/bg-1.jpg);">
            <div class="kt-grid__item kt-grid__item--fluid kt-login__wrapper">
                <div class="kt-login__container">
                    <div class="kt-login__logo">
                        <a href="#">
                            <img src="./assets/media/logos/logo-mini-2-md.png">
                        </a>
                    </div>
                     <?= $this->render('login-login-form', ['model' => $model]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END LOGIN FORM -->

