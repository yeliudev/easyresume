<?php
include './php/session.php';

header('content-type:text/html; charset=utf8');

// 连接数据库
include './php/mysql.php';

// 查询用户是否存在
$sql_stmt = $conn->prepare(SQL_CHECK);
$sql_stmt->bind_param('s', $_SESSION['username']);
$sql_stmt->bind_result($hasRow);
$sql_stmt->execute();
$sql_stmt->fetch();
$sql_stmt->close();

if (!$hasRow) {
    echo "<script>alert('用户不存在，请先登录！');window.location.href='index.html';</script>";
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

if (!$name) {
    echo "<script>alert('请先填写简历内容！');window.location.href='resume-edit.php';</script>";
    exit();
}

// 解析 json 字符串
$awards = $awards ? json_decode($awards, true) : false;
$jobs = $jobs ? json_decode($jobs, true) : false;

// 格式化时间
$birthdate = date('Y-m-d', strtotime($birthdate));
?>

<!-- Created by Ye Liu -->

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>简历预览 - <?php echo $name; ?></title>
    <link rel="shortcut icon" href="./static/assets/favicon.ico">
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./static/css/background.css">
    <link rel="stylesheet" href="./static/css/bulma.modified.min.css">
    <link rel="stylesheet" href="./static/css/resume.css">
    <link rel="stylesheet" href="./static/css/chart.css">
    <script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/jquery.transit/0.9.12/jquery.transit.min.js"></script>
</head>

<body>
    <section class="hero is-info">
        <div class="hero-body">
            <div class="container">
                <h1 class="title"><?php echo $name; ?>的简历</h1>
                <h3 class="subtitle is-7">最后修改时间：<?php echo $last_modify; ?></h3>
            </div>
        </div>
    </section>

    <section class="container">
        <form class="resume">
            <div class="columns is-rtl">
                <div class="column is-3 is-middle is-ltr">
                    <img id="avatar" class="avatar" <?php
if ($avatarUrl) {
    echo 'src="./static/assets/transparent.png"';
    echo 'style="background-image: url(' . $avatarUrl . ');"';
} else {
    echo 'src="./static/assets/' . ($sex == 'male' ? 'male.png"' : 'female.png"');
} ?>>
                </div>

                <div class="column is-4 is-preview is-middle is-ltr">
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
                            <input class="input is-static is-grey" type="text" value="<?php echo $_SESSION['username']; ?>" readonly>
                        </div>
                    </div>

                    <div class="columns">
                        <div class="column is-three-fifths">
                            <label class="label">姓名</label>
                            <div class="control">
                                <input class="input is-static" type="text" value="<?php echo $name; ?>" readonly>
                            </div>
                        </div>
                        <div class="column is-two-fifth">
                            <label class="label">性别</label>
                            <div class="control">
                                <input class="input is-static" type="text" value="<?php echo $sex == 'male' ? '男' : '女'; ?>" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="columns">
                        <div class="column is-three-fifths">
                            <label class="label">出生日期</label>
                            <div class="control">
                                <input class="input is-static" type="date" value="<?php echo $birthdate; ?>" readonly>
                            </div>
                        </div>
                        <div class="column is-two-fifth">
                            <label class="label">籍贯</label>
                            <div class="control">
                                <input class="input is-static" type="text" value="<?php echo $birthplace; ?>" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="line"></div>

            <div class="columns">
                <div class="column is-half">
                    <label class="label">手机号码</label>
                    <div class="control">
                        <input class="input is-static" type="tel" value="<?php echo $cellphone; ?>" readonly>
                    </div>
                </div>

                <div class="column is-half">
                    <label class="label">Email</label>
                    <div class="control">
                        <input class="input is-static" type="email" value="<?php echo $email; ?>" readonly>
                    </div>
                </div>
            </div>

            <div class="columns">
                <div class="column is-half">
                    <label class="label">户口</label>
                    <div class="control">
                        <input class="input is-static" type="text" value="<?php echo $residence; ?>" readonly>
                    </div>
                </div>

                <div class="column is-half">
                    <label class="label">居住地</label>
                    <div class="control">
                        <input class="input is-static" type="text" value="<?php echo $address; ?>" readonly>
                    </div>
                </div>
            </div>

            <div class="line"></div>

            <div class="columns">
                <div class="column is-2">
                    <label class="label">学历</label>
                    <div class="control">
                        <input class="input is-static" type="text" value="<?php
switch ($education) {
    case 1:
        echo '高中及以下';
        break;
    case 2:
        echo '专科';
        break;
    case 3:
        echo '本科';
        break;
    case 4:
        echo '硕士';
        break;
    case 5:
        echo '博士';
        break;
    default:
        echo '未知';
} ?>" readonly>
                    </div>
                </div>

                <div class="column is-5">
                    <label class="label">毕业院校</label>
                    <div class="control">
                        <input class="input is-static" type="text" value="<?php echo $school; ?>" readonly>
                    </div>
                </div>

                <div class="column is-5">
                    <label class="label">专业</label>
                    <div class="control">
                        <input class="input is-static" type="text" value="<?php echo $major; ?>" readonly>
                    </div>
                </div>
            </div>

<?php if (!empty($awards)) {
    include './php/awards-preview.php';
    appendAwards($awards);
} ?>

            <div class="columns">
                <div class="column is-2">
                    <label class="label">工作年限</label>
                    <div class="control">
                        <input class="input is-static" type="text" value="<?php
switch ($work_time) {
    case 1:
        echo '一年及以内';
        break;
    case 2:
        echo '一至三年';
        break;
    case 3:
        echo '三至五年';
        break;
    case 4:
        echo '五至十年';
        break;
    case 5:
        echo '十年及以上';
        break;
    default:
        echo '未知';
} ?>" readonly>
                    </div>
                </div>

                <div class="column is-5">
                    <label class="label">求职状态</label>
                    <div class="control">
                        <input class="input is-static" type="text" value="<?php echo $job_status; ?>" readonly>
                    </div>
                </div>

                <div class="column is-5">
                    <label class="label">期望薪资</label>
                    <div class="control">
                        <input class="input is-static" type="text" value="<?php
switch ($salary_type) {
    case 0:
        echo '年薪 ';
        break;
    case 1:
        echo '月薪 ';
        break;
    case 2:
        echo '周薪 ';
        break;
    case 3:
        echo '日薪 ';
        break;
    default:
        echo '未知';
        return;
}
echo $salary;
echo ' 元人民币'; ?>" readonly>
                    </div>
                </div>
            </div>

<?php if (!empty($jobs)) {
    include './php/jobs-preview.php';
    appendJobs($jobs);
} ?>

            <div class="line"></div>

            <div class="field">
                <label class="label">计算机能力<label>
            </div>

            <div class="columns">
                <div class="column is-1 is-offset-1">
                    <label class="label is-align-right">C/C++</label>
                </div>
                <div class="column is-4">
                    <progress id="cpp-slider" class="progress is-cpp" max="100" value="<?php echo $cpp_ability; ?>"></progress>
                </div>

                <div class="column is-1">
                    <label class="label is-align-right">Python<label>
                </div>
                <div class="column is-4">
                    <progress id="py-slider" class="progress is-py" max="100" value="<?php echo $py_ability; ?>"></progress>
                </div>
            </div>

            <div class="columns">
                <div class="column is-1 is-offset-1">
                    <label class="label is-align-right">JAVA</label>
                </div>
                <div class="column is-4">
                    <progress id="java-slider" class="progress is-java" max="100" value="<?php echo $java_ability; ?>"></progress>
                </div>

                <div class="column is-1">
                    <label class="label is-align-right">C#<label>
                </div>
                <div class="column is-4">
                    <progress id="cs-slider" class="progress is-cs" max="100" value="<?php echo $cs_ability; ?>"></progress>
                </div>
            </div>

            <div class="columns">
                <div class="column is-1 is-offset-1">
                    <label class="label is-align-right">Git</label>
                </div>
                <div class="column is-4">
                    <progress id="git-slider" class="progress is-git" max="100" value="<?php echo $git_ability; ?>"></progress>
                </div>

                <div class="column is-1">
                    <label class="label is-align-right">LaTaX<label>
                </div>
                <div class="column is-4">
                    <progress id="latax-slider" class="progress is-latax" max="100" value="<?php echo $latax_ability; ?>"></progress>
                </div>
            </div>

            <div class="field">
                <label class="label">个人陈述</label>
                <div class="control">
                    <textarea id="statement-preview" class="input is-static is-dark-grey" readonly><?php echo $statement ? $statement : '无'; ?></textarea>
                </div>
            </div>

            <div class="field is-grouped is-gap">
                <div class="control">
                    <button class="button is-primary" onclick="onEditClick()">编辑</button>
                </div>
                <div class="control">
                    <button class="button is-light" onclick="onLogoutClick()">退出</button>
                </div>
            </div>
        </form>
    </section>
</body>

<script src="./static/lib/background.js"></script>
<script src="./static/lib/template.js"></script>
<script src="./static/lib/resume.js"></script>

</html>
