<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/static/bootstrap-3.3.7/css/bootstrap.css?v=3">
    <link rel="stylesheet" href="/static/css/login.css?v=1">
    <link rel="stylesheet" href="/static/layui/css/layui.css">

    <script type="text/javascript" src="/static/js/jquery.min.js"></script>
    <script type="text/javascript" src="/static/layui/layui.all.js"></script>


    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>登录</title>
</head>
<body>

<div>
    <div class="be-content pren">
        <div class="ioc_text">
            <img src="" alt="">
            <span id="login-title">请登录您的用户</span>
        </div>
        <div>
            <form id="login-form" action="">
                <div class="br-content">
                    <div class="input-group bootint" style="margin-bottom: 1.5rem">
                        <span class="input-group-addon glyphicon glyphicon-user"></span>
                        <input name="LoginForm[username]" type="text" class="form-control" placeholder="Username" aria-describedby="basic-addon1">
                    </div>
                    <div class="input-group bootint" style="margin-bottom: 1.5rem">
                        <span class="input-group-addon glyphicon glyphicon-lock"></span>
                        <input name="LoginForm[password]" type="password" class="form-control" placeholder="Password" aria-describedby="basic-addon1">
                    </div>
                    <div style="padding-top: 10px">
                        <input class="btn login-btn" type="button" value="登录">
                    </div>
                    <div class="be-con">
                        <span>Copyright © 2018 - 2019 <a href="">系统登陆</a></span>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

</body>

<script>
    $(".login-btn").click(function () {
        var form_data = $("#login-form").serialize();
        $.ajax({
            url: "/site/login-ajax",
            type: "post",
            dataType: "json",
            data: form_data,
            success: function(data) {
                if (data.status == 1) {
                    //@todo
                    window.location.href = "/admin-user/index"
                    // layer.alert('成功')
                } else {
                    layer.alert(data.errorMsg)
                }
            }
        });
        return false;
    });
</script>
</html>

