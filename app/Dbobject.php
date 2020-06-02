<?php


class Dbobject extends Queries
{

    public function __construct(){

        $this->public_properties();
    }



    public static function find_this_query($sql)
    {

        global $database;
        $result = $database->query($sql);

        $the_object_array = array();
        while ($row = mysqli_fetch_array($result)) {

            $the_object_array[] = static::instance($row);

        }


        return $the_object_array;
    }




    private static function instance($result){

        $the_object = new static();

        foreach($result as $the_attribute => $value){

            if($the_object->has_the_attribute($the_attribute)) {
                $the_object->$the_attribute = $value;

            }
        }
        return $the_object;
    }

    private function has_the_attribute($the_attribute){
        $object_properties = get_object_vars($this);
        return array_key_exists($the_attribute, $object_properties);

    }


    protected function properties(){
        $properties = array();
        foreach(static::db_tables() as $db_field){
            if(property_exists($this, $db_field)){
                $properties[$db_field] = $this->$db_field;
            }
        }
        return $properties;
    }
    protected function clean_properties(){
        global $database;
        $clean_properties = array();
        foreach($this->properties() as $key => $value){
            $clean_properties[$key] = $database->escape_string($value);
        }


        return $clean_properties;
    }

    public static function db_tables()
    {

        $result = self::find_tables();

        $id = array();
        while ($row = mysqli_fetch_array($result)) {
            $id[] = $row[0];
        }
        return $id;
    }
    public function public_properties()
    {

        $result = $result = self::find_tables();
        while ($row = mysqli_fetch_array($result)) {
            $this->{$row[0]} = null;
        }

    }
}