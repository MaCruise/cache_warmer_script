<?php
include_once('layout/head.php');
include_once('layout/content-top.php');

if (!$session->is_signed_in()) {
    redirect('login.php');
}

var_dump($_POST);
if (isset($_POST) && !empty($_POST) && isset($_POST['submit']) && ($_POST['submit'] == 'Create')) {

    if (User::if_exists('username', trim($_POST['username']))) {

         $session->message('Username already exists');

    } elseif (User::if_exists('email', trim($_POST['email']))) {

         $session->message('Username already exists');

    } else {

        $user = new User;
        if ($user) {
            $user->username = trim($_POST['username']);
            $user->email = trim($_POST['email']);
            $user->password = hash('sha256', trim($_POST['password']));
            $user->create();
            $_SESSION['message'] = 'User created';
            redirect('users.php');
        } else {
            $_SESSION['message'] = 'Problem accured during update';
            redirect('add_user.php');
        }
    } redirect('add_user.php');
}


?>
<section class="row mt-4">
    <div class="shadow border rounded mx-auto my-auto w-25 ">
        <?php  if(isset($session->message)){ ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <?= $session->message?>
                <a href="unset_message.php" type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>
            <?php } ?>
        <?php
        $session->check_message();
         ?>


        <div class="card-header"><p>Create user</p></div>
        <form method="POST" action="add_user.php" class="form-group p-4 ">
            <label for="username">Username: </label>
            <input type="text" name="username" class="form-control">
            <label for="email">Email: </label>
            <input type="email" name="email" class="form-control" required>
            <label for="password">Password: </label>
            <input type="password" name="password" class="form-control">
            <div class="border-0 d-flex justify-content-around mt-4">
                <input type="submit" name="submit" value="Create" class="btn shadow-sm border">
            </div>


        </form>
    </div>

</section>


<?php
include('layout/footer.php');

?>


