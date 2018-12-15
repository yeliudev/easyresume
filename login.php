<?php
header('Content-Type:application/json; charset=utf-8');

// 连接数据库
include './php/mysql.php';

// 查询用户是否存在
$sql_stmt = $conn->prepare(SQL_SELECT_USER);
$sql_stmt->bind_param('s', $_POST['username']);
$sql_stmt->bind_result($salt, $hash, $name);
$sql_stmt->execute();
$sql_stmt->fetch();
$sql_stmt->close();

if ($salt && $hash) {
    // 计算哈希值
    if ($hash == md5($_POST['password'] . $salt)) {
        // 启动 session 会话
        session_start();
        $_SESSION['username'] = $_POST['username'];

        // 返回 session_id
        $data = array('success' => true, 'url' => $name ? 'resume-preview.php' : 'resume-edit.php');
    } else {
        $data = array('success' => false, 'errMsg' => '用户名或密码有误');
    }
} else {
    $data = array('success' => false, 'errMsg' => '用户不存在，请先注册');
}

exit(json_encode($data));
