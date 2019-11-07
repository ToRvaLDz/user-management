<?php
/**
 * @var yii\web\View $this
 * @var array $permissionsByGroup
 * @var webvimark\modules\UserManagement\models\User $user
 */

use webvimark\modules\UserManagement\models\rbacDB\Role;
use webvimark\modules\UserManagement\UserManagementModule;
use yii\bootstrap\BootstrapPluginAsset;
use yii\helpers\ArrayHelper;
use webvimark\modules\UserManagement\models\rbacDB\Permission;
use yii\helpers\Html;

BootstrapPluginAsset::register($this);


	$title= UserManagementModule::t('back', 'Ruoli e permessi per l\'utente:') . ' ' . $user->username;
	$icon="flaticon-users";
	$subtitle='';

	$this->title = $title;
	$this->params['breadcrumbs'][] = ['label' => UserManagementModule::t('back', 'Ruoli'), 'url' => ['role/index']];
	$this->params['breadcrumbs'][] = $this->title;
?>

<?php if ( Yii::$app->session->hasFlash('success') ): ?>
    <div class="alert alert-success text-center">
		<?= Yii::$app->session->getFlash('success') ?>
    </div>
<?php endif; ?>
    <div class="role-index">
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
        <div class="row">
	<div class="col-sm-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				<strong>
					<span class="glyphicon glyphicon-th"></span> <?= UserManagementModule::t('back', 'Ruoli') ?>
				</strong>
			</div>
			<div class="panel-body">

				<?= Html::beginForm(['set-roles', 'id'=>$user->id]) ?>

				<?= Html::checkboxList(
					'roles',
					ArrayHelper::map(Role::getUserRoles($user->id), 'name', 'name'),
					ArrayHelper::map(Role::getAvailableRoles(), 'name', 'description'),
					[
						'item'=>function ($index, $label, $name, $checked, $value) {
								$list = '<ul style="padding-left: 10px">';
								foreach (Role::getPermissionsByRole($value) as $permissionName => $permissionDescription)
								{
									$list .= $permissionDescription ? "<li>{$permissionDescription}</li>" : "<li>{$permissionName}</li>";
								}
								$list .= '</ul>';

								$helpIcon = Html::beginTag('span', [
									'title'        => UserManagementModule::t('back', 'Permessi per il ruolo - "{role}"',[
											'role'=>$label,
										]),
									'data-content' => $list,
									'data-html'    => 'true',
									'role'         => 'button',
									'style'        => 'margin-bottom: 5px; padding: 0 5px',
									'class'        => 'btn btn-sm btn-default role-help-btn',
								]);
								$helpIcon .= '?';
								$helpIcon .= Html::endTag('span');

								$isChecked = $checked ? 'checked' : '';
								$checkbox = "<label><input type='checkbox' name='{$name}' value='{$value}' {$isChecked}> {$label}</label>";

								return $helpIcon . ' ' . $checkbox;
							},
						'separator'=>'<br>',
					]
				) ?>
				<br/>

				<?php if ( Yii::$app->user->isSuperadmin OR Yii::$app->user->id != $user->id ): ?>

					<?= Html::submitButton(
						'<span class="glyphicon glyphicon-ok"></span> ' . UserManagementModule::t('back', 'Salva'),
						['class'=>'btn btn-primary btn-sm']
					) ?>
				<?php else: ?>
					<div class="alert alert-warning well-sm text-center">
						<?= UserManagementModule::t('back', 'Non puoi modificare i tuoi permessi') ?>
					</div>
				<?php endif; ?>


				<?= Html::endForm() ?>
			</div>
		</div>
	</div>

	<div class="col-sm-8">
		<div class="panel panel-default">
			<div class="panel-heading">
				<strong>
					<span class="glyphicon glyphicon-th"></span> <?= UserManagementModule::t('back', 'Permessi') ?>
				</strong>
			</div>
			<div class="panel-body">

				<div class="row">
					<?php foreach ($permissionsByGroup as $groupName => $permissions): ?>

						<div class="col-sm-6">
							<fieldset>
								<legend><?= $groupName ?></legend>

								<ul>
									<?php foreach ($permissions as $permission): ?>
										<li><?= $permission->description ?></li>
									<?php endforeach ?>
								</ul>
							</fieldset>

							<br/>
						</div>

					<?php endforeach ?>

				</div>

			</div>
		</div>
	</div>
</div>
    </div>
    </div>
    </div>
<?php
$this->registerJs(<<<JS

$('.role-help-btn').off('mouseover mouseleave')
	.on('mouseover', function(){
		var _t = $(this);
		_t.popover('show');
	}).on('mouseleave', function(){
		var _t = $(this);
		_t.popover('hide');
	});
JS
);
?>