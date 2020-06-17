<?php

class User extends Dbobject
{

    use Table;

    public static $db_table = 'users';

    /**
     * Table properties declared dynamiclly
     */

    /*protected static $db_fields= array('id' => $id,'username' => $username,'password','first_name','last_name');*/


    /*public $id;

    public $password;*/

    public static function verify_user($username,$password){
        global $database;
        $username = $database->escape_string($username);
        $password = $database->escape_string($password);
        $sha1_password = hash('sha256',$password);

        $sql = "SELECT * FROM ".static::$db_table." WHERE ";
        $sql .= "username = '{$username}' ";
        $sql .= "AND password = '{$sha1_password}' ";
        $sql .= "LIMIT 1";

        $result_array = self::find_this_query($sql);


        return    !empty($result_array)?array_shift($result_array): false;


            
    }

    public static function has_user(){

        return empty(User::find_all());
    }






}