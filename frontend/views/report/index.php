<div class="page">
    <form style="margin-top:10px; margin-bottom: 10px;" class="layui-form layui-form-pane">
            <div class="layui-input-inline">
                <input type="text" name="keyword" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input">
            </div>
        <button class="layui-btn layui-btn-normal search-btn">搜索</button>
    </form>

<!--    <div class="weui-cells" style="margin-top: 0px;">-->
<!--        --><?php //if (!empty($models)): ?>
<!--            --><?php //foreach ($models as $model): ?>
<!--                <a href="--><?php //echo 'http://xtyadmin.local' . $model['web_path']; ?><!--" class="weui-cell weui-cell_access" target="_blank">-->
<!--                    <div class="weui-cell__bd">-->
<!--                        <p>--><?php //echo $model['name']; ?><!--</p>-->
<!--                    </div>-->
<!--                </a>-->
<!--            --><?php //endforeach; ?>
<!--        --><?php //endif; ?>
<!--    </div>-->
</div>

<table id="report-table"></table>

<script>
    $(document).ready(function() {
        layui.use('table', function(){
            var table = layui.table;
            table.render({
                elem: '#report-table',
                page: true,
                url: '<?php echo $url; ?>',
                limit: 10,
                cols: [[ //表头
                    {field: 'name', title: '报告', sort: true, fixed: 'left'},
                    // {field: 'company_name', title: '客户名称'},
                    // {field: 'report', title: '查看报告'},
                    // {field: 'operate', title: '操作'},
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
    });
</script>