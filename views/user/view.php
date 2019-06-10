<?php

use webvimark\modules\UserManagement\components\GhostHtml;
use webvimark\modules\UserManagement\models\rbacDB\Role;
use webvimark\modules\UserManagement\models\User;
use webvimark\modules\UserManagement\UserManagementModule;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var webvimark\modules\UserManagement\models\User $model
 */


	$title="Utente : " . $model->username;
	$icon="flaticon-user-add";
	$subtitle='';

	$this->title = (!empty($subtitle) ? $subtitle : $title). ' @ ' . yii::$app->id;
	$this->params['breadcrumbs'][] = ['label' => UserManagementModule::t('back', 'Users'), 'url' => ['index']];
	$this->params['breadcrumbs'][] = (!empty($subtitle) ? $subtitle : $title);
?>
<div class="user-edit">
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
													<?= GhostHtml::a(
														'<i class="m-nav__link-icon fa fa-plus"></i>
                                                        <span class="m-nav__link-text">
                                                            
                                                                Aggiungi nuovo utente
                                                            </span>',
														['create'],
														['class' => 'm-nav__link']
													) ?>
                                                </li>
                                                <li class="m-nav__item">
													<?= GhostHtml::a(
														'<i class="m-nav__link-icon fa	fa-edit"></i>
                                                        <span class="m-nav__link-text">
                                                               Modifica utente
                                                            </span>',
														['update', 'id' => $model->id],
														['class' => 'm-nav__link']
													) ?>
                                                </li>
                                                <li class="m-nav__item">
	                                                <?= GhostHtml::a('<i class="m-nav__link-icon fa fa-remove"></i>
                                                        <span class="m-nav__link-text">Elimina utente</span>', ['#'], [
		                                                'class' => 'm-nav__link deletebutton',
		                                                'data' => [
                                                            'id' => $model->id
		                                                ],
	                                                ]) ?>
                                                </li>
                                                <li class="m-nav__separator m-nav__separator--fit"></li>
                                                <li class="m-nav__item">
	                                                <?= GhostHtml::a('<i class="m-nav__link-icon fa fa-gear"></i>
                                                        <span class="m-nav__link-text">Ruoli e permessi</span>',
		                                                ['/user-management/user-permission/set', 'id'=>$model->id],
		                                                ['class' => 'm-nav__link']
	                                                ) ?>
                                                </li><li class="m-nav__item">
	                                                <?= GhostHtml::a('<i class="m-nav__link-icon fa fa-map-marker"></i>
                                                        <span class="m-nav__link-text">Gestione clienti/porti</span>',
		                                                ['porti','id'=>$model->id],
		                                                ['class' => 'm-nav__link']
	                                                ) ?>
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
			<?= DetailView::widget([
				'model'      => $model,
				'attributes' => [
					'id',
					[
						'attribute'=>'status',
						'value'=>User::getStatusValue($model->status),
					],
					'username',
					[
						'attribute'=>'email',
						'value'=>$model->email,
						'format'=>'email',
						'visible'=>User::hasPermission('viewUserEmail'),
					],
					[
						'attribute'=>'email_confirmed',
						'value'=>$model->email_confirmed,
						'format'=>'boolean',
						'visible'=>User::hasPermission('viewUserEmail'),
					],
					[
						'label'=>UserManagementModule::t('back', 'Roles'),
						'value'=>implode('<br>', ArrayHelper::map(Role::getUserRoles($model->id), 'name', 'description')),
						'visible'=>User::hasPermission('viewUserRoles'),
						'format'=>'raw',
					],
					[
						'attribute'=>'bind_to_ip',
						'visible'=>User::hasPermission('bindUserToIp'),
					],
					array(
						'attribute'=>'registration_ip',
						'value'=>Html::a($model->registration_ip, "http://ipinfo.io/" . $model->registration_ip, ["target"=>"_blank"]),
						'format'=>'raw',
						'visible'=>User::hasPermission('viewRegistrationIp'),
					),
					'created_at:datetime',
					'updated_at:datetime',
				],
			]) ?>

		</div>
	</div>
</div>

<?php
	$js=<<<JS
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


   
JS;

	$this->registerJs($js, View::POS_READY);