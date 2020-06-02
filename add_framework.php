<?php
include_once('layout/head.php');

include_once('layout/content-top.php');

if (!$session->is_signed_in()) {
    redirect('login.php');
}


?>
<section class="row mt-4">
    <div class="shadow border rounded mx-auto my-auto w-25 ">

        <div class="card-header"><p>Create framework</p></div>
       <!-- <?php /*if (isset($_SESSION['message'])) { */?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <?/*= $_SESSION['message'] */?>
                <a href="unset_message.php" type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>
        --><?php /*}  */?>

        <form method="post" name="postForm"  class="form-group p-4 ">
            <label for="name">Name: </label>
            <input type="text" name="name" id="name" class="form-control" >
            <span class="throw_error"></span>
            <span id="success"></span>
            <div class="border-0 d-flex justify-content-around mt-4">
                <input type="submit" name="submit" value="Create" class="btn shadow-sm border">

            </div>


        </form>
    </div>

</section>



<?php
include('layout/footer.php');


?>



