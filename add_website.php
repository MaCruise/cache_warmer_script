<?php
include_once('layout/head.php');
include_once('layout/content-top.php');

if (!$session->is_signed_in()) {
    redirect('login.php');
}
var_dump(Framework::if_exists('name', $_POST['name']));

$frameworks = Framework::find_all();

if (!empty($_POST) && isset($_POST['submit']) && ($_POST['submit'] == 'Create')) {


    $website = new Website();
    if ($website) {
        if (!Website::if_exists('url', trim($_POST['url']))) {
            $website->name = trim($_POST['name']);
            $website->url = trim($_POST['url']);
            $website->path = trim($_POST['path']);
            $website->framework_id = trim($_POST['select_framework']);
            $website->create();
            $_SESSION['message'] = 'Website created';
            redirect('websites.php');
        } else {
            $_SESSION['message'] = 'Website already exists';
            redirect('add_website.php');
        }
    }
}


?>
<section class="row mt-4">

    <div class="col-5 mx-auto">

        <div class="shadow border rounded mx-auto my-auto w-75 ">
            <div  class="card-header "><p>Create website</p></div>


            <form  id='add_website.php' method="post"  class="form-group p-4">

                <label for="name">Name: </label>
                <input type="text" name="name" id="name" class="form-control" required>
                <label for="url">Url: </label>
                <input type="url" name="url" id="url" class="form-control">
                <label for="path">Path: </label>
                <input type="text" name="path" id="path" class="form-control">
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
                    <input  name="submit" value="Create" class="btn shadow-sm border update_form">
                </div>
            </form>
        </div>
    </div>
    <div class="col-5">
        <div class="shadow border rounded mx-auto my-auto w-50">
            <div  class="card-header "><p>Create framework</p></div>

            <form id="add_class.php" method="post"  class="form-group p-4">
                <label for="name">name: </label>
                <input type="text" name="name" id="name" class="form-control">
                <span class="throw_error"></span>
                <div class="border-0 d-flex justify-content-around mt-4">
                    <input  name="create_framework" value="Create"
                           class="btn shadow-sm border update_form">
                </div>


            </form>
        </div>
    </div>
    </div>

</section>


<?php
include('layout/footer.php')
?>


<script type="" src="js/script.js"></script>
