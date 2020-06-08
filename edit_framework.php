<?php
include_once('layout/head.php');
include_once('layout/content-top.php');

!$session->is_signed_in()
    ? redirect('login.php')
    : null;


empty($_GET['id'])
    ? redirect('frameworks.php')
    : $framework = Framework::find_byId($_GET['id']);

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
    <div class="col-12">

        <div class="shadow border rounded mx-auto my-auto w-25 ">
            <div class="card-header d-flex w-100"><p>Edit framework</p>
                <a id="urlbacklactaion" href="frameworks.php" class="ml-auto">
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
            <?php if ($framework) { ?>
                <form method="post" name="framework_edit" class="form-group p-4 ">
                    <input type="hidden" name="valueId" value="<?php echo $framework->id ?>"/>
                    <label for="name">Name: </label>
                    <input type="text" name="name" id="name" value="<?php echo $framework->name ?>"
                           class="form-control">
                    <div class="border-0 d-flex justify-content-around mt-4">
                        <button name="submit" value="Save" class="btn shadow-sm border fetch-form">Save</button>
                        <button name="submit" value="Delete"
                                class="btn btn-outline-danger shadow formEdit-button_delete">Delete
                        </button>
                    </div>
                </form>
            <?php } else {redirect('frameworks.php'); } ?>
        </div>
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
        <form method="post" id="" name="framework_delete" class="form-group p-4 ">
            <input type="hidden" name="valueId" value="<?php echo $framework->id ?> ">
            <div class="border-0 d-flex justify-content-around">
                <button name="submit" value="No" onclick="$('.form-dnone').hide()" class="btn shadow border">No</button>
                <button name="submit" value="Yes" class="btn btn-outline-danger shadow fetch-form">Yes</button>
            </div>
        </form>
    </div>
</div>

<?php
include('layout/footer.php')
?>


