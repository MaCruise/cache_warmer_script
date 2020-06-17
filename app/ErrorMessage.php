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

        $errorMessage->website_id = $id;
        $errorMessage->error = $post;
        return $errorMessage->create();



    }

}