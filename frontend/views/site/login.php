<?php
$this->title = '登录';
//$this->registerJsFile('@web/js/user/login.js?v=7');
?>

<div class="page__bd" style="margin-top: 0;">
    <form id="login-form" method="post" class="weui-cells weui-cells_form" style="margin-top: 0;">
        <div class="weui-cell" style="margin-top: 0;">
            <div class="weui-cell__hd"><label class="weui-label">用户名</label></div>
            <div class="weui-cell__bd">
                <input name="username" autocomplete="off" class="weui-input" type="text" placeholder="请输入用户名"/>
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">密码</label></div>
            <div class="weui-cell__bd">
                <input autocomplete="off" type="password" name="password" class="weui-input" type="text" placeholder="请输入密码"/>
            </div>
        </div>
        <div class="weui-btn-area">
            <button url="/site/login" class="weui-btn weui-btn_primary" id="login-btn">登录<i></i></button>
        </div>
    </form>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        bindSubmitForm("login-btn", "login-form", {redirect_url: "/report/index"});
    });
</script>