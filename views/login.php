<?php
/**
 * @var $this yii\web\View
 * @var $model webvimark\modules\UserManagement\models\forms\LoginForm
 */

    use webvimark\modules\UserManagement\UserManagementModule;
    use yii\bootstrap4\ActiveForm;
    use yii\bootstrap4\Html; ?>


<!-- BEGIN LOGIN FORM -->
<?php $form = ActiveForm::begin([
    'id'      => 'login-form',
    'options'=>['autocomplete'=>'off'],
    'validateOnBlur'=>false,
    'fieldConfig' => [
        'template'=>"{input}\n{error}",
    ],
]) ?>
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
                    <div class="kt-login__signin">
                        <div class="kt-login__head">
                            <h3 class="kt-login__title">Sign In To Admin</h3>
                        </div>
                        <form class="kt-form" action="">
                            <div class="input-group">
                                <?= $form->field($model, 'username')
                                    ->textInput(['placeholder'=>$model->getAttributeLabel('username'), 'autocomplete'=>'off','class'=>'form-control']) ?>
                            </div>
                            <div class="input-group">
                                <?= $form->field($model, 'password')
                                    ->passwordInput(['placeholder'=>$model->getAttributeLabel('password'), 'autocomplete'=>'off','class'=>'form-control']) ?>
                            </div>
                            <div class="row kt-login__extra">
                                <div class="col">
                                    <label class="kt-checkbox">
                                        <?= $form->field($model, 'rememberMe')->checkbox(['label'=>'Ricordami','value'=>true]) ?>
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                            <div class="kt-login__actions">
                                <?= Html::submitButton(
                                    UserManagementModule::t('front', 'Login'),
                                    ['class' => 'btn btn-pill kt-login__btn-primary']
                                ) ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end() ?>