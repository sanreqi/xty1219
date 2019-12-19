<?php
$this->title = '修改密码';
//$this->registerJsFile('@web/js/user/login.js?v=7');
?>

<div class="page__bd" style="margin-top: 0;">
    <form id="password-form" method="post" class="weui-cells weui-cells_form" style="margin-top: 0;">
        <div class="weui-cell" style="margin-top: 0;">
            <div class="weui-cell__hd"><label class="weui-label">原密码</label></div>
            <div class="weui-cell__bd">
                <input name="old_password" autocomplete="off" class="weui-input" type="text" placeholder="请输入原密码"/>
            </div>
        </div>

        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">新密码</label></div>
            <div class="weui-cell__bd">
                <input autocomplete="off" type="password" name="new_password" class="weui-input" type="text" placeholder="请输入新密码"/>
            </div>
        </div>

        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">新密码确认</label></div>
            <div class="weui-cell__bd">
                <input autocomplete="off" type="password" name="confirm_password" class="weui-input" type="text" placeholder="请确认新密码"/>
            </div>
        </div>

        <div class="weui-btn-area">
            <button url="/site/modify-password" class="weui-btn weui-btn_primary" id="modify-password-btn">修改<i></i></button>
        </div>
    </form>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        bindSubmitForm("modify-password-btn", "password-form", {redirect_url: "/site/login"});
    });
</script>