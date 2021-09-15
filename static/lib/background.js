/* Written by Ye Liu */

'use strict'

var background = {}

background.init = function () {
    for (var i = 0; i < 25; i++) {
        setTimeout('background.generate_bubbles()', rand(0, 8000))
    }
}

background.generate_bubbles = function () {
    var that = this,
        shape_type = Math.floor(rand(1, 3)),
        size = rand(0.8, 1.2)

    if (shape_type == 1) {
        var bubble = $('<div class="bubble"></div>').css({
            width: 0,
            height: 0,
            background: 'transparent',
            'border-style': 'solid',
            'border-width': '0 40px 69.3px 40px',
            'border-color': 'transparent transparent #ffffff transparent',
        })
    } else if (shape_type == 2) {
        var bubble = $('<div class="bubble"></div>').css({ borderRadius: '50%' })
    } else {
        var bubble = $('<div class="bubble"></div>')
    }

    bubble.appendTo($('body'))
    bubble.css({
        transform: 'scale(' + size + ') rotate(' + rand(-360, 360) + 'deg)',
        top: $('body').height() + 100,
        left: rand(-60, $('body').width() + 60)
    })
    bubble.transit({
        top: rand(100, 300),
        transform: 'scale(' + size + ') rotate(' + rand(-360, 360) + 'deg)',
        opacity: 0
    }, rand(8000, 13000), function () {
        $('.bubble').get(0).remove()
        that.generate_bubbles()
    })
}

function rand(from, to, arr) {
    return arr ? Math.random() * (to - from + 1) + from : Math.floor(Math.random() * (to - from + 1) + from)
}

background.init()
