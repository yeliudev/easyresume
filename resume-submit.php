<?php
include './php/session.php';
include './php/verification.php';

// 校验数据合法性
if (!varify($_POST, $regListResume)) {
    header('Content-Type:application/json; charset=utf-8');
    $data = array('success' => false, 'errMsg' => '简历内容不合法，请检查是否有误');
    exit(json_encode($data));
}

// 保存用户照片
$avatarUrl = $_FILES && !$_FILES['avatar']['error'] && move_uploaded_file($_FILES['avatar']['tmp_name'], './static/upload/' . $_SESSION['username'] . '.png') ? './static/upload/' . $_SESSION['username'] . '.png' : false;

// 连接数据库
include './php/mysql.php';

// 检查用户是否存在
if (!hasUser($_SESSION['username'])) {
    header('content-type:text/html; charset=utf8');
    echo "<script>alert('用户不存在，请先登录！');window.location.href='index.html';</script>";
    $conn->close();
    exit();
}

// 更新简历信息
if ($avatarUrl) {
    $sql_stmt = $conn->prepare(SQL_UPDATE_ALL);
    $sql_stmt->bind_param('sssisssssssssssssssssssssis', htmlspecialchars($_POST['name']), htmlspecialchars($_POST['sex']), htmlspecialchars($avatarUrl), strtotime(htmlspecialchars($_POST['birthdate'])), htmlspecialchars($_POST['birthplace']), htmlspecialchars($_POST['cellphone']), htmlspecialchars($_POST['email']), htmlspecialchars($_POST['residence']), htmlspecialchars($_POST['address']), htmlspecialchars($_POST['education']), htmlspecialchars($_POST['school']), htmlspecialchars($_POST['major']), $_POST['awards'], htmlspecialchars($_POST['work-time']), htmlspecialchars($_POST['job-status']), htmlspecialchars($_POST['salary-type']), htmlspecialchars($_POST['salary']), $_POST['jobs'], htmlspecialchars($_POST['cpp-ability']), htmlspecialchars($_POST['py-ability']), htmlspecialchars($_POST['java-ability']), htmlspecialchars($_POST['cs-ability']), htmlspecialchars($_POST['git-ability']), htmlspecialchars($_POST['latax-ability']), htmlspecialchars($_POST['statement']), time(), $_SESSION['username']);
} else {
    $sql_stmt = $conn->prepare(SQL_UPDATE);
    $sql_stmt->bind_param('ssisssssssssssssssssssssis', htmlspecialchars($_POST['name']), htmlspecialchars($_POST['sex']), strtotime(htmlspecialchars($_POST['birthdate'])), htmlspecialchars($_POST['birthplace']), htmlspecialchars($_POST['cellphone']), htmlspecialchars($_POST['email']), htmlspecialchars($_POST['residence']), htmlspecialchars($_POST['address']), htmlspecialchars($_POST['education']), htmlspecialchars($_POST['school']), htmlspecialchars($_POST['major']), $_POST['awards'], htmlspecialchars($_POST['work-time']), htmlspecialchars($_POST['job-status']), htmlspecialchars($_POST['salary-type']), htmlspecialchars($_POST['salary']), $_POST['jobs'], htmlspecialchars($_POST['cpp-ability']), htmlspecialchars($_POST['py-ability']), htmlspecialchars($_POST['java-ability']), htmlspecialchars($_POST['cs-ability']), htmlspecialchars($_POST['git-ability']), htmlspecialchars($_POST['latax-ability']), htmlspecialchars($_POST['statement']), time(), $_SESSION['username']);
}

if ($sql_stmt->execute()) {
    $data = array('success' => true, 'url' => 'resume-preview.php');
} else {
    $data = array('success' => false, 'errMsg' => '简历信息保存失败，请稍后重试');
}

// 断开数据库连接
$sql_stmt->close();
$conn->close();

header('Content-Type:application/json; charset=utf-8');
exit(json_encode($data));
