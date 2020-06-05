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
    <div class="col-11 mx-auto vh-5">
        <div class='alert alert-warning alert-dismissible fade show mx-auto w-25 alert-message float-right mb-0' role='alert'>
            <span class="throw_error"></span>
            <a  type='button' class='close' onclick="this.parentElement.style.display='none';"  >
                <span aria-hidden='true'>&times;</span>
            </a>
        </div>
    </div>
    <div class="col-12">
        <div class="shadow border rounded mx-auto my-auto w-25 ">
            <div class="card-header "><p>Edit framework</p></div>
            <?php if ($framework) { ?>
                <form method="post" name="framework_edit" class="form-group p-4 ">
                    <label for="name">Name: </label>
                    <input type="hidden" name="valueId" value="<?= $_GET['id'] ?>"/>
                    <input type="text" name="name" id="name" value="<?php echo $framework->name ?>"
                           class="form-control">
                    <?php if (!isset($_SESSION['delete_framework'])) { ?>
                        <div class="border-0 d-flex justify-content-around mt-4">
                            <a href="" name="submit" value="Save" class="btn shadow-sm border fetch-form">Save</a>
                            <a href="" name="submit" value="Delete" class="btn btn-outline-danger shadow">Delete</a>
                        </div>
                    <?php } ?>

                </form>
            <?php } ?>
        </div>
    </div>

</section>


<?php
include('layout/footer.php')
?>


