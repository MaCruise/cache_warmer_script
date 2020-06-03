<?php
include_once('layout/head.php');

include_once('layout/content-top.php');

if (!$session->is_signed_in()) {
    redirect('login.php');
}


?>
<section class="row mt-4">
    <div class="shadow border rounded mx-auto my-auto w-25 ">

        <div  class="card-header "><p>Create framework</p></div>

        <form id="add_class.php" method="post"  class="form-group p-4">
            <label for="name">name: </label>
            <input type="text" name="name" id="name" class="form-control">
            <span class="throw_error"></span>
            <div class="border-0 d-flex justify-content-around mt-4">
                <input  name="submit" value="Create"
                        class="btn shadow-sm border post-form">
            </div>


        </form>
    </div>

</section>



<?php
include('layout/footer.php');


?>

<script type="" src="js/script.js"></script>

