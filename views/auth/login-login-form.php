<?php
/**
 * User: Roberto Braga
 * Date: 12/12/17
 * Time: 14.45
 */


use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>
<div class="m-login__signin">
    <div class="m-login__head">
        <h3 class="m-login__title">
            Login utente
        </h3>
    </div>
    <?php $form = ActiveForm::begin([
        'options'=>['class'=>'m-login__form m-form'],
        'validateOnBlur'=>false,
        'fieldConfig' => ['options' => ['class' => 'form-group m-form__group'],'errorOptions'=>['class'=>'form-control-feedback']],
        'errorCssClass' => 'has-danger',

    ]) ?>
    <?= $form
        ->field($model, 'username')
        ->textInput([
            'placeholder'=>'Utente',
            'autocomplete'=>'off',
            'class'=>'form-control m-input',
            'maxlength' => 255, 'autofocus'=>true,
        ])
        ->label(false);
    ?>
    <?= $form
        ->field($model, 'password')
        ->passwordInput([
            'placeholder'=>$model->getAttributeLabel('password'),
            'class'=>'form-control m-input m-login__form-input--last',
        ])
        ->label(false);
    ?>
    <div class="row m-login__form-sub">
        <div class="col m--align-left m-login__form-left">
            <label class="m-checkbox  m-checkbox--primary">
                <input type="checkbox" name="LoginForm[rememberMe]" value="1">
                Ricordami
                <span></span>
            </label>
        </div>
        <div class="col m--align-right m-login__form-right">
            <a href="javascript:;" id="m_login_forget_password" class="m-link">
                Password dimenticata?
            </a>
        </div>
    </div>
    <div class="m-login__form-action">
        <?= Html::submitButton(
            'Login',
            ['class' => 'btn m-btn--pill m-btn--air btn-primary  m-login__btn m-login__btn--primary']
        ) ?>
    </div>
    <?php ActiveForm::end() ?>
</div>
