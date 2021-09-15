/* Written by Ye Liu */

'use strict'

var awardTableTemplate = '<div id="award-table" class="column is-10 is-offset-1 is-table"></div>',
    jobTableTemplate = '<div id="job-table" class="column is-10 is-offset-1 is-table"></div>',
    awardTemplate = '\
                        <div class="column is-2">\
                            <div class="control">\
                                <input class="input" type="text" name="award-time" placeholder="Year" data-valid="4 isNotEmpty isNum" onblur="onVarify(this)">\
                                <p name="award-time-warning" class="help is-danger">Invalid year</p>\
                            </div>\
                        </div>\
                        \
                        <div class="column is-2">\
                            <div class="select">\
                                <select name="award-level">\
                                    <option value="0">Collegewide</option>\
                                    <option value="1">Citywide</option>\
                                    <option value="2">Statewide</option>\
                                    <option value="3">Nationwide</option>\
                                    <option value="4">Worldwide</option>\
                                </select>\
                            </div>\
                        </div>\
                        \
                        <div class="column is-7">\
                            <div class="control has-icons-left">\
                                <input class="input" type="text" name="award-title" placeholder="Award Name" data-valid="50 isNotEmpty isNormalStr" onblur="onVarify(this)">\
                                <span class="icon is-small is-left">\
                                    <i class="fa fa-trophy"></i>\
                                </span>\
                                <p name="award-title-warning" class="help is-danger">Invalid award name</p>\
                            </div>\
                        </div>\
                        \
                        <div class="column is-1 is-middle">\
                            <a class="delete" onclick="onDelAwardClick(this)"></a>\
                        </div>\
                    ',
    jobTemplate = '\
                        <div class="column is-3">\
                            <div class="control">\
                                <div class="field has-addons is-year">\
                                    <p class="control">\
                                        <input class="input" type="text" name="job-from-time" placeholder="Year" data-valid="4 isNotEmpty isNum" onblur="onVarify(this, true)">\
                                    </p>\
                                    <p class="control">\
                                        <a class="button is-static">to</a>\
                                    </p>\
                                    <p class="control">\
                                        <input class="input" type="text" name="job-to-time" placeholder="Year" data-valid="4 isNotEmpty isNum" onblur="onVarify(this, true)">\
                                    </p>\
                                </div>\
                                <p name="job-time-warning" class="help is-danger is-align-top">Invalid job period</p>\
                            </div>\
                        </div>\
                        \
                        <div class="column is-5">\
                            <div class="control has-icons-left">\
                                <input class="input" type="text" name="job-company" placeholder="Company Name" data-valid="30 isNotEmpty isNormalStr" onblur="onVarify(this)">\
                                <span class="icon is-small is-left">\
                                    <i class="fa fa-building"></i>\
                                </span>\
                                <p name="job-company-warning" class="help is-danger">Invalid company name</p>\
                            </div>\
                        </div>\
                        \
                        <div class="column is-3">\
                            <div class="control has-icons-left">\
                                <input class="input" type="text" name="job-title" placeholder="Position" data-valid="20 isNotEmpty isNormalStr" onblur="onVarify(this)">\
                                <span class="icon is-small is-left">\
                                    <i class="fa fa-puzzle-piece"></i>\
                                </span>\
                                <p name="job-title-warning" class="help is-danger">Invalid position</p>\
                            </div>\
                        </div>\
                        \
                        <div class="column is-1 is-middle">\
                            <a class="delete" onclick="onDelJobClick(this)"></a>\
                        </div>\
                    '
