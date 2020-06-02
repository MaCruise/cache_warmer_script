<?php

include('layout/head.php');
include('layout/content-top.php');
if (!$session->is_signed_in()) {

    redirect('login.php');

}
$users = User::find_all();

?>


<section class="row">

    <div class="col-2">
        <ul class="d-flex justify-content-around">
            <li class="list-unstyled ">
                <a class="btn btn-outline-success rounded mt-4" href="add_user.php">Create user</a>
            </li>
        </ul>
    </div>
    <div class="col-8 mr-auto mt-4">

        <div class="card shadow-sm ">

            <table class="table table-centered table-hover text-center">
                <?php if (isset($_SESSION['message'])) { ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <?= $_SESSION['message'] ?>
                        <a href="unset_message.php" type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </a>
                    </div>
                <?php } ?>
                <thead class="">
                <?php
                echo User::tableheading();
                ?>
                <th scope="col" colspan="2">Quickfix</th>

                </thead>
                <tbody class="card-body">
                <?php foreach ($users as $user) { ?>
                    <tr>
                        <th scope="row"><?php echo $user->id; ?></th>

                        <td><?php echo $user->username; ?></td>
                        <td><?php echo $user->email; ?></td>
                        <td><?php echo $user->password; ?></td>
                        <td><a class="btn btn-outline-info rounded shadow-sm align-self-center"
                               href="edit_user.php?id=<?php echo $user->id; ?>">
                                <svg class="bi bi-wrench" width="1em" height="1em" viewBox="0 0 16 16"
                                     fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                          d="M.102 2.223A3.004 3.004 0 0 0 3.78 5.897l6.341 6.252A3.003 3.003 0 0 0 13 16a3 3 0 1 0-.851-5.878L5.897 3.781A3.004 3.004 0 0 0 2.223.1l2.141 2.142L4 4l-1.757.364L.102 2.223zm13.37 9.019L13 11l-.471.242-.529.026-.287.445-.445.287-.026.529L11 13l.242.471.026.529.445.287.287.445.529.026L13 15l.471-.242.529-.026.287-.445.445-.287.026-.529L15 13l-.242-.471-.026-.529-.445-.287-.287-.445-.529-.026z"/>
                                </svg>
                            </a>
                        </td>
                        <td>
                            <form method="post" action="edit_user.php?id=<?php echo $user->id; ?>">
                                <button type="submit" name="submit" value="Delete_User"
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

<?php if (isset($_SESSION['delete_user'])) { ?>
    <form method="post" action="edit_user.php?id=<?php echo $_GET['id'] ?>" class="form-group p-4 ">
        <div class="card shadow-sm position-absolute absolutemiddle">
            <div id="are_you_sure" class="d-flex flex-column  p-4 ">
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <?= $_SESSION['delete_user'] ?>
                    <a href="" type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                <div class="border-0 d-flex justify-content-around">
                    <input type="submit" name="submit_user" value="No" class="btn shadow border">
                    <input type="submit" name="submit" value="Yes" class="btn btn-outline-danger shadow">
                </div>
            </div>
        </div>
    </form>
<?php } ?>


<?php

include('layout/footer.php');

?>
