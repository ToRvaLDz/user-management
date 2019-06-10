<?php
/**
 * @var $this yii\web\View
 * @var $model webvimark\modules\UserManagement\models\forms\LoginForm
 */

?>


<!-- BEGIN LOGIN FORM -->
<?php $form = ActiveForm::begin([
    'id'      => 'login-form',
    'options'=>['autocomplete'=>'off'],
    'validateOnBlur'=>false,
    'fieldConfig' => [
        'template'=>"{input}\n{error}",
    ],
]) ?>

    <h3 class="form-title">Esegui il login</h3>
    <div class="alert alert-danger display-hide">
        <button class="close" data-close="alert"></button>
			<span>
			Inserisci il nome utente e la password. </span>
    </div>
    <div class="form-group">
        <label class="control-label visible-ie8 visible-ie9">Nome utente</label>
        <?= $form->field($model, 'username')
            ->textInput(['placeholder'=>$model->getAttributeLabel('username'), 'autocomplete'=>'off','class'=>'form-control form-control-solid placeholder-no-fix']) ?>
    </div>
    <div class="form-group">
        <label class="control-label visible-ie8 visible-ie9">Password</label>
        <?= $form->field($model, 'password')
            ->passwordInput(['placeholder'=>$model->getAttributeLabel('password'), 'autocomplete'=>'off','class'=>'form-control form-control-solid placeholder-no-fix']) ?>
    </div>
    <div class="form-actions">
        <?= Html::submitButton(
            UserManagementModule::t('front', 'Login'),
            ['class' => 'btn btn-success uppercase']
        ) ?>
        <label class="rememberme check">
            <?= $form->field($model, 'rememberMe')->checkbox(['label'=>'Ricordami','value'=>true]) ?>
            </label>
    </div>
<?php ActiveForm::end() ?>
<!-- END LOGIN FORM -->
