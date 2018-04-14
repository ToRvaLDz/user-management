<?php

use webvimark\modules\UserManagement\UserManagementModule;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var webvimark\modules\UserManagement\models\forms\ChangeOwnPasswordForm $model
 */

use app\assets\LoginAsset;
LoginAsset::register($this);


$this->title=UserManagementModule::t('back', 'Change own password');

if ( Yii::$app->session->hasFlash('success') ): ?>
    <div class="alert alert-success text-center">
        <?= Yii::$app->session->getFlash('success') ?>
    </div>
<?php endif; ?>

<div class="change-own-password-view">
    <div class="m-portlet m-portlet--mobile">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                    <?= Html::encode($this->title) ?>
                </h3>
            </div>
        </div>
    </div>
    <div class="m-portlet__body">
            <?php $form = ActiveForm::begin([
                'id'=>'user',
                'layout'=>'horizontal',
                'validateOnBlur'=>false,
            ]); ?>

            <?php if ( $model->scenario != 'restoreViaEmail' ): ?>
                <?= $form->field($model, 'current_password')
                    ->passwordInput(['maxlength' => 255, 'autocomplete'=>'off'])
                ?>
            <?php endif; ?>

            <?= $form->field($model, 'password')
                ->passwordInput(['maxlength' => 255, 'autocomplete'=>'off'])
            ?>

            <?= $form->field($model, 'repeat_password')->label(UserManagementModule::t('back', 'Repeat password'))
                ->passwordInput(['maxlength' => 255, 'autocomplete'=>'off'])
            ?>


            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    <?= Html::submitButton(
                        '<span class="glyphicon glyphicon-ok"></span> ' . UserManagementModule::t('back', 'Save'),
                        ['class' => 'btn btn-primary']
                    ) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
		</div>
	</div>
</div>
