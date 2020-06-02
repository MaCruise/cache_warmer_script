<?php
include_once('layout/head.php');
include_once('layout/content-top.php');

if (!$session->is_signed_in()) {
    redirect('login.php');
}

if (empty($_GET['id'])) {
    redirect('websites.php');
} else {


    $website = Website::find_byId($_GET['id']);
    $frameworks = Framework::find_all();

    if (!empty($_POST) && isset($_POST['submit']) && ($_POST['submit'] == 'Delete' || $_POST['submit'] == 'Delete_Website')) {

        $_SESSION['delete_website'] = 'Are you sure?';
        $_POST['submit'] === 'Delete_Website' ? redirect("websites.php?id=$website->id") : redirect("edit_website.php?id=" . $website->id);
    } elseif (!empty($_POST) && isset($_POST['submit']) && ($_POST['submit'] == 'Yes')) {
        $website->delete();
        unset($_SESSION['delete_website']);
        redirect('websites.php');
    } elseif (!empty($_POST) && isset($_POST['submit']) && $_POST['submit'] == 'No') {
        unset($_SESSION['delete_website']);
        redirect("edit_website.php?id=$website->id");

    } elseif (!empty($_POST) && isset($_POST['submit_website']) && $_POST['submit_website'] == 'No') {
        unset($_SESSION['delete_website']);
        redirect('websites.php');

    } else {

        if (!empty($_POST) && isset($_POST['submit']) && ($_POST['submit'] == 'Save')) {

            if (Website::if_exists('path', trim($_POST['path']))) {
                $_SESSION['message'] = 'Path already exists';
                redirect("edit_website.php?id=$website->id");
            } elseif (Website::if_exists('url', trim($_POST['url']))) {
                $_SESSION['message'] = 'Url already exists';
                redirect("edit_website.php?id=$website->id");
            } else {


                if ($website) {

                    $website->name = trim($_POST['name']);
                    $website->url = trim($_POST['url']);
                    $website->path = trim($_POST['path']);
                    $website->framework_id = trim($_POST['select_framework']);
                    $website->update();
                    $_SESSION['message'] = 'Website updated';
                    redirect('websites.php');

                } else {
                    $_SESSION['message'] = 'Problem occured during update';
                    redirect('websites.php');
                }

            }
        }
    }
}

?>
<section class="row mt-4">
    <?php if ($website) { ?>

        <div class="shadow border rounded mx-auto my-auto w-25 ">

            <?php if (isset($_SESSION['message'])) { ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <?= $_SESSION['message'] ?>
                    <a href="unset_message.php" type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
            <?php } ?>

            <form method="post" action="edit_website.php?id=<?php echo $website->id; ?>" class="form-group p-4 ">
                <label for="name">Name: </label>
                <input type="text" name="name" id="name" value="<?php echo $website->name ?>" class="form-control"
                       required>
                <label for="url">Url: </label>
                <input type="url" name="url" id="url" value="<?php echo $website->url ?>" class="form-control" required>
                <label for="path">Path: </label>
                <input type="text" name="path" id="path" value="<?php echo $website->path ?>" class="form-control"
                       required>

                <?php if (isset($frameworks) && !empty($frameworks)) { ?>
                    <label for="select_framework">Framework: </label>
                    <select class="form-control" name="select_framework" id="select_framework">
                        <?php if ($website->framework_id == 0) { ?>
                            <option value="0" selected> Choose an option</option>
                            <?php
                        }
                        ?>
                        <?php foreach ($frameworks as $framework) { ?>
                            <?php
                            if ($framework->id == $website->framework_id) {
                                ?>
                                <option value="<?= $framework->id ?>" selected><?= $framework->name ?></option>
                            <?php } else {
                                ?>
                                <option value="<?= $framework->id ?>"><?= $framework->name ?></option>

                            <?php }
                        } ?>
                    </select>
                <?php } ?>

                <?php if (!isset($_SESSION['delete_website'])) { ?>
                    <div class="border-0 d-flex justify-content-around mt-4">
                        <input type="submit" name="submit" value="Save" class="btn shadow border">
                        <input type="submit" name="submit" value="Delete" class="btn btn-outline-danger shadow">
                    </div>
                <?php } ?>
                <?php if (isset($_SESSION['delete_website'])) { ?>
                    <div class="border-0 d-flex flex-column mt-4">
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <?= $_SESSION['delete_website'] ?>
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
        </div>
        <?php
    } else {
        redirect('websites.php');
    }
    ?>

</section>


<?php
include('layout/footer.php')
?>


