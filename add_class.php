<?php

require_once('database/init.php');


$errors = array(); //To store errors
$form_data = array(); //Pass back the data to `form.php`


if((isset($_POST['submit']) || isset($_POST['create_framework'])) == 'Create' ){        //control Name button

/* Validate duplication */
if (Framework::if_exists('name',$_POST['name'])) {

    $errors["name"] = Framework::if_exists('name', $_POST['name'], true)['message'];
}
/* Validate the form on the server side */

if (empty($_POST['name'])) { //Name cannot be empty
    $errors['name'] = 'Name cannot be blank';
}

if (!empty($errors)) { //If errors in validation
    $form_data['success'] = false;
    $form_data['errors']  = $errors;
}
else { //If not, process the form, and return true on success

       if(FrameworksController::store($_POST)){
           $form_data['success'] = true;
           $form_data['posted'] = 'Successfully created';
       }else{
           $form_data['success'] = true;
           $form_data['posted'] = 'Something went wrong';
       }

}

}elseif ($_POST['submit'] == 'Save')

{

    if (Framework::if_exists('name',$_POST['name'])) {

        $errors["name"] = Framework::if_exists('name', $_POST['name'], true)['message'];
    }
    /* Validate the form on the server side */

    if (empty($_POST['name'])) { //Name cannot be empty
        $errors['name'] = 'Name cannot be blank';
    }

    if (!empty($errors)) { //If errors in validation
        $form_data['success'] = false;
        $form_data['errors']  = $errors;
    }
    else { //If not, process the form, and return true on success
        $id=$_GET['id'];
        $post=$_POST;

        if(FrameworksController::edit($id,$post)){
            $form_data['success'] = true;
            $form_data['posted'] = 'Successfully updated';
        }else{
            $form_data['success'] = true;
            $form_data['posted'] = 'Something went wrong';
        }

    }

}


//Return the data back to form.php
echo json_encode($form_data);