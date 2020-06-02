<?php

include ('layout/head.php');

include ('layout/content-top.php');

if (!$session->is_signed_in()) {

    redirect('login.php');

}

if (empty($_GET['id'])) {
    redirect('users');

}
redirect('users.php');

include ('layout/footer.php');


?>

