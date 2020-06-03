<?php
include_once('layout/head.php');
include_once('layout/content-top.php');

if (!$session->is_signed_in()) {
    redirect('login.php');
}


if (empty($_GET['id'])) {
    redirect('frameworks.php');

} else {

    $framework = Framework::find_byId($_GET['id']);

    if ($framework) {
        if (!empty($_POST) && isset($_POST['submit']) && ($_POST['submit'] == 'Delete' || $_POST['submit'] == 'Delete_Framework')) {
            $_SESSION['delete_framework'] = 'Are you sure?';
            $_POST['submit'] === 'Delete_Framework' ? redirect("frameworks.php?id=$framework->id") : redirect("edit_framework.php?id=$framework->id");
        } elseif (!empty($_POST) && isset($_POST['submit']) && ($_POST['submit'] == 'Yes')) {

            $framework->delete();
            unset($_SESSION['delete_framework']);
            redirect('frameworks.php');
        } elseif (!empty($_POST) && isset($_POST['submit']) && $_POST['submit'] == 'No') {

            unset($_SESSION['delete_framework']);
            redirect("edit_framework.php?id=$framework->id");

        } elseif (!empty($_POST) && isset($_POST['submit_framework']) && $_POST['submit_framework'] == 'No') {

            unset($_SESSION['delete_framework']);
            redirect("frameworks.php");

        } else {

            if (!empty($_POST) && isset($_POST['submit']) && ($_POST['submit'] == 'Save')) {

                if ($framework) {
                    if (!Framework::if_exists('name', trim($_POST['name']))) {
                        $framework->name = trim($_POST['name']);
                        $framework->update();
                        $_SESSION['message'] = 'Framework updated';
                        redirect('frameworks.php');

                    } else {
                        $_SESSION['message'] = 'Framework already in system';
                        redirect("edit_framework.php?id=$framework->id");
                    }
                } else {
                    $_SESSION['message'] = 'Problem during update';
                    redirect("edit_framework.php?id=$framework->id");

                }
            }
        }
    }
}

?>
<section class="row mt-4">
    <div class="shadow border rounded mx-auto my-auto w-25 ">

        <div  class="card-header "><p>Create framework</p></div>


            <form method="post" action="edit_framework.php?id=<?php echo $framework->id; ?>" class="form-group p-4 ">
                <label for="name">Name: </label>
                <input type="text" name="name" id="name" value="<?php echo $framework->name ?>" class="form-control">
                <?php if (!isset($_SESSION['delete_framework'])) { ?>
                    <div class="border-0 d-flex justify-content-around mt-4">
                        <input type="submit" name="submit" value="Save" class="btn shadow border edit-form">
                        <input type="submit" name="submit" value="Delete" class="btn btn-outline-danger shadow">
                    </div>
                <?php } ?>
                <?php if (isset($_SESSION['delete_framework'])) { ?>
                    <div class="border-0 d-flex flex-column mt-4">
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <?= $_SESSION['delete_framework'] ?>
                            <a href="unset_message.php" type="button" class="close" data-dismiss="alert"
                               aria-label="Close">
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
        } else {
            redirect('frameworks.php');
        }
        ?>
    </div>

</section>


<?php
include('layout/footer.php')
?>

<script type="" src="js/script.js"></script>
