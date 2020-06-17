<?php





        if ( ErrorMessage::removeTable()) {
            $form_data['success'] = true;
            $form_data['posted'] = 'Successfully deleted';
        } else {
            $form_data['success'] = true;
            $form_data['posted'] = 'Something went wrong';
        }






        echo json_encode($form_data);


