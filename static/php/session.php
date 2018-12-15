<?php
header("Content-type: text/html; charset=utf-8");

session_start();
if (!$_SESSION['username']) {
    echo "<script>alert('请先登录！');window.location.href='index.html';</script>";
    exit();
}
