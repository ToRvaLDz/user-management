<?php
/**
 * @var yii\widgets\ActiveForm $form
 * @var array $childRoles
 * @var array $allRoles
 * @var array $routes
 * @var array $currentRoutes
 * @var array $permissionsByGroup
 * @var array $currentPermissions
 * @var yii\rbac\Role $role
 */

use webvimark\modules\UserManagement\components\GhostHtml;
use webvimark\modules\UserManagement\models\rbacDB\Role;
use webvimark\modules\UserManagement\UserManagementModule;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

	$title=UserManagementModule::t('back', 'Permessi per il ruolo:') . ' '. $role->description;
	$icon="flaticon-users";
	$subtitle='';

$this->title = $title;
$this->params['breadcrumbs'][] = ['label' => UserManagementModule::t('back', 'Ruoli'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php if ( Yii::$app->session->hasFlash('success') ): ?>
    <div class="alert alert-success text-center">
		<?= Yii::$app->session->getFlash('success') ?>
    </div>
<?php endif; ?>


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
        <div class="m-portlet__head-tools">
            <ul class="m-portlet__nav">
                <li class="m-portlet__nav-item">
                    <div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" data-dropdown-toggle="hover" aria-expanded="true">
                        <a href="#" class="m-portlet__nav-link m-portlet__nav-link--icon m-portlet__nav-link--icon-xl m-dropdown__toggle">
                            <i class="la la-plus m--hide"></i>
                            <i class="la la-ellipsis-h m--font-brand"></i>
                        </a>
                        <div class="m-dropdown__wrapper">
                            <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                            <div class="m-dropdown__inner">
                                <div class="m-dropdown__body">
                                    <div class="m-dropdown__content">
                                        <ul class="m-nav">
                                            <li class="m-nav__section m-nav__section--first">
                                                <span class="m-nav__section-text">
                                                    Azioni
                                                </span>
                                            </li>
                                            <li class="m-nav__item">
												<?= GhostHtml::a('<i class="m-nav__link-icon fa fa-plus"></i>
                                                        <span class="m-nav__link-text">
                                                                Aggiungi nuovo ruolo
                                                            </span>',
													['create'],
													['class' => 'm-nav__link']
												) ?>
                                            </li>
                                            <li class="m-nav__item">
												<?= GhostHtml::a('<i class="m-nav__link-icon fa fa-edit"></i>
                                                        <span class="m-nav__link-text">
                                                                Modifica ruolo
                                                            </span>',
													['update', 'id' => $role->name],
													['class' => 'm-nav__link']
												) ?>
                                            </li>
                                            <li class="m-nav__item">
												<?= GhostHtml::a('<i class="m-nav__link-icon fa fa-remove"></i>
                                                        <span class="m-nav__link-text">
                                                                Elimina ruolo
                                                            </span>',
													['#'],
													[
                                                        'class' => 'm-nav__link deletebutton',
														'data' => [
															'id' => $role->name
														],
                                                    ]
												) ?>
                                            </li>
                                            <li class="m-nav__separator m-nav__separator--fit m--hide"></li>
                                            <li class="m-nav__item m--hide">
                                                <a href="#" class="btn btn-outline-danger m-btn m-btn--pill m-btn--wide btn-sm">
                                                    Submit
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="m-portlet__body">
        <div class="row">
            <div class="col-sm-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>
                            <span class="glyphicon glyphicon-th"></span> <?= UserManagementModule::t('back', 'Ruoli figli') ?>
                        </strong>
                    </div>
                    <div class="panel-body">
                        <?= Html::beginForm(['set-child-roles', 'id'=>$role->name]) ?>

                        <?= Html::checkboxList(
                            'child_roles',
                            ArrayHelper::map($childRoles, 'name', 'name'),
                            ArrayHelper::map($allRoles, 'name', 'description'),
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
                                'separator'=>'<br>'
                            ]
                        ) ?>

                        <hr/>
                        <?= Html::submitButton(
                            '<span class="glyphicon glyphicon-ok"></span> ' . UserManagementModule::t('back', 'Salva'),
                            ['class'=>'btn btn-primary btn-sm']
                        ) ?>

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
                        <?= Html::beginForm(['set-child-permissions', 'id'=>$role->name]) ?>

                        <div class="row">
                            <?php foreach ($permissionsByGroup as $groupName => $permissions): ?>
                                <div class="col-sm-6">
                                    <fieldset>
                                        <legend><?= $groupName ?></legend>

                                        <?= Html::checkboxList(
                                            'child_permissions',
                                            ArrayHelper::map($currentPermissions, 'name', 'name'),
                                            ArrayHelper::map($permissions, 'name', 'description'),
                                            ['separator'=>'<br>']
                                        ) ?>
                                    </fieldset>
                                    <br/>
                                </div>


                            <?php endforeach ?>
                        </div>

                        <hr/>
                        <?= Html::submitButton(
                            '<span class="glyphicon glyphicon-ok"></span> ' . UserManagementModule::t('back', 'Salva'),
                            ['class'=>'btn btn-primary btn-sm']
                        ) ?>

                        <?= Html::endForm() ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

<?php
$this->registerJs(<<<JS

$('.deletebutton').on('click',function(e){
            e.preventDefault();
            id=$(this).data('id');
            swal({
                title: 'Siete sicuri?',
                text: "Non sarà possibile annullare questa operazione!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Si, cancella!',
                cancelButtonText: 'No, annulla!',
                reverseButtons: true,
                animation: false, 
                customClass: 'animated tada'
            }).then(function(result){
                if (result.value) {
                     mApp.blockPage({
                        overlayColor: '#000000',
                        type: 'loader',
                        state: 'success',
                        message: 'Attendere...'
                    });
                    jQuery.ajax({
                        url: 'delete?id=' + id,
                        type: 'GET',
                        success: function() {
                            mApp.unblockPage();
                            swal("Ok","Operazione eseguita correttamente","success")
                            .then(function(){
                                document.location.href='index';
                            });
                        },
                        error: function() {
                            mApp.unblockPage();
                            swal("Attenzione","Non è stato possibile eliminare la riga","error");
                            
                        }
                    });
                } else if (result.dismiss === 'cancel') {
                    swal(
                        'Annullato',
                        'L\'operazione è stata annullata',
                        'error'
                    )
                }
            });
        });

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