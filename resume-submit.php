<?php
include 'php/session.php';
include 'php/verification.php';

if (!verify($_POST, $regListResume)) {
    header('Content-Type:application/json; charset=utf-8');
    $data = array('success' => false, 'errMsg' => 'Invalid resume content found');
    exit(json_encode($data));
}

$avatar = $_FILES && !$_FILES['avatar']['error'] && move_uploaded_file($_FILES['avatar']['tmp_name'], 'static/upload/' . $_SESSION['username'] . '.png') ? 'static/upload/' . $_SESSION['username'] . '.png' : false;

include 'php/mysql.php';

if (!hasUser($conn, $_SESSION['username'])) {
    header('content-type:text/html; charset=utf8');
    echo "<script>alert('Please sign in first!');window.location.href='index.html';</script>";
    $conn->close();
    exit();
}

if ($avatar) {
    $sql_stmt = $conn->prepare(SQL_UPDATE_ALL);
    $sql_stmt->bind_param('sssisssssssssssssssssssssis', htmlspecialchars($_POST['name']), htmlspecialchars($_POST['gender']), htmlspecialchars($avatar), strtotime(htmlspecialchars($_POST['birthdate'])), htmlspecialchars($_POST['hometown']), htmlspecialchars($_POST['cellphone']), htmlspecialchars($_POST['email']), htmlspecialchars($_POST['residence']), htmlspecialchars($_POST['address']), htmlspecialchars($_POST['degree']), htmlspecialchars($_POST['institution']), htmlspecialchars($_POST['major']), $_POST['awards'], htmlspecialchars($_POST['working-years']), htmlspecialchars($_POST['job-status']), htmlspecialchars($_POST['salary-type']), htmlspecialchars($_POST['salary']), $_POST['jobs'], htmlspecialchars($_POST['cpp-ability']), htmlspecialchars($_POST['py-ability']), htmlspecialchars($_POST['java-ability']), htmlspecialchars($_POST['cs-ability']), htmlspecialchars($_POST['git-ability']), htmlspecialchars($_POST['latax-ability']), htmlspecialchars($_POST['statement']), time(), $_SESSION['username']);
} else {
    $sql_stmt = $conn->prepare(SQL_UPDATE);
    $sql_stmt->bind_param('ssisssssssssssssssssssssis', htmlspecialchars($_POST['name']), htmlspecialchars($_POST['gender']), strtotime(htmlspecialchars($_POST['birthdate'])), htmlspecialchars($_POST['hometown']), htmlspecialchars($_POST['cellphone']), htmlspecialchars($_POST['email']), htmlspecialchars($_POST['residence']), htmlspecialchars($_POST['address']), htmlspecialchars($_POST['degree']), htmlspecialchars($_POST['institution']), htmlspecialchars($_POST['major']), $_POST['awards'], htmlspecialchars($_POST['working-years']), htmlspecialchars($_POST['job-status']), htmlspecialchars($_POST['salary-type']), htmlspecialchars($_POST['salary']), $_POST['jobs'], htmlspecialchars($_POST['cpp-ability']), htmlspecialchars($_POST['py-ability']), htmlspecialchars($_POST['java-ability']), htmlspecialchars($_POST['cs-ability']), htmlspecialchars($_POST['git-ability']), htmlspecialchars($_POST['latax-ability']), htmlspecialchars($_POST['statement']), time(), $_SESSION['username']);
}

if ($sql_stmt->execute()) {
    $data = array('success' => true, 'url' => 'resume-preview.php');
} else {
    $data = array('success' => false, 'errMsg' => 'Save failed');
}

$sql_stmt->close();
$conn->close();

header('Content-Type:application/json; charset=utf-8');
exit(json_encode($data));
