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
     * @var webvimark\modules\UserManagement\models\search\UserVisitLogSearch $searchModel
     */

    $title=UserManagementModule::t('back', 'Visit log');
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
                'attribute'=>'user_id',
                'value'=>function($model){
                    return Html::a(@$model->user->username, ['view', 'id'=>$model->id], ['data-pjax'=>0]);
                },
                'format'=>'raw',
            ],
            'language',
            'os',
            'browser',
            [
                'attribute'=>'ip',
                'value'=>function($model){
                    return Html::a($model->ip, "http://ipinfo.io/" . $model->ip, ["target"=>"_blank"]);
                },
                'format'=>'raw',
            ],
            'visit_time:datetime',
            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{view}',
                'contentOptions'=>['style'=>'width:70px; text-align:center;'],
                'buttons'=>[
                    'view' => function($url, $model){
                        return Html::a('<i class="fa fa-eye"></i>', ['view','id'=>$model->id], [
                            'data'=>[
                                'pjax'=>0,
                                'toggle'=>'m-tooltip',
                                'title'=>'Visualizza'
                            ]
                        ]);
                    },
                ]
            ],
        ],
        'panel' => [
            'headTitle' => $this->title,
            'type' => 'brand',
            'icon'=> 'flaticon-layers',
            'footer'=>false,
            'headTools'=> false
        ],
    ]),['class'=>$this->title .'-index']);
