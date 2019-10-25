<?php
/**
 * @var $this yii\web\View
 * @var $model webvimark\modules\UserManagement\models\forms\LoginForm
 */
use webvimark\modules\UserManagement\assets\LoginAsset;

$loginAsset=LoginAsset::register($this);
?>
<!-- BEGIN LOGIN FORM -->
<div class="kt-grid kt-grid--ver kt-grid--root kt-page">
    <div class="kt-grid kt-grid--hor kt-grid--root  kt-login kt-login--v3 kt-login--signin" id="kt_login">
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" style="background-image: url('<?= $loginAsset->baseUrl . '/media/bg.jpg' ?>');">
            <div class="kt-grid__item kt-grid__item--fluid kt-login__wrapper">
                <div class="kt-login__container">
                    <div class="kt-login__logo">
                        <a href="#">
                            <img src="<?= yii::getAlias('@web/login-logo.png'); ?>">
                        </a>
                    </div>
                     <?= $this->render('login-login-form', ['model' => $model]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END LOGIN FORM -->
<!-- begin::Global Config(global config for global JS sciprts) -->
<script>
    var KTAppOptions = {"colors":{"state":{"brand":"#3d94fb","light":"#ffffff","dark":"#282a3c","primary":"#5867dd","success":"#34bfa3","info":"#3d94fb","warning":"#ffb822","danger":"#fd27eb"},"base":{"label":["#c5cbe3","#a1a8c3","#3d4465","#3e4466"],"shape":["#f0f3ff","#d9dffa","#afb4d4","#646c9a"]}}};
</script>
<!-- end::Global Config -->
