<?php

include('layout/head.php');
include('layout/content-top.php');
if (!$session->is_signed_in()) {

    redirect('login.php');

}
$errors = Error::find_all();

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
    <div class="col-2">
        <!--<ul class=" list-unstyled text-center list-group">
            <div class="mt-1">
                <li class=" ">
                    <a class="btn btn-outline-success rounded mt-4" href="add_framework.php">Create framework</a>
                </li>
            </div>

        </ul>-->
    </div>
    <div class="col-7 ml-auto mt-4">

        <div class="card shadow-sm table-responsive">

            <table class="table table-centered table-hover text-center">
                <thead class="">
                <?php
                echo Framework::tableheading();
                ?>
                <th scope="col" colspan="2">Quickfix</th>

                </thead>
                <tbody class="card-body">
                <?php foreach ($errors as $error) { ?>
                    <tr>
                        <th scope="row" class="valueRowId"><?php echo $error->id; ?></th>

                        <td><?php echo $error->url; ?></td>
                        <td><a class="btn btn-outline-info rounded align-self-center float-right"
                               href="edit_framework.php?id=<?php echo $framework->id; ?>">
                                <svg class="bi bi-wrench" width="1em" height="1em" viewBox="0 0 16 16"
                                     fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                          d="M.102 2.223A3.004 3.004 0 0 0 3.78 5.897l6.341 6.252A3.003 3.003 0 0 0 13 16a3 3 0 1 0-.851-5.878L5.897 3.781A3.004 3.004 0 0 0 2.223.1l2.141 2.142L4 4l-1.757.364L.102 2.223zm13.37 9.019L13 11l-.471.242-.529.026-.287.445-.445.287-.026.529L11 13l.242.471.026.529.445.287.287.445.529.026L13 15l.471-.242.529-.026.287-.445.445-.287.026-.529L15 13l-.242-.471-.026-.529-.445-.287-.287-.445-.529-.026z"/>
                                </svg>
                            </a>
                        </td>
                        <td>

                            <a href="" name="submit" value="framework_delete"
                               class="btn btn-outline-danger rounded shadow-sm align-self-center float-left form-button_delete">
                                <svg class="bi bi-trash" width="1em" height="1em" viewBox="0 0 16 16"
                                     fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                    <path fill-rule="evenodd"
                                          d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                </svg>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
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

