<?php

    use webvimark\modules\UserManagement\components\GhostHtml;
    use webvimark\modules\UserManagement\components\GridView;
    use webvimark\modules\UserManagement\models\rbacDB\Role;
    use yii\helpers\Html;
    use yii\web\View;


/**
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var webvimark\modules\UserManagement\models\rbacDB\search\RoleSearch $searchModel
 * @var yii\web\View $this
 */

    $title='Gestione ruoli';
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
                'attribute'=>'description',
                'label'=>'Descrizione',
                'value'=>function(Role $model){
                    return Html::a($model->description, ['view', 'id'=>$model->name], ['data-pjax'=>0]);
                },
                'format'=>'raw',
            ],
            [
                'attribute'=>'name',
                'label'=>'Nome',
            ],
            [
                'class' => 'kartik\grid\ActionColumn',
                'headerOptions'=>['style'=>'min-width:120px; text-align:center;'],
                'contentOptions'=>['style'=>'width:70px; text-align:center;'],
                'template' => '{view} {delete}',
                'buttons'=>[
                    'view' => function($url, $model){
                        return Html::a('<i class="fa fa-eye"></i>', ['view','id'=>$model->name], [
                            'data'=>[
                                'pjax'=>0,
                                'toggle'=>'m-tooltip',
                                'title'=>'Visualizza'
                            ]
                        ]);
                    },
                    'update' => function($url, $model){
                        return Html::a('<i class="fa fa-edit"></i>', ['update','id'=>$model->name], [
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
                                'id' => $model->name,
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
                    'title' => Yii::t('yii', 'Aggiungi ruolo')
                ],
            ])
        ],
    ]),['class'=>$this->title .'-index']); ?>
<?php
    $js=<<<JS
    $(document).on('click','.deletebutton',function(e){
            e.preventDefault();
            id=$(this).data('id');
             swal.fire({
                title: 'Siete sicuri?',
                text: "Non sarà possibile annullare questa operazione!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Si, continua!',
                cancelButtonText: 'No, annulla!',
                reverseButtons: true
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