<?php
/**
 * @var $this yii\web\View
 * @var $model webvimark\modules\UserManagement\models\forms\LoginForm
 */
use app\assets\LoginAsset;


LoginAsset::register($this);

?>


<!-- BEGIN LOGIN FORM -->

<div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-2" id="m_login" style="background-image: url(/theme/default/assets/app/media/img//bg/bg-3.jpg);">
    <div class="m-grid__item m-grid__item--fluid	m-login__wrapper">
        <div class="m-login__container">
            <div class="m-login__logo">
                <a href="#">
                    <img src="<?= yii::$app->params['login_logo'] ?>">
                </a>
            </div>
            <?= $this->render('login-login-form', ['model' => $model]) ?>
            <?= $this->render('login-pwd-recovery-form', ['modelrecovery' => $modelrecovery]) ?>

        </div>
    </div>
</div>
<!-- END LOGIN FORM -->

<?php
if($this->context->action->id=='password-recovery') {
    $js=<<<JS

$('#m_login_forget_password').trigger("click");

JS;


$this->registerJs(
    $js,
    \yii\web\View::POS_READY,
    'recovery'
);

}