$(document).ready(function () {

    var dialog = $("#add-user-dialog").html();
    $("#add_admin_user").click(function () {
        $(".user-form").attr("action", "/admin-user/save-admin-user");
        layer.open({
            type: 1,
            title: '添加用户',
            area: ['420px', '280px'], //宽高
            skin: 'layer-ext-moon',
            anim: 2,
            shadeClose: true,
            shade: 0,
            content: $("#admin-user-dialog"),
            end: function(){
                $("#admin-user-dialog").css("display", "none");
            }
        });
    });

    //取消弹出层
    $("body").on("click", ".cancel-dialog", function() {
        layer.closeAll();
        $("#admin-user-dialog").hide();
        return false;
    });

    $("body").on("click", ".update-admin-user", function() {
        var id = $(this).attr("id");

        $.ajax({
            url: "/admin-user/get-admin-user?id="+id,
            type: "get",
            dataType: "json",
            data: {},
            success: function(data) {
                if (data.status == 1) {
                    var url = $(".admin-user-form").attr("action", "/admin-user/save-admin-user?id=" + data.data.id);
                    $("input[name='AdminUser[username]").val(data.data.username);
                    $("input[name='AdminUser[truename]']").val(data.data.truename);

                    layer.open({
                        type: 1,
                        title: '添加用户',
                        area: ['420px', '280px'], //宽高
                        // skin: 'layer-ext-moon',
                        anim: 2,
                        content: $("#admin-user-dialog"),
                        shadeClose: true,
                        shade: 0,
                        end: function(){
                            $("#admin-user-dialog").css("display", "none");
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
        var form_data = $(".admin-user-form").serialize();
        var url = $(".admin-user-form").attr("action");
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

    $("body").on("click", ".delete-admin-user", function() {
        var id = $(this).attr("id");
        $("#delete-id").val(id);
        layer.confirm('确定要删除此管理员吗?', {title:'删除'}, function(index){
            var id = $("#delete-id").val();
            var url = "/admin-user/delete?id=" + id;
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