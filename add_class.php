<?php

require_once('database/init.php');


$errors = array(); //To store errorsS
$form_data = array(); //Pass back the data to `form.php`

/* Validate the form on the server side */



if (Framework::if_exists('name',$_POST['name'])){
    $errors["name"] = Framework::if_exists('name',$_POST['name'],true)['message'];
}

if (empty($_POST['name'])) { //Name cannot be empty
    $errors['name'] = 'Name cannot be blank';
}

if (!empty($errors)) { //If errors in validation
    $form_data['success'] = false;
    $form_data['errors']  = $errors;
}
else { //If not, process the form, and return true on success

    /*if (!empty($_POST) && ($_POST['submit'] == 'Create' || $_POST['create_framework'] == 'Create')) {*/
       FrameworksController::store($_POST);
    /*}*/

    $form_data['success'] = true;
    $form_data['posted'] = 'Successfully created ';
}




//Return the data back to form.php
echo json_encode($form_data);