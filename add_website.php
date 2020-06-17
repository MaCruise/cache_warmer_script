<?php
include_once('layout/head.php');
include_once('layout/content-top.php');

if (!$session->is_signed_in()) {
    redirect('login.php');
}

$frameworks = Framework::find_all();

?>
<section class="row mt-4">
    <div class="col-11 mx-auto vh-5">
        <div class='alert alert-warning alert-dismissible fade show mx-auto w-25 alert-message float-right mb-0' role='alert'>
            <span class="throw_error"></span>
            <a  type='button' class='close' onclick="$('.alert-message').hide()"  >
                <span aria-hidden='true'>&times;</span>
            </a>
        </div>
    </div>
    <div class="col-5 mx-auto">
        <div class="shadow border rounded mx-auto my-auto w-75 ">
            <div  class="card-header d-flex w-100"><p>Create website</p>
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
            <form method="post" name="website_create"  class="form-group p-4">
                <label for="name">Name: </label>
                <input type="text" name="name" id="name" class="form-control" required>
                <label for="url">Url: </label>
                <input type="url" name="url" id="url" class="form-control">
                <label for="path">Path: </label>
                <input type="text" name="path" id="path" class="form-control">
                <label for="batch">Batch: </label>
                <input type="number" name="batch" id="batch" class="form-control">
                <?php if (isset($frameworks) && !empty($frameworks)) { ?>
                    <label for="select_framework">Framework: </label>
                    <select class="form-control" name="select_framework" id="select_framework">
                        <option value="0">Choose an option</option>
                        <?php foreach ($frameworks as $framework) { ?>

                            <option value="<?= $framework->id ?>"><?= $framework->name ?></option>
                        <?php } ?>
                    </select>
                <?php } ?>

                <div class="border-0 d-flex justify-content-around mt-4">
                    <button name="submit" value="Create" class="btn shadow-sm border fetch-form">Create</button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-5 align-items-center mt-auto">
        <div class="shadow border rounded mx-auto w-50">
            <div  class="card-header "><p>Create framework</p></div>

            <form method="post" name="framework_create"  class="form-group p-4">
                <label for="name">name: </label>
                <input type="text" name="name" id="name" class="form-control">
                <div class="border-0 d-flex justify-content-around mt-4">
                    <button  name="create_framework" value="Create"
                             class="btn shadow-sm border fetch-form">Create</button>
                </div>


            </form>
        </div>
    </div>
    </div>

</section>


<?php
include('layout/footer.php')
?>



