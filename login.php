<?php
include('layout/head.php');
if ($session->is_signed_in()) {

    redirect('index.php');

}
if (isset($_POST['submit'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $user_found = User::verify_user($username, $password);

    if ($user_found) {

        $session->login($user_found);
        redirect('index.php');
    } else {
        $session->message('Validation error, try again');
    }

}else{
$username = "";
$password = "";



}
?>
<section class="row vh-100">
    <div class="shadow border rounded mx-auto my-auto w-25">
        <?php  if(isset($_SESSION['message'])){ ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <?= $_SESSION['message']?>
            <a href="unset_message.php" type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </a>
        </div>
       <?php } ?>
       <!-- --><?php
/*        $session->check_message();
        */?>
        <form method="post" action="" class="form-group p-4 ">
            <label for="username">Username: </label>
            <input type="text" name="username" class="form-control">
            <label for="password">Password: </label>
            <input type="password" name="password" class="form-control">
            <div class="border-0 d-flex justify-content-around mt-4">
                <input type="submit" name="submit" class="btn shadow border">
                <?php if(User::has_user()){?>

                    <a href="register.php" class="btn shadow border"> Register</a>

                 <?php } ?>
            </div>


        </form>
    </div>

</section>


<?php
include('layout/footer.php')
?>


