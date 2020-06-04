<?php

require_once('database/init.php');


$errors = array(); //To store errors
$form_data = array(); //Pass back the data to `form.php`


if (!isset($_REQUEST['formGetPostData'])) {
    $errors["name"] = "Request didnt come through";
}



$splitStr = explode("_", trim($_REQUEST['form']['name']));

$className = ucfirst($splitStr[0]);

$crudName = $splitStr[1];


switch ($className) {
    case 'Framework':
        $className = Framework::class;
        $classController = FrameworksController::class;
        break;
    case 'User':
        $className = User::class;
        $classController = UsersController::class;
        break;
    case 'Website':
        $className = Website::class;
        $classController = WebsitesController::class;
        break;
}


foreach ($_REQUEST['formGetPostData'] as $item) {
    $objectarray[$item["name"]] = $item["value"];
}


$_REQUEST['formGetPostData'] = $objectarray;


if (!empty($errors)) { //If errors in validation
    $form_data['success'] = false;
    $form_data['errors'] = $errors;

} else {

    switch ($crudName) {

        case 'create' :

            $className::if_exists('name', $_REQUEST['formGetPostData']['name'], $message = true)['bool']
                ? $errors['name'] = $className::if_exists('name', $_REQUEST['formGetPostData']['name'], true)['message']
                : null;


            !empty($_REQUEST['formGetPostData']['name'])
                ? null
                : $errors['name'] = 'Name cannot be blank';


            if (!empty($errors)) {

                $form_data['success'] = false;
                $form_data['errors'] = $errors;

            } else {
                if ($classController::store($_REQUEST['formGetPostData'])) {
                    $form_data['success'] = true;
                    $form_data['posted'] = 'Successfully created';
                } else {
                    $form_data['success'] = false;
                    $form_data['posted'] = 'Something went wrong';
                }

            }
            break;

        case 'edit' :

            $className::if_exists('name', $_REQUEST['formGetPostData']['name'], $message = true)['bool']
                ? $errors['name'] = $className::if_exists('name', $_REQUEST['formGetPostData']['name'], true)['message']
                : null;

            !empty($_REQUEST['formGetPostData']['name'])
                ?: $errors['name'] = 'Name cannot be blank';

            if (!empty($errors)) {

                $form_data['success'] = false;
                $form_data['errors'] = $errors;
            } else {
                $id = $_REQUEST['formGetPostData']['valueId'];
                $post = $_REQUEST['formGetPostData'];
                if ($classController::edit($id, $post)) {
                    $form_data['success'] = true;
                    $form_data['posted'] = 'Successfully updated';
                } else {
                    $form_data['success'] = false;
                    $form_data['posted'] = 'Something went wrong';
                }

            }


            break;

        case 'delete' :

            $id = $_REQUEST['formGetPostData']['valueId'];
            if ($classController::delete($id)) {
                $form_data['success'] = true;
                $form_data['posted'] = 'Successfully deleted';
            } else {
                $form_data['success'] = true;
                $form_data['posted'] = 'Something went wrong';
            }

            break;
    }
}

echo json_encode($form_data);




