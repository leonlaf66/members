<?php $this->beginContent('@module/page/views/layouts/main.phtml')?>
<?php
$this->registerJsFile('https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js');
$this->registerCssFile('http://v3.bootcss.com/dist/css/bootstrap.min.css'); 

$t = \WS::lang('ucenter');
$c = $this->context;
$active = function($id) use ($c){
    echo $c->menuId === $id ? 'class="active"' : '';
};
?>

<?php echo \module\page\widgets\Nav::widget()?>

<div id="main">
    <div class="container">
        <?php foreach (Yii::$app->session->getAllFlashes() as $key => $message) { ?>
            <div class="alert alert-<?=$key?>" role="alert"><?=$message?></div>
        <?php } ?>
    </div>
</div>

<style type="text/css">
.sideleft>ul>li.active >a {
    color:#99bd2a;
}
</style>
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="sideleft">
                <h3><?php $t('Navigation Menus')?></h3>
                <ul>
                    <li <?php $active('account')?>>
                        <a href="/account/"><?php _tt('My Account', '帐户设置')?></a>
                    </li>
                    <li <?php $active('profile')?>>
                        <a href="/profile/"><?php _tt('Profile', '个人资料')?></a>
                    </li>
                    <li <?php $active('wishlist-rental')?>>
                        <a href="/rets/wishlist/"><?php $t('Wishlist(for Rental)')?></a>
                    </li>
                    <li <?php $active('wishlist-sell')?>>
                        <a href="/rets/wishlist/?type=2"><?php $t('Wishlist(for Sell)')?></a>
                    </li>
                    <li <?php $active('newsletter')?>>
                        <a href="/rets/newsletter/"><?php $t('Newsletter Notification')?></a>
                    </li>
                    <li <?php $active('schedule')?>>
                        <a href="/rets/schedule/"><?php $t('Schedule')?></a>
                    </li>
                    <!--
                    <li <?php $active('modify-password')?>>
                        <a href="/modify-password/"><?php _tt('Modify Password', '修改密码')?></a>
                    </li>
                    <li <?php $active('bind-phone')?>>
                        <a href="/bind-phone/"><?php _tt('Bind Phone Number', '绑定手机')?></a>
                    </li>-->
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