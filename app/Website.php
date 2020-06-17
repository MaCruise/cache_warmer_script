<?php

class Website extends Dbobject
{

    use Table;

    public static $db_table = 'websites';

    /**
     * Table properties declared dynamiclly
     */

    /*protected static $db_fields= array('id' => $id,'username' => $username,'password','first_name','last_name');*/


    /*public $id;

    public $password;*/



            


    public static function has_user(){

        return empty(User::find_all());
    }






}