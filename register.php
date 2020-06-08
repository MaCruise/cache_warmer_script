<?php
include('layout/head.php');

if(!User::has_user()){
    redirect('login.php');
}
if (!empty($_POST) && isset($_POST['submit']) && ($_POST['submit']=='Register')) {


    $user = new User;
        if($user) {
            $user->username = trim($_POST['username']);
            $user->password = hash('sha256', trim($_POST['password']));
            $user->create();
            redirect('login.php');
        }




}


?>
<section class="row vh-100">
    <div class="shadow border rounded mx-auto my-auto w-25">
        <?php  if(isset($_SESSION['message'])){ ?>
        <div class="alert alert-warning alert-dismissible fade show alert-message" role="alert">
            <?= $_SESSION['message']?>
            <a  type='button' class='close' onclick="$('.alert-message').hide()"  >
                <span aria-hidden="true">&times;</span>
            </a>
        </div>
       <?php } ?>

        <form method="post" action="" class="form-group p-4 ">
            <label for="username">Username: </label>
            <input type="text" name="username"  class="form-control">
            <label for="password">Password: </label>
            <input type="password" name="password"  class="form-control">
            <div class="border-0 d-flex justify-content-around mt-4">
                <input type="submit" name="submit" value="Register" class="btn shadow border">
            </div>


        </form>
    </div>

</section>


<?php
include('layout/footer.php')
?>


