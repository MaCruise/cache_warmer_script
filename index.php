<?php

include ('layout/head.php');

include ('layout/content-top.php');

if (!$session->is_signed_in()) {

 redirect('login.php');

}else{
 redirect('websites.php');
}


include ('layout/footer.php');


 ?>







