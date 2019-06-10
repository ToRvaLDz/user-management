<?php
    use webvimark\modules\UserManagement\UserManagementModule;
    use yii\bootstrap\BootstrapAsset;
    use yii\helpers\Html;
    use yii\web\View;


    /* @var $this View */
    /* @var $content string */

    $this->title= Yii::$app->id;
    BootstrapAsset::register($this);
?>

<!-- Nuovo -->
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

    <script>
        WebFont.load({
            google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>
    <!--end::Fonts -->
    <?php $this->head() ?>


    <!--begin::Page Custom Styles(used by this page) --
    <link href="./assets/css/demo1/pages/general/login/login-2.css" rel="stylesheet" type="text/css" />
    !--end::Page Custom Styles --


    <link href="./assets/css/demo1/skins/header/base/light.css" rel="stylesheet" type="text/css" />
    <link href="./assets/css/demo1/skins/header/menu/light.css" rel="stylesheet" type="text/css" />
    <link href="./assets/css/demo1/skins/brand/dark.css" rel="stylesheet" type="text/css" />
    <link href="./assets/css/demo1/skins/aside/dark.css" rel="stylesheet" type="text/css" />
    !--end::Layout Skins -->

   <!-- <link rel="shortcut icon" href="./assets/media/logos/favicon.ico" />-->
</head>
<!-- end::Head -->
<?php echo $this->beginBody() ?>
<!-- begin::Body -->
<body  class="kt-page--loading-enabled kt-page--loading kt-page--fixed kt-header--fixed kt-header--minimize-topbar kt-header-mobile--fixed kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-subheader--enabled kt-subheader--transparent kt-page--loading"  >
<!-- begin:: Page -->
<?php echo $content ?>
<!-- end:: Page -->
<?php $this->endBody(); ?>
</body>
<!-- begin::Global Config(global config for global JS sciprts) -->
<?php $this->endPage() ?>
<!-- end::Global Config -->
</html>

