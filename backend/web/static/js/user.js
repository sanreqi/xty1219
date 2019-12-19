$(document).ready(function () {
    var dialog = $("#add-user-dialog").html();
    var index = $("#add_user").click(function () {
        $(".user-form").attr("action", "/user/save-user");
        layer.open({
            type: 1,
            title: '添加用户',
            area: ['420px', '280px'], //宽高
            skin: 'layer-ext-moon',
            anim: 2,
            closeBtn: 1,
            shadeClose: true,
            shade: 0,
            content: $("#user-dialog"),
            end: function(){
                $("#user-dialog").css("display", "none");
            }
        });
    });

    //取消弹出层
    $("body").on("click", ".cancel-dialog", function() {
        layer.closeAll();
        return false;
    });

    $("body").on("click", ".update-user", function() {
        var id = $(this).attr("id");

        $.ajax({
            url: "/user/get-user?id="+id,
            type: "get",
            dataType: "json",
            data: {},
            success: function(data) {
                if (data.status == 1) {
                    var url = $(".user-form").attr("action", "/user/save-user?id=" + data.data.id);
                    $("input[name='User[username]").val(data.data.username);
                    $("input[name='User[company_name]']").val(data.data.company_name);

                    layer.open({
                        type: 1,
                        title: '添加用户',
                        area: ['420px', '280px'], //宽高
                        skin: 'layer-ext-moon',
                        anim: 2,
                        shadeClose: true,
                        shade: 0,
                        content: $("#user-dialog"),
                        end: function(){
                            $("#user-dialog").css("display", "none");
                        }
                    });
                } else {
                    layer.alert(data.errorMsg);
                }
            }
        });
    });

    //保存
    $("body").on("click", ".save-user", function() {
        var form_data = $(".user-form").serialize();
        var url = $(".user-form").attr("action");
        $.ajax({
            url: url,
            type: "post",
            dataType: "json",
            data: form_data,
            success: function(data) {
                if (data.status == 1) {
                    window.location.reload();
                } else {
                    layer.alert(data.errorMsg)
                }
            }
        });
        return false;
    });

    $("body").on("click", ".delete-user", function() {
        var id = $(this).attr("id");
        $("#delete-id").val(id);
        layer.confirm('确定要删除此管理员吗?', {title:'删除'}, function(index){
            var id = $("#delete-id").val();
            var url = "/user/delete?id=" + id;
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