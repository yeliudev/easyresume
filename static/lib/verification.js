/* Written by Ye Liu */

'use strict'

var checkService = {
    isNotEmpty: function (val) {
        return val != null && val != ''
    },

    isUsername: function (val) {
        if (val == null || val == '') return true
        var reg = /^[\w.@]+$/
        return reg.test(val)
    },

    isPassword: function (val) {
        if (val == null || val == '') return true
        var reg = /^[\w.@\[\]\<\>\-]+$/
        return reg.test(val)
    },

    isName: function (val) {
        if (val == null || val == '') return true
        var reg = /^[A-Za-z\u4e00-\u9fa5.\(\) ·]+$/
        return reg.test(val)
    },

    isNum: function (val) {
        if (val == null || val == '') return true
        var reg = /^\d+$/
        return reg.test(val)
    },

    isEmail: function (val) {
        if (val == null || val == '') return true
        var reg = /^[\w]+@[A-Za-z0-9]+.[A-Za-z0-9.]*$/
        return reg.test(val)
    },

    isNormalStr: function (val) {
        if (val == null || val == '') return true
        var reg = /^[\w\u0391-\uFFE5:;'"\s\-\/\+\(\)\[\]\{\},.]+$/
        return reg.test(val)
    },

    stringLengthCheck: function (val, length) {
        if (val == null || val == '') return true
        if (length == 4 || length == 11) return val.length == length
        return val.length <= length
    }
}

function verify(id) {
    var val = document.getElementById(id).value,
        valids = document.getElementById(id).dataset.valid.split(' ')

    // 字符串长度校验
    if (!checkService.stringLengthCheck(val, parseInt(valids[0]))) {
        return false
    }

    // 字符串内容校验
    for (var i = 1; i < valids.length; i++) {
        if (!checkService[valids[i]](val)) {
            return false
        }
    }

    return true
}