<?php

include('layout/head.php');
include('layout/content-top.php');
if (!$session->is_signed_in()) {

    redirect('login.php');

}
$errors = ErrorMessage::find_all_time();

?>


<section class="row mt-4">
    <div class="col-12 vh-4">
        <div class="row">
            <div class='col-7 mx-auto'>
                <!-- <div class=' alert alert-warning alert-dismissible fade show mx-auto w-25 alert-message float-right mb-0'
                      role='alert'>
                     <span class="throw_error"></span>
                     <a type='button' class='close' onclick="$('.alert-message').hide()">
                         <span aria-hidden='true'>&times;</span>
                     </a>
                 </div>-->
            </div>
        </div>
    </div>
    <div class="col-2 d-flex justify-content-around">
        <ul class=" list-unstyled text-center list-group ">

            <li class=" ">
                <div class="mt-1">
                    <button class="btn btn-outline-success rounded mt-4 flush-form">Flush errors</button>
                </div>
            </li>


            <li class="list-unstyled ">

                <div class="mt-1">
                    <!--  <form method="post" name="sitemap_refresh">
                          <input type="hidden" name="hidden">-->
                    <a id="urlbacklactaion" href="websites.php" class=" ml-auto">
                        <svg class="mt-4 bi bi-arrow-left-square text-black-50 shadow-sm" width="1.7em" height="1.7em"
                             viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M14 1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"></path>
                            <path fill-rule="evenodd"
                                  d="M8.354 11.354a.5.5 0 0 0 0-.708L5.707 8l2.647-2.646a.5.5 0 1 0-.708-.708l-3 3a.5.5 0 0 0 0 .708l3 3a.5.5 0 0 0 .708 0z"></path>
                            <path fill-rule="evenodd"
                                  d="M11.5 8a.5.5 0 0 0-.5-.5H6a.5.5 0 0 0 0 1h5a.5.5 0 0 0 .5-.5z"></path>
                        </svg>
                    </a>
                    <!--<a class="btn btn-outline-success rounded mt-4 fetch-form" href="add_website.php">Refresh script</a>-->
                    <!--</form>-->
                </div>
            </li>
        </ul>
    </div>
    <div class="col-7 ml-auto mt-4">

        <div class="card shadow-sm table-responsive">

            <table class="table table-centered mb-0 table-hover text-center">
                <thead class="">
                <?php
                echo ErrorMessage::tableheading();
                ?>


                </thead>
                <?php if(!empty($errors)){ ?>
                <tbody class="card-body">
                <?php foreach ($errors as $error) { ?>
                    <tr>
                        <th scope="row" class="valueRowId"><?php echo $error->id; ?></th>

                        <td><?php echo empty(Website::find_byId($error->website_id)->url) ? 'script' : Website::find_byId($error->website_id)->url; ?></td>
                        <td><?php echo $error->error; ?></td>
                        <td><?php echo $error->created_at; ?></td>
                    </tr>
                <?php } ?>
                </tbody>
                <?php } ?>
            </table>
        </div>
    </div>
    <div class="col-2 mr-auto mt-4">
        <ul class=" list-unstyled text-center list-group">

            <li>
                <div class='alert alert-warning alert-dismissible fade show mx-auto alert-message float-right mb-0'
                     role='alert'>
                    <span class="throw_error"></span>
                    <a type='button' class='close' onclick="$('.alert-message').hide()">
                        <span aria-hidden='true'>&times;</span>
                    </a>
                </div>
            </li>
        </ul>
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
            <input type="hidden" name="valueId" value="">
            <div class="border-0 d-flex justify-content-around">
                <button name="submit" value="No" onclick="$('.form-dnone').hide()" class="btn shadow border">No</button>
                <a href="#" name="submit" value="Yes" class="btn btn-outline-danger shadow fetch-form">Yes</a>
            </div>
        </form>
    </div>
</div>


<?php

include('layout/footer.php');

?>

