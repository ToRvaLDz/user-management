<?php
    use webvimark\modules\UserManagement\UserManagementModule;
    use yii\bootstrap\BootstrapAsset;
    use yii\helpers\Html;
    use yii\web\View;


    /* @var $this View */
    /* @var $content string */


    $this->registerJs(
        <<<JS
WebFont.load({
            google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
          });

JS
        ,$this::POS_HEAD);

    $this->title= Yii::$app->id;
    BootstrapAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<!-- begin::Head -->
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!--    <link rel="shortcut icon" href="/theme/default/assets/demo/default/media/img/logo/favicon.ico" />
    -->    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <?php $this->head() ?>
</head>
<!-- end::Head -->
<?php echo $this->beginBody() ?>
<!-- begin::Body -->
<body class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  >
<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">
    <?php echo $content ?>
</div>
<!-- end:: Page -->
<?php $this->endBody(); ?>
</body>
<?php $this->endPage() ?>
<!-- end::Body -->
</html>



