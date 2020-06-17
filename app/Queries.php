<?php


class Queries
{

    public static function find_tables()
    {
        global $database;
        return $result = $database->query("SHOW COLUMNS FROM " . static::$db_table);

    }

    public static function find_all()
    {

        return $result = static::find_this_query("SELECT * FROM " . static::$db_table);
    }
    public static function find_all_time()
    {

        return $result = static::find_this_query("SELECT * FROM " . static::$db_table . " ORDER BY " . static::$db_table .".created_at DESC");
    }

    public static function find_byId($id)
    {

        $result = static::find_this_query("SELECT * FROM " . static::$db_table . " WHERE ID=$id");

        return !empty($result) ? array_shift($result) : false;
    }

    public static function find_culomn_input($culomn, $value)
    {

        $result = static::find_this_query("SELECT * FROM " . static::$db_table . " WHERE {$culomn}='{$value}'");

        return !empty($result) ? array_shift($result) : false;
    }


    public function create()
    {
        global $database;
        $properties = $this->clean_properties();
        $sql = "INSERT INTO " . static::$db_table . " (" . implode(",", array_keys($properties)) . ") ";
        $sql .= " VALUES ('" . implode("','", array_values($properties)) . "')";

        if ($database->query($sql)) {
            $this->id = $database->the_insert_id();
            return $this->id;
        } else {
            return false;
        }
    }



    public function update()
    {
        global $database;
        $properties = $this->clean_properties();
        $properties_assoc = array();
        foreach ($properties as $key => $value) {
            $properties_assoc[] = "{$key}='{$value}'";
        }

        $sql = "UPDATE " . static::$db_table . " SET ";
        $sql .= implode(",", $properties_assoc);
        $sql .= " WHERE id= " . $database->escape_string($this->id);


        return $database->query($sql);
    }

    public function delete(){

        global $database;
        $sql = "DELETE FROM " . static::$db_table;
        $sql .= " WHERE id=" . $database->escape_string($this->id);
        $sql .= " LIMIT 1";
        $database->query($sql);

        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    }

    static public function removeTable()
    {
        global $database;
        $sql = "TRUNCATE TABLE " . static::$db_table;


        return $database->query($sql);


    }


    public static function if_exists_single($table, $input, $message = false, $id = null)
    {


        $id == null
            ? $bool = !empty(static::find_this_query("SELECT * FROM " . static::$db_table . " WHERE {$table}='{$input}'"))
            : $bool = !empty(static::find_this_query("SELECT * FROM " . static::$db_table . " WHERE {$table}='{$input}' AND id!='{$id}'"));


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




}