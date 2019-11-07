<?php

use webvimark\modules\UserManagement\UserManagementModule;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var webvimark\modules\UserManagement\models\User $model
 */

$title=UserManagementModule::t('back', 'User creation');
$icon="flaticon-user-add";
$subtitle='';

$this->title = (!empty($subtitle) ? $subtitle : $title). ' @ ' . yii::$app->id;
$this->params['breadcrumbs'][] = ['label' => UserManagementModule::t('back', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = (!empty($subtitle) ? $subtitle : $title);

?>
<div class="user-create">
    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-caption">
                <div class="kt-portlet__head-title">
                    <h3 class="kt-portlet__head-text">
                        <i class="<?= $icon ?>"></i> <?= Html::encode($title) ?>
                        <small>
							<?= Html::encode($subtitle) ?>
                        </small>
                    </h3>
                </div>
            </div>
        </div>
        <div class="kt-portlet__body">
			<?= $this->render('_form', compact('model')) ?>
		</div>
	</div>
</div>
