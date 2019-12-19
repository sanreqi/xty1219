<?php
$this->registerJsFile('@web/static/js/admin_user.js?v=1');
?>

<!--<div class="txr">-->
    <div class="layui-btn-group">
        <button class="layui-btn layui-btn-sm layui-btn-normal" id="add_admin_user">添加管理员</button>
    </div>
<!--</div>-->


<div id="admin-user-dialog" style="display: none;">
    <div class="xty-dialog">
        <form class="layui-form admin-user-form" action="">
            <div class="layui-form-item">
                <label class="layui-form-label">用户名</label>
                <div class="layui-input-block">
                    <input class="xty-input layui-input" type="text" name="AdminUser[username]" lay-verify="username" autocomplete="off" placeholder="请输入用户名">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">姓名</label>
                <div class="layui-input-block">
                    <input class="xty-input layui-input" type="text" name="AdminUser[truename]" lay-verify="truename" autocomplete="off" placeholder="请输入姓名">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">密码</label>
                <div class="layui-input-block">
                    <input class="xty-input layui-input" type="text" name="AdminUser[password]" lay-verify="password" autocomplete="off" placeholder="请输入密码，不填默认为123456">
                </div>
            </div>
            <div class="xty-dialog-btn-group txr">
                <button class="save-user layui-btn layui-btn-normal layui-btn-sm">保存</button>
                <button class="cancel-dialog layui-btn layui-btn-primary layui-btn-sm">取消</button>
            </div>
        </form>
    </div>
</div>

<table id="admin-user-table" lay-filter="admin-user"></table>
<input type="hidden" name="delete-id" id="delete-id">
<script src="http://pv.sohu.com/cityjson?ie=utf-8"></script>


<script>
    $(document).ready(function () {
        layui.use('table', function(){
            var table = layui.table;
            table.render({
                elem: '#admin-user-table',
                page: true,
                cols: [[ //表头
                    {field: 'id', title: 'ID', width:100, sort: true, fixed: 'left'},
                    {field: 'username', title: '用户名', width:100},
                    {field: 'truename', title: '姓名', width:100},
                    {field: 'operate', title: '操作'}
                ]],
                data: <?php echo $data; ?>
            });
        });
    });



    console.log(returnCitySN)
    //返回对象Object {cip: "122.70.200.146", cid: "110000", cname: "北京市"}



</script>