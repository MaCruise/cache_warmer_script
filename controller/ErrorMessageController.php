<?php

require_once('../database/init.php');
$form_data = [];



        if ( ErrorMessage::removeTable()) {
            $form_data['success'] = true;
            $form_data['posted'] = 'Successfully deleted';
        } else {
            $form_data['success'] = true;
            $form_data['posted'] = 'Something went wrong';
        }

        /* IN PROGRESS */

        /*
        if (Sitemap::refresh_sitemap()) {
            $form_data['success'] = true;
            $form_data['posted'] = 'Successfully refreshed';
        } else {
            $form_data['success'] = false;
            $form_data['posted'] = 'Refresh without success';
        };
        echo json_encode($form_data);
        break;*/

echo json_encode($form_data);




