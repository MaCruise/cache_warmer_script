<?php
include_once('layout/head.php');
include_once('layout/content-top.php');

!$session->is_signed_in()
    ?redirect('login.php')
    :null;



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
        <div class=" shadow border rounded mx-auto my-auto w-25 ">
            <div class="card-header"><p>Create user</p></div>
            <form method="POST" name="user_create" class="form-group p-4 ">
                <label for="username">Username: </label>
                <input type="text" name="username" class="form-control">
                <label for="email">Email: </label>
                <input type="email" name="email" class="form-control" required>
                <label for="password">Password: </label>
                <input type="password" name="password" class="form-control">
                <div class="border-0 d-flex justify-content-around mt-4">
                    <button name="submit" value="Create" class="btn shadow-sm border fetch-form">Create</button>
                </div>
            </form>
        </div>
    </div>

</section>


<?php
include('layout/footer.php');

?>


