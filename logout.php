<?php
session_start();
session_destroy();

header('content-type:text/html; charset=utf8');
echo "<script>window.location.href='index.html';</script>";
