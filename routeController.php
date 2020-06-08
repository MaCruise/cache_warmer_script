<?php

require_once('database/init.php');


$errors = array(); //To store errors
$form_data = array(); //Pass back the data to `form.php`


if (!isset($_REQUEST['formGetPostData'])) {
    $errors["name"] = "Request didnt come through";
}

isset($_REQUEST['formGetPostData']['valueRowId'])

    ?$editID = $_REQUEST['formGetPostData']['valueRowId']
    :$editID = null;



$splitStr = explode("_", trim($_REQUEST['form']['name']));

$className = ucfirst($splitStr[0]);

$crudName = $splitStr[1];

$_REQUEST['formGetPostData'] = $className::assArray($_REQUEST['formGetPostData']);   /*jquery serializeArray() to associativeArray*/


switch ($className) {
    case 'Framework':
        $className = Framework::class;
        $classController = FrameworksController::class;
        $formInputExcluder = [];
        $checkIfExists = ["name"];
        $blankValue = ["name"];
        $form_data["redirect"] = "frameworks.php";
        break;
    case 'User':
        $className = User::class;
        $classController = UsersController::class;
        $formInputExcluder = [];
        $checkIfExists = ["username","email"];
        $blankValue = ["username","email"];
        $form_data["redirect"] = "users.php";
        break;
    case 'Website':
        $className = Website::class;
        $classController = WebsitesController::class;
        $formInputExcluder = [];
        $checkIfExists = ["url"];
        $blankValue = ["url"];
        $form_data["redirect"] = "websites.php";
        break;
}



if($crudName != 'delete')
{
    // controlleren of de value terug te vinden is in de aangegeven tabelnamen

    isset($_REQUEST['formGetPostData']['valueId'])
        ? $editId = $_REQUEST['formGetPostData']['valueId']
        : $editId = null;

    foreach($checkIfExists as $value){

        isset($_REQUEST['formGetPostData'][$value])
            ? $bool = $className::if_exists_single($value, $_REQUEST['formGetPostData'][$value], $message = true,$editId)['bool']
            : /*alert_message('This '.$value.' not found. pls remove out $checkIfExists')*/ null;

        $bool
            ?$errors["error"][] = $className::if_exists_single($value, $_REQUEST['formGetPostData'][$value], $message = true)['message']
            :null;
        ;
    }


    // Controlleren of veldnaam leeg is

    foreach ($blankValue as $value){
        !empty($_REQUEST['formGetPostData'][$value])
            ? null
            : $errors["error"][] = ucfirst($value).' cannot be blank';

    }
}



// Errors?

if (!empty($errors)) { //If errors in validation
    $form_data['success'] = false;
    $form_data['errors'] = $errors;

} else {

    switch ($crudName) {

        case 'create' :

            if ($classController::store($_REQUEST['formGetPostData'])) {
                $form_data['success'] = true;
                $form_data['posted'] = 'Successfully created';
            } else {
                $form_data['success'] = false;
                $form_data['posted'] = 'Something went wrong';
            }

            break;

        case 'edit' :

            $id = $_REQUEST['formGetPostData']['valueId'];
            $post = $_REQUEST['formGetPostData'];

            if ($classController::edit($id, $post))
            {
                $form_data['success'] = true;
                $form_data['posted'] = 'Successfully updated';
            } else
                {
                $form_data['success'] = false;
                $form_data['posted'] = 'Something went wrong';
            }
            break;

        case 'delete' :

            $id = $_REQUEST['formGetPostData']['valueId'];

            if ($classController::delete($id))
            {
                $form_data['success'] = true;
                $form_data['posted'] = 'Successfully deleted';
            } else
                {
                $form_data['success'] = true;
                $form_data['posted'] = 'Something went wrong';
            }

            break;
    }
}

echo json_encode($form_data);




