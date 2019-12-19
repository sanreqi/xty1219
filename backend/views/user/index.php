<?php
$this->registerJsFile('@web/static/js/user.js?v=3');
?>

<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
    <legend>用户</legend>
</fieldset>

<div class="txl" style="margin-bottom: 10px;">
    <div class="layui-btn-group">
        <button class="layui-btn layui-btn-sm layui-btn-normal" id="add_user">添加用户</button>
    </div>
</div>

<form class="layui-form">
    <div class="layui-form-item">
        <div class="layui-inline">
            <div class="layui-input-inline">
                <input type="text" class="layui-input" autocomplete="off">
            </div>
        </div>
        <div class="layui-inline">
            <button class="layui-btn layui-btn-sm layui-btn-normal" id="add_user">搜索</button>
        </div>
    </div>
</form>

<div id="user-dialog" style="display: none !important;">
    <div class="xty-dialog">
        <form class="layui-form user-form" action="">
            <div class="layui-form-item">
                <label class="layui-form-label">用户名</label>
                <div class="layui-input-block">
                    <input class="xty-input layui-input" type="text" name="User[username]" lay-verify="username" autocomplete="off" placeholder="请输入用户名">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">姓名</label>
                <div class="layui-input-block">
                    <input class="xty-input layui-input" type="text" name="User[company_name]" lay-verify="company_name" autocomplete="off" placeholder="请输入姓名">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">密码</label>
                <div class="layui-input-block">
                    <input class="xty-input layui-input" type="text" name="User[password]" lay-verify="password" autocomplete="off" placeholder="请输入密码，不填默认为123456">
                </div>
            </div>
            <div class="xty-dialog-btn-group txr">
                <button class="save-user layui-btn layui-btn-normal layui-btn-sm">保存</button>
                <button class="cancel-dialog layui-btn layui-btn-primary layui-btn-sm">取消</button>
            </div>
        </form>
    </div>
</div>

<table id="user-table" lay-filter="user"></table>
<input type="hidden" name="delete-id" id="delete-id">

<script>
    $(document).ready(function () {
        layui.use('table', function(){
            var table = layui.table;
            table.render({
                elem: '#user-table',
                page: true,
                cols: [[ //表头
                    {field: 'id', title: 'ID', width:100, sort: true, fixed: 'left'},
                    {field: 'username', title: '用户名', width:100},
                    {field: 'company_name', title: '企业名称', width:100},
                    {field: 'operate', title: '操作'}
                ]],
                data: <?php echo $data; ?>
            });
        });
    });
</script>