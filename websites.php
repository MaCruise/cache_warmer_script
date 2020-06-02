<?php

include('layout/head.php');
include('layout/content-top.php');
if (!$session->is_signed_in()) {

    redirect('login.php');

}
$websites = Website::find_all();


?>


<section class="row">

    <div class="col-2">
        <ul class="d-flex justify-content-around">
            <li class="list-unstyled ">
                <a class="btn btn-outline-success rounded mt-4" href="add_website.php">Create website</a>
            </li>
        </ul>
    </div>
    <div class="col-8 mr-auto mt-4">

        <div class="card shadow-sm ">

            <table class="table table-centered mb-0 text-center">
                <thead class="">
                <?php
                echo Website::tableheading();
                ?>
                <th scope="col" colspan="2">Quickfix</th>

                </thead>
                <tbody class="card-body">
                <?php foreach ($websites as $website) { ?>
                    <tr>
                        <th scope="row"><?php echo $website->id; ?></th>

                        <td class=""><?php echo $website->name; ?></td>
                        <td class=""><?php echo $website->url; ?><a href="<?php echo $website->url; ?>"
                                                                             class="text-primary float-right">
                                <svg class="bi bi-link-45deg" width="1em" height="1em" viewBox="0 0 16 16"
                                     fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4.715 6.542L3.343 7.914a3 3 0 1 0 4.243 4.243l1.828-1.829A3 3 0 0 0 8.586 5.5L8 6.086a1.001 1.001 0 0 0-.154.199 2 2 0 0 1 .861 3.337L6.88 11.45a2 2 0 1 1-2.83-2.83l.793-.792a4.018 4.018 0 0 1-.128-1.287z"/>
                                    <path d="M5.712 6.96l.167-.167a1.99 1.99 0 0 1 .896-.518 1.99 1.99 0 0 1 .518-.896l.167-.167A3.004 3.004 0 0 0 6 5.499c-.22.46-.316.963-.288 1.46z"/>
                                    <path d="M6.586 4.672A3 3 0 0 0 7.414 9.5l.775-.776a2 2 0 0 1-.896-3.346L9.12 3.55a2 2 0 0 1 2.83 2.83l-.793.792c.112.42.155.855.128 1.287l1.372-1.372a3 3 0 0 0-4.243-4.243L6.586 4.672z"/>
                                    <path d="M10 9.5a2.99 2.99 0 0 0 .288-1.46l-.167.167a1.99 1.99 0 0 1-.896.518 1.99 1.99 0 0 1-.518.896l-.167.167A3.004 3.004 0 0 0 10 9.501z"/>
                                </svg>
                            </a></td>
                        <td class=""><?php echo $website->path; ?></td>
                        <td class=""><?php echo $website->framework_id ? isset(Framework::find_byId($website->framework_id)->name)?Framework::find_byId($website->framework_id)->name:'Deprecated' : 'no framework' ?></td>
                        <td><a class="btn btn-outline-info rounded align-self-center"
                               href="edit_website.php?id=<?php echo $website->id; ?>">
                                <svg class="bi bi-wrench" width="1em" height="1em" viewBox="0 0 16 16"
                                     fill="currentColor"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                          d="M.102 2.223A3.004 3.004 0 0 0 3.78 5.897l6.341 6.252A3.003 3.003 0 0 0 13 16a3 3 0 1 0-.851-5.878L5.897 3.781A3.004 3.004 0 0 0 2.223.1l2.141 2.142L4 4l-1.757.364L.102 2.223zm13.37 9.019L13 11l-.471.242-.529.026-.287.445-.445.287-.026.529L11 13l.242.471.026.529.445.287.287.445.529.026L13 15l.471-.242.529-.026.287-.445.445-.287.026-.529L15 13l-.242-.471-.026-.529-.445-.287-.287-.445-.529-.026z"/>
                                </svg>
                            </a>
                        </td>
                        <td>
                            <form method="post" action="edit_website.php?id=<?php echo $website->id; ?>">
                                <button type="submit" name="submit" value="Delete_Website"
                                        class="btn btn-outline-danger rounded shadow-sm align-self-center">
                                    <svg class="bi bi-trash" width="1em" height="1em" viewBox="0 0 16 16"
                                         fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                        <path fill-rule="evenodd"
                                              d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

</section>

<?php if (isset($_SESSION['delete_website'])) { ?>
    <form method="post" action="edit_website.php?id=<?php echo $_GET['id'] ?>" class="form-group p-4 ">
        <div class="card shadow-sm position-absolute absolutemiddle">
            <div id="are_you_sure" class="d-flex flex-column  p-4 ">
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <?= $_SESSION['delete_website'] ?>
                    <a href="" type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                <div class="border-0 d-flex justify-content-around">
                    <input type="submit" name="submit_website" value="No" class="btn shadow border">
                    <input type="submit" name="submit" value="Yes" class="btn btn-outline-danger shadow">
                </div>
            </div>
        </div>
    </form>
<?php } ?>

<?php

include('layout/footer.php');

?>
