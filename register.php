<?php
header('Content-Type:application/json; charset=utf-8');

function getSalt()
{
    $nounce = '';
    $pool = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';

    for ($i = 0; $i < 8; $i++) {
        $nounce .= $pool[rand(0, 61)];
    }

    return $nounce;
}

// 连接数据库
include './php/mysql.php';

// 查询用户是否存在
$sql_stmt = $conn->prepare(SQL_CHECK);
$sql_stmt->bind_param('s', $_POST['username']);
$sql_stmt->bind_result($hasRow);
$sql_stmt->execute();
$sql_stmt->fetch();
$sql_stmt->close();

if ($hasRow) {
    $data = array('success' => false, 'errMsg' => '用户已存在，请直接登录');
} else {
    // 计算哈希值
    $salt = getSalt();
    $hash = md5($_POST['password'] . $salt);

    // 添加新用户信息
    $sql_stmt = $conn->prepare(SQL_INSERT);
    $sql_stmt->bind_param('sss', $_POST['username'], $salt, $hash);
    $sql_success = $sql_stmt->execute();
    $sql_stmt->close();

    // 断开数据库连接
    $conn->close();

    if ($sql_success) {
        // 启动 session 会话
        session_start();
        $_SESSION['username'] = $_POST['username'];

        // 返回 session_id
        $data = array('success' => true, 'url' => 'resume-edit.php');
    } else {
        $data = array('success' => false, 'errMsg' => '注册失败，请稍后重试');
    }
}

exit(json_encode($data));
