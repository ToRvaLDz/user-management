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
            <div class="m-login__forget-password">
                <div class="m-login__head">
                    <h3 class="m-login__title">
                        Password dimenticata?
                    </h3>
                    <div class="m-login__desc">
                        Inserisci il tuo indirizzo email per recuperare la password:
                    </div>
                </div>
                <?php $form = ActiveForm::begin([
                    'options'=>['class'=>'m-login__form m-form'],
                    'action'=> 'password-recovery',
                    'method' => 'post',
//                    'enableClientValidation' => false,
                    'enableAjaxValidation' => true,
                    'validateOnBlur'=>true,
                    'fieldConfig' => ['options' => ['class' => 'form-group m-form__group'],'errorOptions'=>['class'=>'form-control-feedback']],
                    'errorCssClass' => 'has-danger',
                ]) ?>

                <?= $form
                        ->field($modelrecovery, 'email')
                        ->textInput([
                            'placeholder'=>$modelrecovery->getAttributeLabel('email'),
                            'autocomplete'=>'off',
                            'class'=>'form-control m-input',
                            'maxlength' => 255, 'autofocus'=>true
                        ])
                        ->label(false);
                    ?>



                    <div class="m-login__form-action">
                        <?= Html::submitButton(
                            'Procedi',
                            ['class' => 'btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary']
                        ) ?>
                        &nbsp;&nbsp;
                        <button id="m_login_forget_password_cancel" class="btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn">
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

