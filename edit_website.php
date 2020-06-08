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


}

?>
<section class="row mt-4">
    <div class="col-11 mx-auto vh-5">
        <div class='alert alert-warning alert-dismissible fade show mx-auto w-25 alert-message float-right mb-0'
             role='alert'>
            <span class="throw_error"></span>
            <a type='button' class='close' onclick="$('.alert-message').hide()">
                <span aria-hidden='true'>&times;</span>
            </a>
        </div>
    </div>
    <?php if ($website) { ?>
        <div class="col-12 ">
            <div class="shadow border rounded mx-auto my-auto w-25 ">
                <div class="card-header d-flex w-100"><p>Edit website</p>
                    <a id="urlbacklactaion" href="websites.php" class="ml-auto">
                        <svg class="bi bi-arrow-left-square text-black-50 shadow" width="1.7em" height="1.7em" viewBox="0 0 16 16"
                             fill="currentColor"
                             xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M14 1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                            <path fill-rule="evenodd"
                                  d="M8.354 11.354a.5.5 0 0 0 0-.708L5.707 8l2.647-2.646a.5.5 0 1 0-.708-.708l-3 3a.5.5 0 0 0 0 .708l3 3a.5.5 0 0 0 .708 0z"/>
                            <path fill-rule="evenodd" d="M11.5 8a.5.5 0 0 0-.5-.5H6a.5.5 0 0 0 0 1h5a.5.5 0 0 0 .5-.5z"/>
                        </svg>
                    </a>
                </div>
                <?php if ($website){?>

                <form method="post" name="website_edit" class="form-group p-4 ">
                    <input type="hidden" name="valueId" value="<?php echo $website->id ?>"/>
                    <label for="name">Name: </label>
                    <input type="text" name="name" id="name" value="<?php echo $website->name ?>" class="form-control"
                           required>
                    <label for="url">Url: </label>
                    <input type="url" name="url" id="url" value="<?php echo $website->url ?>" class="form-control"
                           required>
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
                    <div class="border-0 d-flex justify-content-around mt-4">
                        <button  name="submit" value="Save" class="btn shadow-sm border fetch-form">Save</button>
                        <button  name="submit" value="Delete" class="btn btn-outline-danger shadow formEdit-button_delete">Delete</button>
                    </div>

                </form>
                <?php } else {redirect('users.php'); } ?>
            </div>
        </div>
        </div>

        <?php
    } else {
        redirect('websites.php');
    }
    ?>
    </div>

</section>

<div class="card shadow-sm position-absolute absolutemiddle form-dnone">
    <div id="are_you_sure" class="d-flex flex-column  p-4 ">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <span>Are you sure?</span>
            <a type="button" class="close" onclick="$('.form-dnone').hide()">
                <span aria-hidden="true">&times;</span>
            </a>
        </div>
        <form method="post" name="website_delete" class="form-group p-4 ">
            <input type="hidden" name="valueId" value="<?php echo $website->id ?> ">
            <div class="border-0 d-flex justify-content-around">
                <button name="submit" value="No" onclick="$('.form-dnone').hide()" class="btn shadow border">No</button>
                <button href="#" name="submit" value="Yes" class="btn btn-outline-danger shadow fetch-form">Yes</button>
            </div>
        </form>
    </div>
</div>
<?php
include('layout/footer.php')
?>


