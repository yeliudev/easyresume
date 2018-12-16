<?php
session_start();

if (!$_SESSION['username']) {
    header("Content-type: text/html; charset=utf-8");
    echo "<script>alert('请先登录！');window.location.href='index.html';</script>";
    exit();
}
