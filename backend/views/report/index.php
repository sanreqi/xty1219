<?php
//$this->registerJsFile('@web/static/js/admin_user.js');
?>

<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
    <legend>客户报告</legend>
</fieldset>

<div class="txl" style="margin-bottom: 10px;">
    <div class="layui-btn-group">
<!--        <a href="--><?php //echo \yii\helpers\Url::toRoute(['report/create-update', 'uid' => $uid]); ?><!--" class="layui-btn layui-btn-sm layui-btn-normal" id="add_report">上传报告</a>-->
    </div>
</div>

<form class="layui-form">
    <div class="layui-inline">
        <select name="uid" lay-verify="required" lay-search="">
            <option value="">请选择企业</option>
            <?php if (!empty($userModels)): ?>
                <?php foreach ($userModels as $model): ?>
                    <option value="<?php echo $model->id ?>"><?php echo $model->company_name ?></option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>
    </div>
    <div class="layui-inline">
        <input name="keyword" type="text" class="layui-input" placeholder="可根据代码、报告名称搜索" autocomplete="off">
    </div>

    <div class="layui-inline">
        <button class="layui-btn layui-btn-sm layui-btn-normal" id="search-report">搜索</button>
    </div>
</form>

<table id="report-table" lay-filter="report"></table>
<input type="hidden" name="delete-id" id="delete-id">

<script>
    $(document).ready(function () {
        layui.use('form', function(){
            var form = layui.form; //只有执行了这一步，部分表单元素才会自动修饰成功
            //但是，如果你的HTML是动态生成的，自动渲染就会失效
            //因此你需要在相应的地方，执行下述方法来手动渲染，跟这类似的还有 element.init();
            form.render();
        });

        layui.use('table', function(){
            var table = layui.table;
            table.render({
                elem: '#report-table',
                page: true,
                url: '<?php echo $url; ?>',
                limit: 10,
                cols: [[ //表头
                    {field: 'id', title: 'ID', width:100, sort: true, fixed: 'left'},
                    {field: 'company_name', title: '客户名称'},
                    {field: 'report', title: '查看报告'},
                    {field: 'operate', title: '操作'},
                    // {field: 'code', title: '代码', width:100},
                    // {field: 'admin_uid', title: '操作人', width:100},
                    // {field: 'report_backend', title: '报告', width:100},
                    // {field: 'operate', title: '操作'}
                ]],
                request: {
                    pageName: 'page', //页码的参数名称，默认：page
                    limitName: 'per-page' //每页数据量的参数名，默认：limit
                }
            });
        });

        //@todo 异步刷新表格
        $("body").on("click", ".delete-report", function() {
            var id = $(this).attr("id");
            $("#delete-id").val(id);
            layer.confirm('确定要删除此管理员吗?', {title:'删除'}, function(index){
                var id = $("#delete-id").val();
                var url = "/report/delete?id=" + id;
                $.ajax({
                    url: url,
                    type: "post",
                    dataType: "json",
                    data: {},
                    success: function(data) {
                        if (data.status == 1) {
                            window.location.reload();
                        } else {
                            layer.alert(data.errorMsg)
                        }
                    }
                });

                layer.close(index);
            });
        });
    });
</script>