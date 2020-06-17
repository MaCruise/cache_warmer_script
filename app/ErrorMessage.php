<?php


class ErrorMessage extends Dbobject

{

    use Table;
    public static $db_table = 'errors';

    /**
     * Table properties declared dynamiclly
     *
     *
     */

    static function create_log($id,$post){
        $errorMessage = new self;
        $time = new DateTime();

        $errorMessage->website_id = $id;
        $errorMessage->error = $post;
        $errorMessage->created_at = $time->format('Y-m-d - H:i:s') ;
        return $errorMessage->create();



    }


}