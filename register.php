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

include 'php/verification.php';

if (!verify($_POST, $regListUser)) {
    $data = array('success' => false, 'errMsg' => 'Invalid username or password');
    exit(json_encode($data));
}

include 'php/mysql.php';

if (hasUser($conn, $_POST['username'])) {
    $data = array('success' => false, 'errMsg' => 'User exists');
    exit(json_encode($data));
}

$salt = getSalt();
$hash = md5($_POST['password'] . $salt);

$sql_stmt = $conn->prepare(SQL_INSERT_USER);
$sql_stmt->bind_param('sss', $_POST['username'], $salt, $hash);
$sql_success = $sql_stmt->execute();
$sql_stmt->close();

$conn->close();

if ($sql_success) {
    session_start();
    $_SESSION['username'] = $_POST['username'];
    $data = array('success' => true, 'url' => 'resume-edit.php');
} else {
    $data = array('success' => false, 'errMsg' => 'Unknown error');
}

exit(json_encode($data));
