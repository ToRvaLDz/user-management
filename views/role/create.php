<?php
/**
 *
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var webvimark\modules\UserManagement\models\rbacDB\Role $model
 */
use webvimark\modules\UserManagement\UserManagementModule;
	use yii\helpers\Html;

$title = UserManagementModule::t('back', 'Role creation');

$this->params['breadcrumbs'][] = ['label' => UserManagementModule::t('back', 'Roles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $title;
$icon="flaticon-users";
$subtitle='';
?>
<div class="user-index">
    <div class="m-portlet m-portlet--mobile">
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

                <?= $this->render('_form', [
                    'model'=>$model,
                ]) ?>

        </div>
    </div>
</div>