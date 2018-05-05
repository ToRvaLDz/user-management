<?php
use webvimark\extensions\GridPageSize\GridPageSize;
use webvimark\modules\UserManagement\components\GhostHtml;
use webvimark\modules\UserManagement\models\rbacDB\AuthItemGroup;
use webvimark\modules\UserManagement\models\rbacDB\Permission;
use webvimark\modules\UserManagement\UserManagementModule;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;


/**
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var webvimark\modules\UserManagement\models\rbacDB\search\PermissionSearch $searchModel
 * @var yii\web\View $this
 */
	$title='Gestione permessi';
	$icon="flaticon-user-settings";
	$subtitle='';

	$this->title = (!empty($subtitle) ? $subtitle : $title). ' @ ' . yii::$app->id;
	$this->params['breadcrumbs'][] = (!empty($subtitle) ? $subtitle : $title);

?>
<div class="permission-index">
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
														'<i class="m-nav__link-icon fa fa-gear"></i>
                                                        <span class="m-nav__link-text">
                                                                Aggiungi permesso
                                                            </span>',
														['create'],
														['class' => 'm-nav__link']
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
    		<?= GridView::widget([
			'id'=>'permission-grid',
			'pjax'=>true,
			'dataProvider' => $dataProvider,
			'filterModel' => $searchModel,
            'responsive' => true,
            'perfectScrollbar' => false,
            'condensed' => false,
            'floatHeader' => false,
            'bordered' => true,
            'striped'=>true,
            'hover' => true,
            'persistResize'=>false,
            'tableOptions' => ['class'=>'m-datatable__table'],
            'headerRowOptions' => ['class'=>'m-datatable__row'],
            'rowOptions' => ['class'=>'m-datatable__row'],
            'columns' => [
				['class' => 'yii\grid\SerialColumn', 'options'=>['style'=>'width:10px'] ],

				[
					'attribute'=>'description',
					'label'=>'Descrizione',
					'value'=>function($model){
							if ( $model->name == Yii::$app->getModule('user-management')->commonPermissionName )
							{
								return Html::a(
									$model->description,
									['view', 'id'=>$model->name],
									['data-pjax'=>0, 'class'=>'label label-primary']
								);
							}
							else
							{
								return Html::a($model->description, ['view', 'id'=>$model->name], ['data-pjax'=>0]);
							}
						},
					'format'=>'raw',
				],
                [
	                'attribute'=>'name',
                    'label'=>'Nome',
                ],
				[
					'attribute'=>'group_code',
                    'label'=>'Codice',
					'filter'=>ArrayHelper::map(AuthItemGroup::find()->asArray()->all(), 'code', 'name'),
					'value'=>function(Permission $model){
							return $model->group_code ? $model->group->name : '';
						},
				],

				[
					'class' => 'kartik\grid\ActionColumn',
					'contentOptions'=>['style'=>'width:70px; text-align:center;'],
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
						'delete' => function($url, $model){
							return Html::a('<i class="fa fa-trash-o"></i>', '#', [
								'class'=>['deletebutton'],
								'data' => [
									'name' => $model->name,
									'toggle'=>'m-tooltip',
									'title' =>'Elimina'
								],
							]);
						}
					]
                ]
			],
			    'panel' => [
				    'heading' => '',
				    'type' => 'info',
				    'before' =>' <a href="/' . Yii::$app->request->getPathInfo() .'" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                            <span>
                                <i class="la la-times-circle-o"></i>
                                <span>
                                    Rimuovi filtri
                                </span>
                            </span>
                        </a>',
				    'after' => ' <a href="/' . Yii::$app->request->getPathInfo() .'" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                            <span>
                                <i class="la la-times-circle-o"></i>
                                <span>
                                    Rimuovi filtri
                                </span>
                            </span>
                        </a>',
				    'showFooter' => false
			    ],
            'panelTemplate'=>'<div class="panel {type}">
                    {panelBefore}
                    {panelHeading}
                    {items}
                    {panelFooter}
                    {panelAfter}
                </div>',
            'toolbar'=>[],
            'panelHeadingTemplate' => '
                        {heading}
                        {pager}
                    <div class="m-datatable__pager-info">
                        {summary}
                    </div>
                    <div class="clearfix"></div>',
            'panelFooterTemplate' => '
                        {pager}
                    
                    <div class="m-datatable__pager-info">
                        {summary}
                    </div>
                    <div class="clearfix"></div>
                    '
		]); ?>
        </div>
    </div>
</div>

<?php
	$js=<<<JS

    function initPage(){
        
        $('.deletebutton').on('click',function(e){
            e.preventDefault();
            id=$(this).data('name');
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
                            $.pjax.reload({container:'#permission-grid-pjax'});
                            swal("Ok","Operazione eseguita correttamente","success");
                            
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

        mApp.initTooltips();
    }
    
    initPage();
    
    $('#permission-grid-pjax')
    .on('pjax:end',   function() {
        initPage();
    });
JS;

	$this->registerJs($js,\yii\web\View::POS_READY);