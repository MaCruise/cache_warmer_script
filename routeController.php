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
        $formInputExcluder = [];
        $checkIfExists = ["name"];
        $blankValue = ["name"];
        break;
    case 'User':
        $className = User::class;
        $classController = UsersController::class;
        $formInputExcluder = [];
        $checkIfExists = ["username","email"];
        $blankValue = ["username","email"];
        break;
    case 'Website':
        $className = Website::class;
        $classController = WebsitesController::class;
        $formInputExcluder = [];
        $checkIfExists = ["url"];
        $blankValue = ["url"];
        break;
}


// omzetten naar aanspreekbare array

foreach ($_REQUEST['formGetPostData'] as $item) {           /* "name" en "value" komen van jquery serializeArray()*/
    $objectarray[$item["name"]] = $item["value"];
}



$_REQUEST['formGetPostData'] = $objectarray;


// controlleren of de value terug te vinden is in de aangegeven tabelnamen
if($crudName != 'delete'){
foreach($checkIfExists as $value){

    isset($_REQUEST['formGetPostData'][$value])
        ? $bool = $className::if_exists_single($value, $_REQUEST['formGetPostData'][$value], $message = true)['bool']
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



// zijn er errors

if (!empty($errors)) { //If errors in validation
    $form_data['success'] = false;
    $form_data['errors'] = $errors;

} else {

    switch ($crudName) {

        case 'create' :



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




