<?php
require('./class/header.php');
session_destroy();
header("location: http://messbox.2017.hctf.io/index.php");
?>