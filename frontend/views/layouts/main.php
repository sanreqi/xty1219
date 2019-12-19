<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;

$this->registerCssFile('@web/static/css/weui.min.css?v=3');
$this->registerCssFile('@web/static/layui/css/layui.css',['position' => \yii\web\View::POS_HEAD]);

$this->registerJsFile('@web/static/js/jquery.min.js',['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('@web/static/js/function.js?v=1',['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('@web/static/layui/layui.all.js',['position' => \yii\web\View::POS_HEAD]);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body>
<?php $this->beginBody() ?>
<div style="padding-left: 5px; padding-right: 5px;" class="wx-container">
    <?= $content; ?>
    <?= $this->render('_footer') ?>
    <?= $this->context->renderPartial('/index/_message_dialog'); ?>
    <?= $this->context->renderPartial('/index/_toast'); ?>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
