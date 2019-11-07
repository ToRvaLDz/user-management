<?php

use webvimark\modules\UserManagement\models\User;
use webvimark\extensions\BootstrapSwitch\BootstrapSwitch;
use webvimark\modules\UserManagement\UserManagementModule;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var webvimark\modules\UserManagement\models\User $model
 */


$title="Modifica utente : " . $model->username;
$icon="flaticon-edit-1";
$subtitle='';

$this->title = (!empty($subtitle) ? $subtitle : $title). ' @ ' . yii::$app->id;
$this->params['breadcrumbs'][] = (!empty($subtitle) ? $subtitle : $title);



$this->params['breadcrumbs'][] = ['label' => UserManagementModule::t('back', 'Utenti'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = UserManagementModule::t('back', 'Modifica');
?>
<div class="user-edit">
    <div class="kt-portlet kt-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        <i class="<?= $icon ?>"></i> <?= Html::encode($title) ?>
                        <small>
							<?= Html::encode($subtitle) ?>
                        </small>
                    </h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
			<?= $this->render('_form', compact('model')) ?>
		</div>
	</div>

</div>