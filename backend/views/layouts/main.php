<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;

$this->registerCssFile('@web/static/layui/css/layui.css',['position' => \yii\web\View::POS_HEAD]);
$this->registerCssFile('@web/static/css/common.css?v=4',['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('@web/static/js/jquery.min.js',['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('@web/static/layui/layui.js?v=1',['position' => \yii\web\View::POS_HEAD]);

//$this->registerJsFile('@web/static/layui/layui.all.js',['position' => \yii\web\View::POS_HEAD]);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php if (!Yii::$app->user->isGuest): ?>
        <!--导航-->
        <?= $this->context->renderPartial('/layouts/_nav', ['content' => $content]); ?>

    <?php else: ?>

    <?php endif; ?>

<!--    <div class="xty-container">-->
<!--        --><?//= $content ?>
<!--    </div>-->
</div>

<footer class="footer">

</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

