<?php
include_once('layout/head.php');
include_once('layout/content-top.php');

if (!$session->is_signed_in()) {
    redirect('login.php');
}


if (empty($_GET['id'])) {
    redirect('users.php');

} else {


    $user = User::find_byId($_GET['id']);

    if($user) {
        if (!empty($_POST) && isset($_POST['submit']) && ($_POST['submit'] == 'Delete' || $_POST['submit'] == 'Delete_User')) {
            $_SESSION['delete_user'] = 'Are you sure?';
            $_POST['submit']==='Delete_User'?redirect("users.php?id=$user->id"):redirect("edit_user.php?id=$user->id");
        } elseif (!empty($_POST) && isset($_POST['submit']) && ($_POST['submit'] == 'Yes')) {
            $user->delete();
            unset($_SESSION['delete_user']);
            redirect('users.php');
        } elseif (!empty($_POST) && isset($_POST['submit']) && $_POST['submit'] == 'No')  {
            unset($_SESSION['delete_user']);
            redirect("edit_user.php?id=$user->id");
        } elseif (!empty($_POST) && isset($_POST['submit_user']) && $_POST['submit_user'] == 'No')  {
            unset($_SESSION['delete_user']);
            redirect("users.php");
        }else {

            if (!empty($_POST) && isset($_POST['submit']) && ($_POST['submit'] == 'Save')) {

                if (User::if_exists('username', trim($_POST['username']))) {
                    $_SESSION['message'] = 'Username already exists';
                    redirect("edit_user.php?id=$user->id");
                } elseif (User::if_exists('email', trim($_POST['email']))) {
                    $_SESSION['message'] = 'Email already exists';
                    redirect("edit_user.php?id=$user->id");
                } else {

                if ($user) {

                        $user->username = trim($_POST['username']);
                        $user->email = trim($_POST['email']);
                        !empty($_POST['password']) ? $user->password = hash('sha256', trim($_POST['password'])) : null;
                        $user->update();
                        $_SESSION['message'] = 'User updated';
                        redirect('users.php');

                    } else {
                        $_SESSION['message'] = 'Problem occured during update';
                        redirect('users.php');
                    }

                }
            }
        }
    }
}

?>
<section class="row mt-4">
    <div class="shadow border rounded mx-auto my-auto w-25 ">
        <?php if (isset($_SESSION['message'])) { ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <?= $_SESSION['message'] ?>
                <a href="" type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>
        <?php } ?>
        <?php if($user){ ?>
        <form method="post" action="edit_user.php?id=<?php echo $user->id; ?>" class="form-group p-4 ">
            <label for="username">Username: </label>
            <input type="text" name="username"  value="<?php echo $user->username ?>" class="form-control" required>
            <label for="email">Email: </label>
            <input type="email" name="email" value="<?php echo $user->email ?>" class="form-control" required>
            <label for="password">Password: </label>
            <input type="password" name="password"  class="form-control" >
            <?php if (!isset($_SESSION['delete_user'])) { ?>
                <div class="border-0 d-flex justify-content-around mt-4">
                    <input type="submit" name="submit" value="Save" class="btn shadow border">
                    <input type="submit" name="submit" value="Delete" class="btn btn-outline-danger shadow">
                </div>
            <?php } ?>
            <?php if (isset($_SESSION['delete_user'])) { ?>
                <div class="border-0 d-flex flex-column mt-4">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <?= $_SESSION['delete_user'] ?>
                        <a href="" type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </a>
                    </div>
                    <div class="border-0 d-flex justify-content-around">
                        <input type="submit" name="submit" value="No" class="btn shadow border">
                        <input type="submit" name="submit" value="Yes" class="btn btn-outline-danger shadow">
                    </div>
                </div>
            <?php } ?>

        </form>
        <?php
        }else{
            redirect('users.php');
        }
         ?>
    </div>

</section>


<?php
include('layout/footer.php')
?>


