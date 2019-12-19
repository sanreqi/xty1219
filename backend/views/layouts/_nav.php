<?php

?>
<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
    <div class="layui-header">
        <div class="layui-logo">xty控制台</div>
        <!-- 头部区域（可配合layui已有的水平导航） -->
        <ul class="layui-nav layui-layout-left">
            <li class="layui-nav-item"><a href="">控制台</a></li>
<!--            <li class="layui-nav-item"><a href="">商品管理</a></li>-->
<!--            <li class="layui-nav-item"><a href="">用户</a></li>-->
<!--            <li class="layui-nav-item">-->
<!--                <a href="javascript:;">其它系统</a>-->
<!--                <dl class="layui-nav-child">-->
<!--                    <dd><a href="">邮件管理</a></dd>-->
<!--                    <dd><a href="">消息管理</a></dd>-->
<!--                    <dd><a href="">授权管理</a></dd>-->
<!--                </dl>-->
<!--            </li>-->
        </ul>
        <ul class="layui-nav layui-layout-right">
            <li class="layui-nav-item">
                <a href="javascript:;">
                    <img src="http://t.cn/RCzsdCq" class="layui-nav-img">
                    贤心
                </a>
                <dl class="layui-nav-child">
                    <dd><a href="">个人信息</a></dd>

<!--                    <dd><a href="">安全设置</a></dd>-->
                </dl>
            </li>
            <li class="layui-nav-item"><a href="">退出登录</a></li>
        </ul>
    </div>

    <div class="layui-side layui-bg-black">
        <div class="layui-side-scroll">
            <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
            <ul class="layui-nav layui-nav-tree"  lay-filter="">
                <li class="layui-nav-item layui-nav-itemed">
                    <a class="" href="javascript:;">客户管理</a>
                    <dl class="layui-nav-child">
                        <dd><a href="/user/index">客户列表</a></dd>
<!--                        <dd><a href="">我的客户</a></dd>-->
                    </dl>
                </li>
                <li class="layui-nav-item">
                    <a href="javascript:;">报告管理</a>
                    <dl class="layui-nav-child">
                        <dd><a href="/report/index">报告列表</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item">
                    <a href="javascript:;">后台管理</a>
                    <dl class="layui-nav-child">
                        <dd><a href="/admin-user/index">管理员列表</a></dd>
                    </dl>
                </li>

<!--                <li class="layui-nav-item"><a href="">云市场</a></li>-->
<!--                <li class="layui-nav-item"><a href="">发布商品</a></li>-->
            </ul>
        </div>
    </div>

    <div class="layui-body">

        <!-- 内容主体区域 -->
        <div style="padding: 15px;"> <?php echo $content; ?></div>
    </div>

    <div class="layui-footer">
        <!-- 底部固定区域 -->
        © xty - 版权所有
    </div>
</div>
<!--<script src="../src/layui.js"></script>-->
<script>
    //JavaScript代码区域
    layui.use('element', function(){
        var element = layui.element;
    });
</script>
</body>
</html>