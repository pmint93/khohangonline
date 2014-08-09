    $(".notification").bind("touchend", function () {
        $(".notification").hide();
    });
    $("#NotificationJS").bind("touchend", function () {
        $("#NotificationJS").removeClass("notification");
        $("#NotificationJS").hide();
    });
    var t = setTimeout(function(){
        $(".notification").hide();
        $("#NotificationJS").removeClass("notification");
        $("#NotificationJS").hide();
    }, 3000);
    Notification = {
        show: function (msg) {
            var _self = this;
            clearTimeout(_self.t);
            $("#NotificationJS").removeClass("notification");
            $("#NotificationJS").html(msg + "<span class='close'>x</span>");
            $("#NotificationJS").show();
            $("#NotificationJS").addClass("notification");
            this.t = setTimeout(function(){
                _self.hide();
                clearTimeout(_self.t);
            },3000);
        },
        hide: function(){
            $("#NotificationJS").removeClass("notification");
            $("#NotificationJS").hide();
        }
    }