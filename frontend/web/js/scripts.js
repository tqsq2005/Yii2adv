$(function() {
    $('#loginModal').formValidation({
        framework: 'bootstrap',
        excluded: ':disabled',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            "login-form[login]": {
                validators: {
                    notEmpty: {
                        message: '请输入用户名'
                    }
                }
            },
            "login-form[password]": {
                validators: {
                    notEmpty: {
                        message: '请输入密码'
                    }
                }
            }
        }
    });

    $(document).on('click', '#user-logout', function() {
        var shiftNum = [0, 1, 2, 3, 4, 5, 6];
        var href = $(this).attr('data-href');
        //console.log($(this).attr('data-href'));
        layer.confirm(
            '退出账号，确定吗？',
            {
                title : '系统提示',
                skin: 'layui-layer-molv',
                shift: shiftNum[Math.floor(Math.random()*shiftNum.length)],
                icon: 5,
                scrollbar: false//锁定窗口
            }, function(index) {
                $.ajax({
                    url: href,
                    type: 'POST',
                    success: function(){
                        layer.msg('账号已退出！', {icon: 6});
                    },
                    error: function(e){
                        console.log(e.responseText);
                    }
                });
                //layer.close(index);
            });

    })
    .on('click', '#login-form-submit', function() {
        $('#loginModal').submit();
    })
    .on('click', '#goToGuestbook', function() {
        var href = $(this).attr('data-href');
        layer.msg('跳转至 留言板界面..',{
            icon: 6,
            time: 2000 //2秒关闭（如果不配置，默认是3秒）
        }, function(){
            window.location.href = href;
        });
    })
    .on('click', '#btn-gohome', function() {
        var href = $(this).attr('data-href');
        layer.msg('即将返回主页..',{
            icon: 6,
            time: 2000 //2秒关闭（如果不配置，默认是3秒）
        }, function(){
            window.location.href = href;
        });
    });

    $('.fab').hover(function () {
        $(this).toggleClass('active');
    });
    //$('[data-toggle="tooltip"]').tooltip();
});