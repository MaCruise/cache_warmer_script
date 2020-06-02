<?php

include('layout/head.php');
$session->logout();
redirect('login.php');
?>