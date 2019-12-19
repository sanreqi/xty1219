<?php
$this->registerJsFile('@web/static/js/jquery.form.js?v=1');
?>

<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
    <legend>添加报告</legend>
</fieldset>

<form class="layui-form" id="report-form" enctype="multipart/form-data">
    <div class="layui-form-item">
        <label class="layui-form-label">客户名称</label>
        <div class="layui-input-block xty-input-info">
           <?php echo $user->company_name; ?>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">报告名称</label>
        <div class="layui-input-block">
            <input class="layui-input xty-input" type="text" name="name" lay-verify="" autocomplete="off"
                   placeholder="请输入标题" value="<?php echo $model->name; ?>">
        </div>
    </div>

<!--    <div class="layui-form-item">-->
<!--        <label class="layui-form-label">上传时间</label>-->
<!--        <div class="layui-input-block">-->
<!--            <input type="text" name="title" lay-verify="title" autocomplete="off" placeholder="请输入标题" class="layui-input">-->
<!--        </div>-->
<!--    </div>-->

    <div class="layui-form-item">
        <label class="layui-form-label">上传报告</label>
        <div class="layui-input-block">
            <button type="button" class="layui-btn" id="upload-file">
                <i class="layui-icon">&#xe67c;</i>上传报告
            </button>
        </div>
    </div>

    <div style="margin-left: 40px;">
        <button class="layui-btn layui-btn-normal" id="save-report-btn">保存</button>
        <button class="layui-btn layui-btn-primary" id="cancel-report-btn">取消</button>
    </div>
</form>

<script>
    layui.use('upload', function(){
        var upload = layui.upload;

        //执行实例
        var uploadInst = upload.render({
            elem: '#upload-file', //绑定元素,
            auto: false,
            accept: 'file',
            field: 'ReportForm[reportFile]'
        });
    });

    $("#save-report-btn").click(function() {
        //防重复提交
        var $this = $(this);
        $this.attr("disabled", "disabled");
        $this.removeClass("layui-btn-normal").addClass("layui-btn-disabled");

        $("#report-form").ajaxSubmit({
            url: "<?php echo $submitUrl ?>",
            type: "post",
            dataType: "json",
            data: {},
            success: function(data) {
                if (data.status == 1) {
                    layer.alert("添加报告成功");
                    window.location.href = "<?php echo $returnUrl; ?>"
                } else {
                    $this.removeAttr("disabled");
                    $this.removeClass("layui-btn-disabled").addClass("layui-btn-normal");
                    layer.alert(data.errorMsg);
                }
            }
        });

        return false;
    });
</script>
