<?php
include_once('layout/head.php');
include_once('layout/content-top.php');

!$session->is_signed_in()
    ?redirect('login.php')
    :null;


empty($_GET['id'])
    ?redirect('frameworks.php')
    :$framework = Framework::find_byId($_GET['id']);

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
    <div class="col-12">
        <div class="shadow border rounded mx-auto my-auto w-25 ">
            <div class="card-header "><p>Edit framework</p></div>
            <?php if ($framework) { ?>
                <form method="post" name="framework_edit" class="form-group p-4 ">
                    <input type="hidden" name="valueId" value="<?php echo $framework->id ?>"/>
                    <label for="name">Name: </label>
                    <input type="text" name="name" id="name" value="<?php echo $framework->name ?>"
                           class="form-control">
                    <div class="border-0 d-flex justify-content-around mt-4">
                        <button  name="submit" value="Save" class="btn shadow-sm border fetch-form">Save</button>
                        <button  name="submit" value="Delete" class="btn btn-outline-danger shadow form-button_delete">Delete</button>
                    </div>
                </form>
            <?php } ?>
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
            <input type="hidden" name="valueId" value="" >
            <div class="border-0 d-flex justify-content-around">
                <button  name="submit" value="No" onclick="$('.form-dnone').hide()" class="btn shadow border">No</button>
                <a href="#" name="submit" value="Yes" class="btn btn-outline-danger shadow fetch-form">Yes</a>
            </div>
            </form>
        </div>
    </div>

<?php
include('layout/footer.php')
?>


