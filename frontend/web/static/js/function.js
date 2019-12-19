/**
 * Created by srq on 2018/4/6.
 */

function bindSubmitForm(btn_id, from_id, param){
    $("#" + btn_id).click(function(){
        var $this = $(this);
        $this.attr("disabled", "disabled");
        $this.find("i").addClass("weui-loading");
        var url = $this.attr("url");
        var form_data = $("#" + from_id).serialize();
        $.ajax({
            url: url,
            type: "post",
            dataType: "json",
            data: form_data,
            success: function(data){
                if(data.status == 1){
                    if(param != "undefined" && param.redirect_url != "undefined"){
                        window.location.href = param.redirect_url;
                    }
                }else{
                    layer.alert(data.errorMsg);
                    // alert(data.errorMsg);
                }
                $this.removeAttr("disabled");
                $this.find("i").removeClass("weui-loading");
            },
            error: function(e){
                $this.removeAttr("disabled");
                $this.find("i").removeClass("weui-loading");
            }
        });

        return false;
    });
}

function showToast(){
    var $toast = $("#toast");
    if ($toast.is(":visible")){
        return;
    }

    $toast.fadeIn(100);
    setTimeout(function () {
        $toast.fadeOut(100);
    }, 2000);
}

function hideToast(){
    var $toast = $("#toast");
    if (!$toast.is(":visible")){
        return;
    }

    $toast.hide();
}

function showLoadingToast(){
    var $loadingToast = $("#loadingToast");

    if($loadingToast.is(":visible")){
        return;
    }

    $loadingToast.fadeIn(100);

}

function hideLoadingToast(){
    var $loadingToast = $("#loadingToast");
    if(!$loadingToast.is(":visible")){
        return;
    }

    $loadingToast.hide();
}

function showMessageDialog(message){
    $("#message-content").html(message);
    $("#message-dialog").on("click", ".weui-dialog__btn_primary", function(){
        $("#message-dialog").hide();
    });
    $("#message-dialog").show();
}

//验证手机号是否合法
function isPoneAvailable($poneInput) {
    var myreg=/^[1][3,4,5,7,8][0-9]{9}$/;
    if (!myreg.test($poneInput.val())) {
        return false;
    } else {
        return true;
    }
}

function stampToDate(timestamp) {
    var date = new Date(timestamp);//时间戳为10位需*1000，时间戳为13位的话不需乘1000
    Y = date.getFullYear() + '-';
    M = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1) : date.getMonth()+1) + '-';
    D = date.getDate() < 10 ? '0' + date.getDate() : date.getDate();
    // alert();
    // h = date.getHours() + ':';
    // m = date.getMinutes() + ':';
    // s = date.getSeconds();
    return Y+M+D;
}

function isPositiveInteger(num) {
    if ((/(^[1-9]\d*$)/.test(num))) {
        return true
    }else {
        return false;
    }
}
