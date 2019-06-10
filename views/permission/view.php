<?php
/**
 * @var $this yii\web\View
 * @var yii\widgets\ActiveForm $form
 * @var array $routes
 * @var array $childRoutes
 * @var array $permissionsByGroup
 * @var array $childPermissions
 * @var yii\rbac\Permission $item
 */

use webvimark\modules\UserManagement\components\GhostHtml;
use webvimark\modules\UserManagement\UserManagementModule;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
$icon="flaticon-user-settings";
$subtitle='';
$this->title = UserManagementModule::t('back', 'Settings for permission') . ': ' . $item->description;
$this->params['breadcrumbs'][] = ['label' => UserManagementModule::t('back', 'Permissions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php if ( Yii::$app->session->hasFlash('success') ): ?>
	<div class="alert alert-success text-center">
		<?= Yii::$app->session->getFlash('success') ?>
	</div>
<?php endif; ?>

<div class="permission-view">
    <div class="m-portlet m-portlet--mobile">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                    <i class="<?= $icon ?>"></i> <?= Html::encode($this->title) ?>
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
                                                        <span class="m-nav__link-text">'.
			                                        UserManagementModule::t('back', 'Create permission') .
			                                        '</span>',
			                                        ['create'],
			                                        ['class' => 'm-nav__link']
		                                        ) ?>
                                            </li>
                                            <li class="m-nav__item">
												<?= GhostHtml::a(
													'<i class="m-nav__link-icon fa fa-edit"></i>
                                                        <span class="m-nav__link-text">'.
                                                                UserManagementModule::t('back', 'Edit permission') .
                                                            '</span>',
													['update', 'id' => $item->name],
													['class' => 'm-nav__link']
												) ?>
                                            </li>
                                            <li class="m-nav__item">
		                                        <?= GhostHtml::a('<i class="m-nav__link-icon fa fa-remove"></i>
                                                        <span class="m-nav__link-text">
                                                                Elimina permesso
                                                            </span>',
			                                        ['#'],
			                                        [
				                                        'class' => 'm-nav__link deletebutton',
				                                        'data' => [
					                                        'id' => $item->name
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
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>
                            <span class="glyphicon glyphicon-th"></span> <?= UserManagementModule::t('back', 'Child permissions') ?>
                        </strong>
                    </div>
                    <div class="panel-body">

                        <?= Html::beginForm(['set-child-permissions', 'id'=>$item->name]) ?>

                        <div class="row">
                            <?php foreach ($permissionsByGroup as $groupName => $permissions): ?>
                                <div class="col-sm-6">
                                    <fieldset>
                                        <legend><?= $groupName ?></legend>

                                        <?= Html::checkboxList(
                                            'child_permissions',
                                            ArrayHelper::map($childPermissions, 'name', 'name'),
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
                            '<span class="glyphicon glyphicon-ok"></span> ' . UserManagementModule::t('back', 'Save'),
                            ['class'=>'btn btn-primary btn-sm']
                        ) ?>

                        <?= Html::endForm() ?>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>
                            <span class="glyphicon glyphicon-th"></span> <?= UserManagementModule::t('back', 'Routes') ?>

                            <?= Html::a(
                                UserManagementModule::t('back', 'Refresh routes'),
                                ['refresh-routes', 'id'=>$item->name],
                                [
                                    'class' => 'btn btn-default btn-sm pull-right',
                                    'style'=>'margin-top:-5px',
                                ]
                            ) ?>

                        </strong>
                    </div>

                    <div class="panel-body">

                        <?= Html::beginForm(['set-child-routes', 'id'=>$item->name]) ?>

                        <div class="row">
                            <div class="col-sm-3">
                                <?= Html::submitButton(
                                    '<span class="glyphicon glyphicon-ok"></span> ' . UserManagementModule::t('back', 'Save'),
                                    ['class'=>'btn btn-primary btn-sm']
                                ) ?>
                            </div>

                            <div class="col-sm-6">
                                <input id="search-in-routes" autofocus="on" type="text" class="form-control input-sm" placeholder="<?= UserManagementModule::t('back', 'Search routes') ?>">
                            </div>

                            <div class="col-sm-3 text-right">
                                <span id="show-only-selected-routes" class="btn btn-default btn-sm">
                                    <i class="fa fa-minus"></i> <?= UserManagementModule::t('back', 'Show only selected') ?>
                                </span>
                                <span id="show-all-routes" class="btn btn-default btn-sm hide">
                                    <i class="fa fa-plus"></i> <?= UserManagementModule::t('back', 'Show all') ?>
                                </span>

                            </div>
                        </div>

                        <hr/>

                        <?= Html::checkboxList(
                            'child_routes',
                            ArrayHelper::map($childRoutes, 'name', 'name'),
                            ArrayHelper::map($routes, 'name', 'name'),
                            [
                                'id'=>'routes-list',
                                'separator'=>'<div class="separator"></div>',
                                'item'=>function($index, $label, $name, $checked, $value) {
                                        return Html::checkbox($name, $checked, [
                                            'value' => $value,
                                            'label' => '<span class="route-text">' . $label . '</span>',
                                            'labelOptions'=>['class'=>'route-label'],
                                            'class'=>'route-checkbox',
                                        ]);
                                },
                            ]
                        ) ?>

                        <hr/>
                        <?= Html::submitButton(
                            '<span class="glyphicon glyphicon-ok"></span> ' . UserManagementModule::t('back', 'Save'),
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
$js = <<<JS

var routeCheckboxes = $('.route-checkbox');
var routeText = $('.route-text');

// For checked routes
var backgroundColor = '#D6FFDE';

function showAllRoutesBack() {
	$('#routes-list').find('.hide').each(function(){
		$(this).removeClass('hide');
	});
}

//Make tree-like structure by padding controllers and actions
routeText.each(function(){
	var _t = $(this);

	var chunks = _t.html().split('/').reverse();
	var margin = chunks.length * 40 - 40;

	if ( chunks[0] == '*' )
	{
		margin -= 40;
	}

	_t.closest('label').css('margin-left', margin);

});

// Highlight selected checkboxes
routeCheckboxes.each(function(){
	var _t = $(this);

	if ( _t.is(':checked') )
	{
		_t.closest('label').css('background', backgroundColor);
	}
});

// Change background on check/uncheck
routeCheckboxes.on('change', function(){
	var _t = $(this);

	if ( _t.is(':checked') )
	{
		_t.closest('label').css('background', backgroundColor);
	}
	else
	{
		_t.closest('label').css('background', 'none');
	}
});


// Hide on not selected routes
$('#show-only-selected-routes').on('click', function(){
	$(this).addClass('hide');
	$('#show-all-routes').removeClass('hide');

	routeCheckboxes.each(function(){
		var _t = $(this);

		if ( ! _t.is(':checked') )
		{
			_t.closest('label').addClass('hide');
			_t.closest('div.separator').addClass('hide');
		}
	});
});

// Show all routes back
$('#show-all-routes').on('click', function(){
	$(this).addClass('hide');
	$('#show-only-selected-routes').removeClass('hide');

	showAllRoutesBack();
});

// Search in routes and hide not matched
$('#search-in-routes').on('change keyup', function(){
	var input = $(this);

	if ( input.val() == '' )
	{
		showAllRoutesBack();
		return;
	}

	routeText.each(function(){
		var _t = $(this);

		if ( _t.html().indexOf(input.val()) > -1 )
		{
			_t.closest('label').removeClass('hide');
			_t.closest('div.separator').removeClass('hide');
		}
		else
		{
			_t.closest('label').addClass('hide');
			_t.closest('div.separator').addClass('hide');
		}
	});
});

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

$this->registerJs($js);
?>