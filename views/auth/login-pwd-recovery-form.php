<?php
/**
 * User: Roberto Braga
 * Date: 12/12/17
 * Time: 14.47
 */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\captcha\Captcha;
?>
            <div class="kt-login__forget-password">
                <div class="kt-login__head">
                    <h3 class="kt-login__title">
                        Password dimenticata?
                    </h3>
                    <div class="kt-login__desc">
                        Inserisci il tuo indirizzo email per recuperare la password:
                    </div>
                </div>
                <?php $form = ActiveForm::begin([
                    'options'=>['class'=>'kt-login__form kt-form'],
                    'action'=> 'password-recovery',
                    'method' => 'post',
//                    'enableClientValidation' => false,
                    'enableAjaxValidation' => true,
                    'validateOnBlur'=>true,
                    'fieldConfig' => ['options' => ['class' => 'form-group kt-form__group'],'errorOptions'=>['class'=>'form-control-feedback']],
                    'errorCssClass' => 'has-danger',
                ]) ?>

                <?= $form
                        ->field($modelrecovery, 'email')
                        ->textInput([
                            'placeholder'=>$modelrecovery->getAttributeLabel('email'),
                            'autocomplete'=>'off',
                            'class'=>'form-control kt-input',
                            'maxlength' => 255, 'autofocus'=>true
                        ])
                        ->label(false);
                    ?>



                    <div class="kt-login__form-action">
                        <?= Html::submitButton(
                            'Procedi',
                            ['class' => 'btn kt-btn kt-btn--pill kt-btn--custom kt-btn--air kt-login__btn kt-login__btn--primary']
                        ) ?>
                        &nbsp;&nbsp;
                        <button id="m_login_forget_password_cancel" class="btn kt-btn kt-btn--pill kt-btn--custom kt-btn--air kt-login__btn">
                            Annulla
                        </button>
                    </div>
                <?php ActiveForm::end() ?>

                <?php
                $recovery=Yii::$app->session->getFlash('recovery');
                if(is_array($recovery)) {


                    $recovery['message'] = $recovery['message'];
                    echo Html::tag('div', $recovery['message'],['role'=>"alert", 'class'=>'alert alert-'.$recovery['status']]);
                }
                ?>

            </div>

