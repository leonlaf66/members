<?php $this->beginContent('@module/page/views/layouts/main.phtml')?>
<?php
$this->registerJsFile('https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js');
$this->registerCssFile('http://v3.bootcss.com/dist/css/bootstrap.min.css'); 

$t = \WS::lang('ucenter');
?>

<?php echo \module\page\widgets\Nav::widget()?>

<div id="main">
    <div class="container">
        <?php foreach (Yii::$app->session->getAllFlashes() as $key => $message) { ?>
            <div class="alert alert-<?=$key?>" role="alert"><?=$message?></div>
        <?php } ?>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="sideleft">
                <h3><?php $t('Navigation Menus')?></h3>
                <ul>
                    <li><a href="/umember/profile/"><?php $t('Profile')?></a></li>
                    <li><a href="/umember/wishlist/"><?php $t('Wishlist(for Rental)')?></a></li>
                    <li><a href="/umember/wishlist/?type=2"><?php $t('Wishlist(for Sell)')?></a></li>
                    <li><a href="/umember/rets-newsletter/"><?php $t('Newsletter Notification')?></a></li>
                    <li><a href="/umember/schedule/"><?php $t('Schedule')?></a></li>
                    <li><a href="/umember/account/"><?php $t('Account')?></a></li>
                </ul>
            </div>
        </div>
        <div class="col-md-9">
            <div class="sidemain">
                <?php echo $content?>
            </div>
        </div>
    </div>
</div>

<?php $this->endContent()?>