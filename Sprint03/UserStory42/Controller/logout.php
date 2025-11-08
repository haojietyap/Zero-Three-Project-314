<?php

session_start();
$_SESSION = [];
session_destroy();
header('Location: ../Boundary/login.php?msg=Logged+out');
exit;
