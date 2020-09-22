/* Written by Ye Liu */

'use strict'

function submit() {
    // 输入合法性校验
    for (var i = 0; i < $('input').length; i++) {
        if (!varify($('input')[i].id)) {
            $('.error-label').html('用户名或密码不合法')
            $('form').fadeIn(500)
            $('.error-label').removeClass('is-invisible')
            $('.login-button').removeClass('is-register')
            $('.container').removeClass('form-success')
            return
        }
    }

    $.ajax({
        type: 'POST',
        url: $('.login-button').html() == '登录' ? 'login.php' : 'register.php',
        data: {
            username: $('input[name="username"]').val(),
            password: md5($('input[name="password"]').val())
        },
        timeout: 5000,
        success: function (res) {
            if (res.success) {
                $(window).attr('location', res.url)
                return
            } else {
                $('.error-label').html(res.errMsg)
                $('form').fadeIn(500)
                $('.error-label').removeClass('is-invisible')
                $('.login-button').removeClass('is-register')
                $('.container').removeClass('form-success')
            }
        },
        error: function () {
            $('.error-label').html('连接丢失，请稍后重试')
            $('form').fadeIn(500)
            $('.error-label').removeClass('is-invisible')
            $('.login-button').removeClass('is-register')
            $('.container').removeClass('form-success')
        }
    })
}

$('.login-button').click(function (e) {
    e.preventDefault()
    $('form').fadeOut(500)
    $('.container').addClass('form-success')
    setTimeout('submit()', 1500)
})

$('.register-button').click(function (e) {
    e.preventDefault()
    $(this).fadeOut(500)
    $('.login-button').text('注册')
    $('.login-button').addClass('is-register')
})