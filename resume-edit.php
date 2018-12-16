<?php
include './php/session.php';

header('content-type:text/html; charset=utf8');

// 连接数据库
include './php/mysql.php';

// 检查用户是否存在
if (!hasUser($_SESSION['username'])) {
    echo "<script>alert('用户不存在，请先登录！'); window.location.href = 'index.html';</script>";
    $conn->close();
    exit();
}

// 读取简历信息
$sql_stmt = $conn->prepare(SQL_SELECT_RESUME);
$sql_stmt->bind_param('s', $_SESSION['username']);
$sql_stmt->bind_result($name, $sex, $avatarUrl, $birthdate, $birthplace, $cellphone, $email, $residence, $address, $education, $school, $major, $awards, $work_time, $job_status, $salary_type, $salary, $jobs, $cpp_ability, $py_ability, $java_ability, $cs_ability, $git_ability, $latax_ability, $statement, $last_modify);
$sql_stmt->execute();
$sql_stmt->fetch();
$sql_stmt->close();

// 断开数据库连接
$conn->close();

// 解析 json 字符串
$awards = $awards ? json_decode($awards, true) : false;
$jobs = $jobs ? json_decode($jobs, true) : false;

// 格式化时间
$birthdate = strtotime($birthdate) ? date('Y-m-d', strtotime($birthdate)) : '';
?>

<!-- Created by Ye Liu -->

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>简历编辑<?php echo $name ? ' - ' . $name : ''; ?></title>
    <link rel="shortcut icon" href="./static/assets/favicon.ico">
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./static/css/background.css">
    <link rel="stylesheet" href="./static/css/bulma.modified.min.css">
    <link rel="stylesheet" href="./static/css/resume.css">
    <link rel="stylesheet" href="./static/css/chart.css">
    <script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/jquery.transit/0.9.12/jquery.transit.min.js"></script>
    <script src="./static/lib/verification.js"></script>
</head>

<body>
    <section class="hero is-info">
        <div class="hero-body">
            <div class="container">
                <h1 class="title">请完善您的简历</h1>
                <h3 class="subtitle is-7">最后修改时间：<?php echo $last_modify ? $last_modify : '无'; ?></h3>
            </div>
        </div>
    </section>

    <section class="container">
        <form id="resume" class="resume">
            <div class="columns is-rtl">
                <div class="column is-3 is-align-center is-ltr">
                    <img id="avatar" class="avatar" <?php
if ($avatarUrl) {
    echo 'src="./static/assets/transparent.png"';
    echo 'style="background-image: url(' . $avatarUrl . ');"';
} else {
    echo 'src="./static/assets/' . (!$sex || $sex == 'male' ? 'male.png"' : 'female.png"');
} ?>>
                    <div class="file">
                        <label class="file-label is-align-center">
                            <input id="avatar-input" class="file-input" type="file" name="avatar" accept="image/*" onchange="displayAvatar()">
                            <span class="file-cta">
                                <span class="file-icon">
                                    <i class="fa fa-upload"></i>
                                </span>
                                <span class="file-label">选择照片</span>
                            </span>
                        </label>
                    </div>
                    <p id="avatar-warning" class="help is-danger">图片大小超过限制（2MB）</p>
                </div>

                <div class="column is-4 is-edit is-middle is-ltr">
                    <canvas id="chart" height="110px">This browser does not support HTML5 Canvas.</canvas>
                    <div class="flex-container">
                        <div class="chart-label">
                            <div class="label-icon cpp-slider"></div>
                            <label class="label-text">C/C++</label>
                        </div>
                        <div class="chart-label">
                            <div class="label-icon py-slider"></div>
                            <label class="label-text">Python</label>
                        </div>
                        <div class="chart-label">
                            <div class="label-icon java-slider"></div>
                            <label class="label-text">JAVA</label>
                        </div>
                    </div>
                    <div class="flex-container">
                        <div class="chart-label">
                            <div class="label-icon cs-slider"></div>
                            <label class="label-text">C#</label>
                        </div>
                        <div class="chart-label">
                            <div class="label-icon git-slider"></div>
                            <label class="label-text">Git</label>
                        </div>
                        <div class="chart-label">
                            <div class="label-icon latax-slider"></div>
                            <label class="label-text">LaTaX</label>
                        </div>
                    </div>
                </div>

                <div class="column is-5 is-ltr">
                    <div class="field">
                        <label class="label">用户名</label>
                        <div class="control has-indent">
                            <input class="input is-static is-grey" type="text" name="username" value="<?php echo $_SESSION['username']; ?>" readonly>
                        </div>
                    </div>

                    <div class="columns">
                        <div class="column is-three-fifths">
                            <label class="label">姓名</label>
                            <div class="control has-icons-left">
                                <input id="name" class="input" type="text" name="name" data-valid="15 isNotEmpty isName" value="<?php echo $name; ?>" onblur="onVarify(this)">
                                <span class="icon is-small is-left">
                                    <i class="fa fa-user"></i>
                                </span>
                                <p id="name-warning" class="help is-danger">不是有效的姓名</p>
                            </div>
                        </div>
                        <div class="column is-two-fifth">
                            <label class="label">性别</label>
                            <div class="control is-radio">
                                <label class="radio"><input class="radio-icon" type="radio" name="sex" value="male" onclick="onSexClick(this.value)" <?php if ($sex == 'male') {echo 'checked';} ?>>男</label>
                                <label class="radio"><input class="radio-icon" type="radio" name="sex" value="female" onclick="onSexClick(this.value)" <?php if ($sex == 'female') {echo 'checked';} ?>>女</label>
                            </div>
                        </div>
                    </div>

                    <div class="columns">
                        <div class="column is-three-fifths">
                            <label class="label">出生日期</label>
                            <div class="control has-icons-left">
                                <input type="date" class="input" type="text" name="birthdate" value="<?php echo $birthdate; ?>" onblur="onVarify(this)">
                                <span class="icon is-small is-left">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </div>
                        </div>
                        <div class="column is-two-fifth">
                            <label class="label">籍贯</label>
                            <div class="control has-icons-left">
                                <input id="birthplace" class="input" type="text" name="birthplace" data-valid="10 isNotEmpty isNormalStr" value="<?php echo $birthplace; ?>" onblur="onVarify(this)">
                                <span class="icon is-small is-left">
                                    <i class="fa fa-address-book-o"></i>
                                </span>
                                <p id="birthplace-warning" class="help is-danger">不是有效的籍贯</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="line"></div>

            <div class="columns">
                <div class="column is-half">
                    <label class="label">手机号码</label>
                    <div class="control has-icons-left">
                        <input id="cellphone" class="input" type="tel" name="cellphone" data-valid="11 isNotEmpty isNum" value="<?php echo $cellphone; ?>" onblur="onVarify(this)">
                        <span class="icon is-small is-left">
                            <i class="fa fa-phone"></i>
                        </span>
                        <p id="cellphone-warning" class="help is-danger">不是有效的手机号码（无须加区号）</p>
                    </div>
                </div>

                <div class="column is-half">
                    <label class="label">Email</label>
                    <div class="control has-icons-left">
                        <input id="email" class="input" type="email" name="email" data-valid="30 isNotEmpty isEmail" value="<?php echo $email; ?>" onblur="onVarify(this)">
                        <span class="icon is-small is-left">
                            <i class="fa fa-envelope"></i>
                        </span>
                        <p id="email-warning" class="help is-danger">不是有效的邮箱地址</p>
                    </div>
                </div>
            </div>

            <div class="columns">
                <div class="column is-half">
                    <label class="label">户口</label>
                    <div class="control has-icons-left">
                        <input id="residence" class="input" type="text" name="residence" data-valid="50 isNotEmpty isNormalStr" value="<?php echo $residence; ?>" onblur="onVarify(this)">
                        <span class="icon is-small is-left">
                            <i class="fa fa-address-card-o"></i>
                        </span>
                        <p id="residence-warning" class="help is-danger">不是有效的户口地址</p>
                    </div>
                </div>

                <div class="column is-half">
                    <label class="label">居住地</label>
                    <div class="control has-icons-left">
                        <input id="address" class="input" type="text" name="address" data-valid="50 isNotEmpty isNormalStr" value="<?php echo $address; ?>" onblur="onVarify(this)">
                        <span class="icon is-small is-left">
                            <i class="fa fa-home"></i>
                        </span>
                        <p id="address-warning" class="help is-danger">不是有效的居住地址</p>
                    </div>
                </div>
            </div>

            <div class="columns">
                <div class="column is-2">
                    <label class="label">学历</label>
                    <div class="select">
                        <select name="education" onchange="onVarify(this, false, true)">
                            <option value="0" <?php if ($education == '0') {echo 'selected';} ?>>请选择</option>
                            <option value="1" <?php if ($education == '1') {echo 'selected';} ?>>高中及以下</option>
                            <option value="2" <?php if ($education == '2') {echo 'selected';} ?>>专科</option>
                            <option value="3" <?php if ($education == '3') {echo 'selected';} ?>>本科</option>
                            <option value="4" <?php if ($education == '4') {echo 'selected';} ?>>硕士</option>
                            <option value="5" <?php if ($education == '5') {echo 'selected';} ?>>博士</option>
                        </select>
                    </div>
                    <p id="education-warning" class="help is-danger">请选择学历</p>
                </div>

                <div class="column is-4">
                    <label class="label">毕业院校</label>
                    <div class="control has-icons-left">
                        <input id="school" class="input" type="text" name="school" data-valid="20 isNotEmpty isNormalStr" value="<?php echo $school; ?>" onblur="onVarify(this)">
                        <span class="icon is-small is-left">
                            <i class="fa fa-university"></i>
                        </span>
                        <p id="school-warning" class="help is-danger">不是有效的毕业院校名称</p>
                    </div>
                </div>

                <div class="column is-4">
                    <label class="label">专业</label>
                    <div class="control has-icons-left">
                        <input id="major" class="input" type="text" name="major" data-valid="20 isNotEmpty isNormalStr" value="<?php echo $major; ?>" onblur="onVarify(this)">
                        <span class="icon is-small is-left">
                            <i class="fa fa-mortar-board"></i>
                        </span>
                        <p id="major-warning" class="help is-danger">不是有效的专业名称</p>
                    </div>
                </div>

                <div class="column is-2">
                    <label class="label">获奖经历</label>
                    <a id="add-award-btn" class="button is-primary" onclick="onAddAwardClick()">添加一项</a>
                </div>
            </div>

<?php if (!empty($awards)) {
    include './php/awards-edit.php';
    appendAwards($awards);
} ?>

            <div id="after-award-table" class="columns">
                <div class="column is-2">
                    <label class="label">工作年限</label>
                    <div class="select">
                        <select name="work-time" onchange="onVarify(this, false, true)">
                            <option value="0" <?php if ($work_time == '0') {echo 'selected';} ?>>请选择</option>
                            <option value="1" <?php if ($work_time == '1') {echo 'selected';} ?>>一年及以内</option>
                            <option value="2" <?php if ($work_time == '2') {echo 'selected';} ?>>一至三年</option>
                            <option value="3" <?php if ($work_time == '3') {echo 'selected';} ?>>三至五年</option>
                            <option value="4" <?php if ($work_time == '4') {echo 'selected';} ?>>五至十年</option>
                            <option value="5" <?php if ($work_time == '5') {echo 'selected';} ?>>十年及以上</option>
                        </select>
                    </div>
                    <p id="work-time-warning" class="help is-danger">请选择工作年限</p>
                </div>

                <div class="column is-4">
                    <label class="label">求职状态</label>
                    <div class="control has-icons-left">
                        <input id="job-status" class="input" type="text" name="job-status" data-valid="30 isNotEmpty isNormalStr" value="<?php echo $job_status; ?>" onblur="onVarify(this)">
                        <span class="icon is-small is-left">
                            <i class="fa fa-line-chart"></i>
                        </span>
                        <p id="job-status-warning" class="help is-danger">不是有效的求职状态描述</p>
                    </div>
                </div>

                <div class="column is-4">
                    <label class="label">期望薪资</label>
                    <div class="control">
                        <div class="field has-addons">
                            <p class="control">
                                <span class="select">
                                    <select name="salary-type">
                                        <option value="0" <?php if ($salary_type == '0') {echo 'selected';} ?>>年薪</option>
                                        <option value="1" <?php if ($salary_type == '1') {echo 'selected';} ?>>月薪</option>
                                        <option value="2" <?php if ($salary_type == '2') {echo 'selected';} ?>>周薪</option>
                                        <option value="3" <?php if ($salary_type == '3') {echo 'selected';} ?>>日薪</option>
                                    </select>
                                </span>
                            </p>
                            <p class="control"><input id="salary" class="input is-align-right" type="text" name="salary" data-valid="10 isNotEmpty isNum" value="<?php echo $salary; ?>" onblur="onVarify(this)"></p>
                            <p class="control"><a class="button is-static">元人民币</a></p>
                        </div>
                        <p id="salary-warning" class="help is-danger is-align-top">不是有效的薪资（输入纯数字即可）</p>
                    </div>
                </div>

                <div class="column is-2">
                    <label class="label">工作经历</label>
                    <a id="add-job-btn" class="button is-primary" onclick="onAddJobClick()">添加一项</a>
                </div>
            </div>

<?php if (!empty($jobs)) {
    include './php/jobs-edit.php';
    appendJobs($jobs);
} ?>

            <div id="after-job-table" class="line"></div>

            <div class="field">
                <label class="label">计算机能力<label>
            </div>

            <div class="columns">
                <div class="column is-1 is-offset-1">
                    <label class="label is-align-right">C/C++</label>
                </div>
                <div class="column is-4">
                    <input id="cpp-slider" class="cpp-slider" type="range" name="cpp-ability" min="1" max="100" value="<?php echo $cpp_ability; ?>" onchange="drawChart()">
                </div>

                <div class="column is-1">
                    <label class="label is-align-right">Python<label>
                </div>
                <div class="column is-4">
                    <input id="py-slider" class="py-slider" type="range" name="py-ability" min="1" max="100" value="<?php echo $py_ability; ?>" onchange="drawChart()">
                </div>
            </div>

            <div class="columns">
                <div class="column is-1 is-offset-1">
                    <label class="label is-align-right">JAVA</label>
                </div>
                <div class="column is-4">
                    <input id="java-slider" class="java-slider" type="range" name="java-ability" min="1" max="100" value="<?php echo $java_ability; ?>" onchange="drawChart()">
                </div>

                <div class="column is-1">
                    <label class="label is-align-right">C#<label>
                </div>
                <div class="column is-4">
                    <input id="cs-slider" class="cs-slider" type="range" name="cs-ability" min="1" max="100" value="<?php echo $cs_ability; ?>" onchange="drawChart()">
                </div>
            </div>

            <div class="columns">
                <div class="column is-1 is-offset-1">
                    <label class="label is-align-right">Git</label>
                </div>
                <div class="column is-4">
                    <input id="git-slider" class="git-slider" type="range" name="git-ability" min="1" max="100" value="<?php echo $git_ability; ?>" onchange="drawChart()">
                </div>

                <div class="column is-1">
                    <label class="label is-align-right">LaTaX<label>
                </div>
                <div class="column is-4">
                    <input id="latax-slider" class="latax-slider" type="range" name="latax-ability" min="1" max="100" value="<?php echo $latax_ability; ?>" onchange="drawChart()">
                </div>
            </div>

            <div class="field">
                <label class="label">个人陈述</label>
                <div class="control">
                    <textarea id="statement" class="textarea" name="statement" placeholder="对简历内容的补充说明" data-valid="256 isNotEmpty isNormalStr" onblur="onVarify(this)"><?php echo $statement; ?></textarea>
                    <p id="statement-warning" class="help is-danger">不是有效的个人陈述</p>
                </div>
            </div>

            <div class="field is-grouped is-gap">
                <div class="control">
                    <button type="submit" class="button is-link" onclick="onSubmit()">提交</button>
                </div>
<?php
if ($name) {
    echo '<div class="control">';
    echo '<button class="button is-light" onclick="onCancelClick()">取消</button>';
    echo '</div>';
}
?>
            </div>
        </form>
    </section>

    <article id="message" class="message is-danger is-bottom-right">
        <div class="message-header">
            <p>提示</p>
            <button class="delete" onclick="onCloseMessage()"></button>
        </div>
        <div id="message-body" class="message-body"></div>
    </article>
</body>

<script src="./static/lib/background.js"></script>
<script src="./static/lib/template.js"></script>
<script src="./static/lib/resume.js"></script>

</html>
