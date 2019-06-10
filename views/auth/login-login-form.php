<?php
    /**
     * @var $this yii\web\View
     * @var $model webvimark\modules\UserManagement\models\forms\LoginForm
     */

    use webvimark\modules\UserManagement\UserManagementModule;
    use app\widgets\ActiveForm;
 ?>

<!-- BEGIN LOGIN FORM -->
<div class="kt-login__signin">
    <div class="kt-login__head">
        <h3 class="kt-login__title">Login</h3>
    </div>
    <?php $form = ActiveForm::begin([
        'options'=>['class'=>'kt-form'],
        'validateOnBlur'=>false,
        'fieldConfig' => ['options' => ['class' => 'input-group'],'errorOptions'=>['class'=>'form-control-feedback']],
        'errorCssClass' => 'has-danger',

    ]) ?>
            <?= $form
                ->field($model, 'username')
                ->textInput([
                    'placeholder'=>'Utente',
                    'autocomplete'=>'off',
                    'class'=>'form-control',
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
    <?php ActiveForm::end() ?>
</div>
<!-- END LOGIN FORM -->

