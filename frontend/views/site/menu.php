<div class="page">
    <div class="weui-cells" style="margin-top: 0px;">
        <a class="weui-cell weui-cell_access" href="javascript:;">
            <div class="weui-cell__bd">
                <p>查看报告</p>
            </div>
        </a>
        <a class="weui-cell weui-cell_access" href="javascript:;">
            <div class="weui-cell__bd">
                <p>修改密码</p>
            </div>
            <!--            <div class="weui-cell__ft">说明文字</div>-->
        </a>
<!--        <a class="weui-cell weui-cell_access" href="javascript:;">-->
<!--            <div class="weui-cell__bd">-->
<!--                <p>个人资料</p>-->
<!--            </div>-->
<!--        </a>-->
<!--        <a class="weui-cell weui-cell_access" href="javascript:;">-->
<!--            <div class="weui-cell__bd">-->
<!--                <p>通讯录</p>-->
<!--            </div>-->
<!--        </a>-->
<!--        <a class="weui-cell weui-cell_access" href="javascript:;">-->
<!--            <div class="weui-cell__bd">-->
<!--                <p>平台列表</p>-->
<!--            </div>-->
<!--        </a>-->
<!--        <a class="weui-cell weui-cell_access" href="javascript:;">-->
<!--            <div class="weui-cell__bd">-->
<!--                <p>交易明细</p>-->
<!--            </div>-->
<!--        </a>-->
    </div>
    <div class="weui-btn-area">
        <a href="javascript:void(0)" class="weui-btn weui-btn_warn" id="logout-btn">退出登录</a>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $("#logout-btn").click(function () {
            var index = layer.confirm('确定要退出登录吗?', {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.ajax({
                    url: "/site/logout",
                    type: "post",
                    dataType: "json",
                    data: {},
                    success: function(data) {
                        if (data.status == 1) {
                            window.location.href = "/site/login"
                        } else {
                            layer.alert(data.errorMsg)
                        }
                    }
                });
            }, function(){
                layer.close(index);
//                layer.msg('也可以这样', {
//                    time: 20000, //20s后自动关闭
//                    btn: ['明白了', '知道了']
//                });
            });





            return false;
        });
    });
</script>