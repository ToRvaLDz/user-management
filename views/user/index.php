<?php

    use webvimark\modules\UserManagement\components\GhostHtml;
    use webvimark\modules\UserManagement\components\GridView;
    use webvimark\modules\UserManagement\models\rbacDB\Role;
    use webvimark\modules\UserManagement\models\User;
    use webvimark\modules\UserManagement\UserManagementModule;
    use yii\data\ActiveDataProvider;
    use yii\helpers\Html;
    use yii\helpers\ArrayHelper;
    use yii\helpers\Url;
    use yii\web\View;


    /**
     * @var yii\web\View $this
     * @var yii\data\ActiveDataProvider $dataProvider
     * @var webvimark\modules\UserManagement\models\search\UserSearch $searchModel
     */

    $title='Gestione utenti';
    $icon="flaticon-users";
    $subtitle='';

    $this->title = (!empty($subtitle) ? $subtitle : $title). ' @ ' . yii::$app->id;
    $this->params['breadcrumbs'][] = (!empty($subtitle) ? $subtitle : $title);

    echo Html::tag('div', GridView::widget([
        'id'=>'user-grid',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn', 'options'=>['style'=>'width:10px'] ],
            [
                'class'=>'webvimark\components\StatusColumn',
                'label'=>'Amministratore',
                'attribute'=>'superadmin',
                'visible'=>Yii::$app->user->isSuperadmin,
            ],

            [
                'attribute'=>'username',
                'label'=>'Nome utente',
                'value'=>function(User $model){
                    return Html::a($model->username,['view', 'id'=>$model->id],['data-pjax'=>0]);
                },
                'format'=>'raw',
            ],
            [
                'attribute'=>'email',
                'format'=>'raw',
                'visible'=>User::hasPermission('viewUserEmail'),
            ],
            [
                'attribute'=>'gridRoleSearch',
                'label'=>'Ruolo',
                'filter'=>ArrayHelper::map(Role::getAvailableRoles(Yii::$app->user->isSuperAdmin),'name', 'description'),
                'value'=>function(User $model){
                    return implode(', ', ArrayHelper::map($model->roles, 'name', 'description'));
                },
                'format'=>'raw',
                'visible'=>User::hasPermission('viewUserRoles'),
            ],
            [
                'value'=>function(User $model){
                    return GhostHtml::a(
                        UserManagementModule::t('back', 'Ruoli e permessi'),
                        ['/user-management/user-permission/set', 'id'=>$model->id],
                        ['class'=>'btn btn-sm btn-primary', 'data-pjax'=>0]);
                },
                'format'=>'raw',
                'visible'=>User::canRoute('/user-management/user-permission/set'),
                'options'=>[
                    'width'=>'10px',
                ],
            ],
            [
                'value'=>function(User $model){
                    return GhostHtml::a(
                        UserManagementModule::t('back', 'Cambia password'),
                        ['change-password', 'id'=>$model->id],
                        ['class'=>'btn btn-sm btn-default', 'data-pjax'=>0]);
                },
                'format'=>'raw',
                'options'=>[
                    'width'=>'10px',
                ],
            ],
            [
                'class'=>'webvimark\components\StatusColumn',
                'label'=>'Stato',
                'attribute'=>'status',
                'optionsArray'=>[
                    [User::STATUS_ACTIVE, UserManagementModule::t('back', 'Attivo'), 'success'],
                    [User::STATUS_INACTIVE, UserManagementModule::t('back', 'Inattivo'), 'warning'],
                    [User::STATUS_BANNED, UserManagementModule::t('back', 'Bannato'), 'danger'],
                ],
            ],
            [
                'class' => 'kartik\grid\ActionColumn',
                'headerOptions'=>['style'=>'min-width:120px; text-align:center;'],
                'contentOptions'=>['style'=>'width:70px; text-align:center;'],
                'buttons'=>[
                    'view' => function($url, $model){
                        return Html::a('<i class="fa fa-eye"></i>', ['view','id'=>$model->ID], [
                            'data'=>[
                                'pjax'=>0,
                                'toggle'=>'m-tooltip',
                                'title'=>'Visualizza'
                            ]
                        ]);
                    },
                    'update' => function($url, $model){
                        return Html::a('<i class="fa fa-edit"></i>', ['update','id'=>$model->ID], [
                            'data'=>[
                                'pjax'=>0,
                                'toggle'=>'m-tooltip',
                                'title'=>'Visualizza'
                            ]
                        ]);
                    },
                    'delete' => function($url, $model){
                        return Html::a('<i class="fa fa-trash"></i>', '#', [
                            'class'=>['deletebutton'],
                            'data' => [
                                'id' => $model->ID,
                                'toggle'=>'m-tooltip',
                                'title' =>'Elimina'
                            ],
                        ]);
                    }
                ]
            ],
        ],
        'panel' => [
            'headTitle' => $this->title,
            'type' => 'brand',
            'icon'=> 'flaticon-layers',
            'footer'=>false,
            'headTools'=>  GhostHtml::a('<i class="la la-plus"></i>',['create'], [
                'class'=>['view-button btn btn-sm btn-icon btn-warning btn-icon-md'],
                'data' => [
                    'placement'=>'left',
                    'pjax'=>0,
                    'toggle'=>'kt-tooltip',
                    'title' => Yii::t('yii', 'Nuovo Utente')
                ],
            ])
        ],
    ]),['class'=>$this->title .'-index']); ?>
<?php
    $js=<<<JS
    $(document).on('.deletebutton','click',function(e){
            e.preventDefault();
            id=$(this).data('id');
            swal.fire({
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
                     KTApp.blockPage({
                        overlayColor: '#000000',
                        type: 'loader',
                        state: 'success',
                        message: 'Attendere...'
                    });
                    jQuery.ajax({
                        url: 'delete?id=' + id,
                        type: 'GET',
                        success: function() {
                            KTApp.unblockPage();
                            $.pjax.reload({container:'#user-grid-pjax'});
                        },
                        error: function() {
                            KTApp.unblockPage();
                            $.pjax.reload({container:'#user-grid-pjax'});
                        }
                    });
                } else if (result.dismiss === 'cancel') {
                    swal.fire(
                        'Annullato',
                        'L\'operazione è stata annullata',
                        'error'
                    )
                }
            });
        });
    KTApp.initTooltips();
JS;

    $this->registerJs($js, View::POS_READY);