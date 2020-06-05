<?php


class Queries
{

    public static function find_tables()
    {
        global $database;
        return $result = $database->query("SHOW COLUMNS FROM " . static::$db_table);

    }

        public static function find_all(){

        return $result = static::find_this_query("SELECT * FROM ".static::$db_table);
    }
    public static function find_byId($id){

        $result =   static::find_this_query("SELECT * FROM ".static::$db_table." WHERE ID=$id");

        return      !empty($result)?array_shift($result): false;
    }



    public function create()
    {
        global $database;
        $properties = $this->clean_properties();
        $sql = "INSERT INTO " . static::$db_table . " (" . implode(",", array_keys($properties)) . ") ";
        $sql .= " VALUES ('" . implode("','", array_values($properties)) . "')";

        if ($database->query($sql)) {
            $this->id = $database->the_insert_id();
            return true;
        } else {
            return false;
        }
/*        $database->query($sql);
        return (mysqli_affected_rows($database->connection) == 1);*/
    }



    public function update(){
        global $database;
        $properties = $this->clean_properties();
        $properties_assoc = array();
        foreach($properties as $key => $value){
            $properties_assoc[] ="{$key}='{$value}'";
        }

        $sql = "UPDATE ". static::$db_table ." SET ";
        $sql .= implode(",", $properties_assoc);
        $sql .= " WHERE id= " . $database->escape_string($this->id);

        $database->query($sql);
        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    }


    public function delete(){

        global $database;
        $sql = "DELETE FROM ". static::$db_table ;
        $sql .= " WHERE id=" . $database->escape_string($this->id);
        $sql .= " LIMIT 1";
        $database->query($sql);

        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    }



    public static function if_exists_single($table,$input,$message=false){

        $bool = !empty(static::find_this_query("SELECT * FROM ".static::$db_table." WHERE {$table}='{$input}'"));
        if ($message){
            switch ($bool) {
                case true:
                    $message = ucfirst($table)." : $input already in system";
                    return compact('bool', 'message');
                case false :
                    $message = ucfirst($table)." : $input not found ";
                    return compact('bool', 'message');
            }

        }

        return $bool;

    }

    /*public static function if_exists($table = [], $input,$message = [])
    {
        $message=[];
        $bool = [];
        foreach ($table as $tableValue) {

            $bool[] = !empty(static::find_this_query("SELECT * FROM " . static::$db_table . " WHERE {$tableValue}='{$input[$tableValue]}'"))
                ?$message[] = ucfirst($tableValue) . " : $input[$tableValue] already in system"
                :$message[] = ucfirst($tableValue) . " : $input[$tableValue] not found ";





        }
        var_dump(compact('bool', 'message'));
        die('test');
        return compact('bool', 'message');


    }*/




}