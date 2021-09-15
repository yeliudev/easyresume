<?php
session_start();

if (!$_SESSION['username']) {
    header("Content-type: text/html; charset=utf-8");
    echo "<script>alert('Please sign in first!');window.location.href='index.html';</script>";
    exit();
}
