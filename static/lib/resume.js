/* Written by Ye Liu */

'use strict'

const colors = ['rgba(236, 208, 120, 0.7)', 'rgba(217, 91, 67, 0.7)', 'rgba(192, 41, 66, 0.7)', 'rgba(84, 36, 55, 0.7)', 'rgba(83, 119, 122, 0.7)', 'rgba(119, 146, 174, 0.7)']

function drawChart() {
    var canvas = document.getElementById('chart'),
        ctx = canvas.getContext('2d'),
        plotBase = canvas.width * 13 / 60,
        data = [document.getElementById('cpp-slider').value,
        document.getElementById('py-slider').value,
        document.getElementById('java-slider').value,
        document.getElementById('cs-slider').value,
        document.getElementById('git-slider').value,
        document.getElementById('latax-slider').value]

    ctx.clearRect(0, 0, canvas.width, canvas.height)

    for (var i = 0; i < 6; i++) {
        var start = i * (plotBase - canvas.width / 15),
            peakPoint = canvas.height - Math.round(canvas.height * (data[i] / Math.max.apply(Math, data)))

        ctx.fillStyle = colors[i]
        ctx.beginPath()
        ctx.moveTo(start, canvas.height)
        ctx.lineTo(start + plotBase / 2, peakPoint)
        ctx.lineTo(start + plotBase, canvas.height)
        ctx.lineTo(start, canvas.height)
        ctx.fill()
    }
}

function displayAvatar() {
    var avatarFile = document.getElementById('avatar-input').files[0]

    if (avatarFile) {
        var reader = new FileReader()
        reader.onload = function (e) {
            document.getElementById('avatar').style.backgroundImage = 'url(' + e.target.result + ')'
        }
        reader.readAsDataURL(avatarFile)
        document.getElementById('avatar').src = 'static/assets/transparent.png'
    }

    if (avatarFile.size > 2097152) {
        document.getElementById('avatar-warning').classList.add('display')
    } else {
        document.getElementById('avatar-warning').classList.remove('display')
    }
}

function onSexClick(e) {
    if (!document.getElementById('avatar').style.backgroundImage) {
        document.getElementById('avatar').src = 'static/assets/' + (e == 'male' ? 'male.png' : 'female.png')
    }
}

function encodeTable() {
    for (var i = 0; i < document.getElementsByName('award-title').length; i++) {
        document.getElementsByName('award-time-warning')[i].id = 'awards[' + i.toString() + '][time]-warning'
        document.getElementsByName('award-title-warning')[i].id = 'awards[' + i.toString() + '][title]-warning'
        document.getElementsByName('award-time')[i].id = 'awards[' + i.toString() + '][time]'
        document.getElementsByName('award-level')[i].id = 'awards[' + i.toString() + '][level]'
        document.getElementsByName('award-title')[i].id = 'awards[' + i.toString() + '][title]'
    }

    for (var i = 0; i < document.getElementsByName('job-title').length; i++) {
        document.getElementsByName('job-time-warning')[i].id = 'jobs[' + i.toString() + '][time]-warning'
        document.getElementsByName('job-company-warning')[i].id = 'jobs[' + i.toString() + '][company]-warning'
        document.getElementsByName('job-title-warning')[i].id = 'jobs[' + i.toString() + '][title]-warning'
        document.getElementsByName('job-from-time')[i].id = 'jobs[' + i.toString() + '][from]'
        document.getElementsByName('job-to-time')[i].id = 'jobs[' + i.toString() + '][to]'
        document.getElementsByName('job-company')[i].id = 'jobs[' + i.toString() + '][company]'
        document.getElementsByName('job-title')[i].id = 'jobs[' + i.toString() + '][title]'
    }
}

function remarktAdaptaion() {
    var remarkPreview = document.getElementById('statement-preview')
    if (remarkPreview && remarkPreview.scrollHeight) {
        remarkPreview.style.height = remarkPreview.scrollHeight + 10 + 'px'
    }
}

function parseDom(template, id = false) {
    var el = document.createElement('div')

    if (id) {
        el.setAttribute('id', id)
    }
    el.setAttribute('class', 'columns')
    el.innerHTML = template

    return el
}

function onAddAwardClick() {
    if (document.getElementById('award-table') == null) {
        document.getElementById('resume').insertBefore(parseDom(awardTableTemplate, 'award-table-container'), document.getElementById('after-award-table'))
    }

    var awardTable = document.getElementById('award-table'),
        addAwardBtn = document.getElementById('add-award-btn')

    if (awardTable.childElementCount < 9) {
        awardTable.appendChild(parseDom(awardTemplate))
    } else if (awardTable.childElementCount == 9) {
        awardTable.appendChild(parseDom(awardTemplate))
        addAwardBtn.setAttribute('class', addAwardBtn.getAttribute('class').replace('primary', 'static'))
        addAwardBtn.innerHTML = 'Maximum number of rows exceeded'
    }

    encodeTable()
}

function onDelAwardClick(e) {
    var awardTable = document.getElementById('award-table'),
        addAwardBtn = document.getElementById('add-award-btn')

    awardTable.removeChild(e.parentNode.parentNode)

    if (awardTable.childElementCount == 9) {
        addAwardBtn.setAttribute('class', addAwardBtn.getAttribute('class').replace('static', 'primary'))
        addAwardBtn.innerHTML = 'Add'
    } else if (!awardTable.childElementCount) {
        document.getElementById('resume').removeChild(document.getElementById('award-table-container'))
    }

    encodeTable()
}

function onAddJobClick() {
    if (document.getElementById('job-table') == null) {
        document.getElementById('resume').insertBefore(parseDom(jobTableTemplate, 'job-table-container'), document.getElementById('after-job-table'))
    }

    var jobTable = document.getElementById('job-table'),
        addJobBtn = document.getElementById('add-job-btn')

    if (jobTable.childElementCount < 4) {
        jobTable.appendChild(parseDom(jobTemplate))
    } else if (jobTable.childElementCount == 4) {
        jobTable.appendChild(parseDom(jobTemplate))
        addJobBtn.setAttribute('class', addJobBtn.getAttribute('class').replace('primary', 'static'))
        addJobBtn.innerHTML = 'Maximum number of rows exceeded'
    }

    encodeTable()
}

function onDelJobClick(e) {
    var jobTable = document.getElementById('job-table'),
        addJobBtn = document.getElementById('add-job-btn')

    jobTable.removeChild(e.parentNode.parentNode)

    if (jobTable.childElementCount == 4) {
        addJobBtn.setAttribute('class', addJobBtn.getAttribute('class').replace('static', 'primary'))
        addJobBtn.innerHTML = 'Add'
    } else if (!jobTable.childElementCount) {
        document.getElementById('resume').removeChild(document.getElementById('job-table-container'))
    }

    encodeTable()
}

function onVarify(e, isJobTime = false, isSelector = false) {
    if (isSelector) {
        if (e.value == '0') {
            document.getElementById(e.name + '-warning').classList.add('display')
            e.parentNode.classList.add('is-danger')
        } else {
            document.getElementById(e.name + '-warning').classList.remove('display')
            e.parentNode.classList.remove('is-danger')
        }
    } else if (isJobTime) {
        var index = e.id.replace(/[^0-9]/ig, ''),
            fromInput = document.getElementById('jobs[' + index + '][from]'),
            toInput = document.getElementById('jobs[' + index + '][to]')
        if (verify('jobs[' + index + '][from]') && verify('jobs[' + index + '][to]') && parseInt(fromInput.value) <= parseInt(toInput.value)) {
            document.getElementById('jobs[' + index + '][time]-warning').classList.remove('display')
            fromInput.classList.remove('is-danger')
            toInput.classList.remove('is-danger')
        } else {
            document.getElementById('jobs[' + index + '][time]-warning').classList.add('display')
            fromInput.classList.add('is-danger')
            toInput.classList.add('is-danger')
        }
    } else {
        if (verify(e.id)) {
            document.getElementById(e.id + '-warning').classList.remove('display')
            e.classList.remove('is-danger')
        } else {
            document.getElementById(e.id + '-warning').classList.add('display')
            e.classList.add('is-danger')
        }
    }
}

function onSubmit() {
    window.event.returnValue = false

    var formData = new FormData(document.getElementById('resume')),
        awardList = [],
        jobList = []

    for (var i = 0; i < document.getElementsByName('award-title').length; i++) {
        awardList.push({
            time: document.getElementById('awards[' + i.toString() + '][time]').value,
            level: document.getElementById('awards[' + i.toString() + '][level]').value,
            title: document.getElementById('awards[' + i.toString() + '][title]').value
        })
    }

    for (var i = 0; i < document.getElementsByName('job-title').length; i++) {
        jobList.push({
            from: document.getElementById('jobs[' + i.toString() + '][from]').value,
            to: document.getElementById('jobs[' + i.toString() + '][to]').value,
            company: document.getElementById('jobs[' + i.toString() + '][company]').value,
            title: document.getElementById('jobs[' + i.toString() + '][title]').value,
        })
    }

    formData.append('awards', JSON.stringify(awardList))
    formData.append('jobs', JSON.stringify(jobList))

    $.ajax({
        type: 'POST',
        url: 'resume-submit.php',
        cache: false,
        contentType: false,
        processData: false,
        data: formData,
        timeout: 5000,
        success: function (res) {
            if (res.success) {
                document.getElementById('message-success').classList.add('display')
                window.location.href = res.url
            } else {
                document.getElementById('message-body').innerHTML = res.errMsg
                document.getElementById('message-error').classList.add('display')
            }
        },
        error: function () {
            document.getElementById('message-body').innerHTML = 'Connection lost'
            document.getElementById('message-error').classList.add('display')
        }
    })
}

function onCloseSuccess() {
    document.getElementById('message-success').classList.remove('display')
}

function onCloseError() {
    document.getElementById('message-error').classList.remove('display')
}

function onEditClick() {
    window.event.returnValue = false
    window.location.href = 'resume-edit.php'
}

function onCancelClick() {
    window.event.returnValue = false
    window.location.href = 'resume-preview.php'
}

function onLogoutClick() {
    window.event.returnValue = false
    window.location.href = 'logout.php'
}

drawChart()
remarktAdaptaion()
encodeTable()
