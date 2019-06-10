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
<div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-2" id="m_login" style="background-image: url(/theme/default/assets/app/media/img//bg/bg-3.jpg);">
    <div class="m-grid__item m-grid__item--fluid	m-login__wrapper">
        <div class="m-login__container">
            <div class="m-login__logo">
                <a href="#">
                    <img src="/img/login-logo.png">
                </a>
            </div>
            <?= $this->render('login-login-form', ['model' => $model]) ?>
        </div>
    </div>
</div>
<!-- END LOGIN FORM -->

