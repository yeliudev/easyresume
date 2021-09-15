<?php
header('Content-Type:application/json; charset=utf-8');

include 'php/verification.php';

if (!verify($_POST, $regListUser)) {
    $data = array('success' => false, 'errMsg' => 'Invalid username or password');
    exit(json_encode($data));
}

include 'php/mysql.php';

$sql_stmt = $conn->prepare(SQL_SELECT_USER);
$sql_stmt->bind_param('s', $_POST['username']);
$sql_stmt->bind_result($salt, $hash, $name);
$sql_stmt->execute();
$sql_stmt->fetch();
$sql_stmt->close();

$conn->close();

if ($salt && $hash) {
    if ($hash == md5($_POST['password'] . $salt)) {
        session_start();
        $_SESSION['username'] = $_POST['username'];
        $data = array('success' => true, 'url' => $name ? 'resume-preview.php' : 'resume-edit.php');
    } else {
        $data = array('success' => false, 'errMsg' => 'Invalid username or password');
    }
} else {
    $data = array('success' => false, 'errMsg' => 'User not found');
}

exit(json_encode($data));
