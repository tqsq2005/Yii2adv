/**
 * Created by Administrator on 16-1-8.
 * 公共Js：
 * 1、左侧浮动工具栏的css，包含返回顶部，页面刷新，页面二维码及返回底部
 * 2、新窗口打开外链
 * 3、防止表单重复提交
 * 4、Bootbox美化gii生成的删除按钮
 */
jQuery(function($) {
    /**
     * textPrint : 打印机文字特效
     * @param string str
     */
    (function(a) {
        a.fn.textPrint = function(speed) {
            this.each(function() {
                var d = a(this),
                    c = d.html(),
                    b = 0;
                d.html("");
                var e = setInterval(function() {
                        var f = c.substr(b, 1);
                        if (f == "<") {
                            b = c.indexOf(">", b) + 1
                        } else {
                            b++
                        }
                        d.html(c.substring(0, b) + (b & 1 ? "_": ""));
                        if (b >= c.length) {
                            clearInterval(e)
                        }
                    },
                    speed)
            });
            return this;
        }
    })(jQuery);
    //moment
    moment.locale('zh-cn');
    //layer加载扩展模块
    layer.config({
        extend: 'extend/layer.ext.js',
        skin: 'layui-layer-lan'
    });
    // 新窗口打开外链
    $('a[href^="http://"], a[href^="https://"]').each(function () {
        var a = new RegExp('/' + window.location.host + '/');
        if (!a.test(this.href)) {
            $(this).click(function (event) {
                event.preventDefault();
                event.stopPropagation();
                window.open(this.href, '_blank');
            });
        }
    });
    //add by ruzuojun
    $(document).on("click", "#goTop", function () {
        $('html,body').animate({scrollTop: '0px'}, 800);
    }).on("click", "#goBottom", function () {
        //回到底部
        var windowHeight = parseInt($("body").css("height"));//整个页面的高度
        console.log(windowHeight);
        $('html,body').animate({scrollTop: windowHeight }, 800);
    }).on("click", "#refresh", function () {
        location.reload();
    });

    // 防止重复提交
    /*$('form').on('beforeValidate', function (e) {
        console.log('beforeValidate');
        $(':submit').attr('disabled', true).addClass('disabled');
    });
    $('form').on('afterValidate', function (e) {
        //console.log($(this).data('yiiActiveForm').validated);
        if (cheched = $(this).data('yiiActiveForm').validated == false) {
            $(':submit').removeAttr('disabled').removeClass('disabled');
        }
    });*/
    $('form').on('beforeSubmit', function (e) {
        $(':submit').attr('disabled', true).addClass('disabled');
    });

    //
    $(window).scroll(function() {
        $(this).scrollTop() > 200 ? $("#floatButton").css({
            "display": "block"
        }) : $("#floatButton").css({
            "display": "none"
        });
    });
    //pjax
    $(document).on('pjax:send', function() {
        layer.load();
    });
    $(document).on('pjax:complete', function() {
        layer.closeAll('loading');
    });
    //layer 自定义 confirm
    yii.allowAction = function ($e) {
        var message = $e.data('confirm');
        return message === undefined || yii.confirm(message, $e);
    };
    // --- Delete action (layer) ---
    yii.confirm = function (message, ok, cancel) {
        layer.confirm(
            message,
            {
                title : '系统提示',
                //skin: 'layui-layer-molv',
                shift: 6,
                icon: 5,
                scrollbar: false//锁定窗口
            }, function(index) {
                //do something
                ok();
                layer.close(index);
            }
        );
        // confirm will always return false on the first call
        // to cancel click handler
        return false;
    }

    //Bootbox
    //设置中文
    /*bootbox.setLocale('zh_CN');
    yii.allowAction = function ($e) {
        var message = $e.data('confirm');
        return message === undefined || yii.confirm(message, $e);
    };
    // --- Delete action (bootbox) ---
    yii.confirm = function (message, ok, cancel) {
        bootbox.confirm(
            {
                message: "<i class='fa fa-exclamation-triangle fa-3x fa-pull-left fa-fw text-danger'></i>" + message + "<br><i class='fa fa-hand-o-right fa-fw text-info'></i>&nbsp; 按<b class='text-info'>ESC</b>快速取消.",
                *//*buttons: {
                 confirm: {
                 label: "OK"
                 },
                 cancel: {
                 label: "Cancel"
                 }
                 },*//*
                callback: function (confirmed) {
                    if (confirmed) {
                        !ok || ok();
                    } else {
                        !cancel || cancel();
                    }
                }
            }
        );
        // confirm will always return false on the first call
        // to cancel click handler
        return false;
    }*/
});