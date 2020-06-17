<?php


trait Table
{
    public static function tableheading(){
        $tableheading="";
        foreach ($result = static::db_tables() as $row){
            $tableheading .= "<th scope='col'>".str_replace('_id',"",ucfirst($row))."</th>";


        }
        return $tableheading;
    }



    public static function showMeATable($incomming, $excluder = [null], $tablediv = false,$search=false,$extra=null)
    {
        $string = "";
        $i = 0;
        $object = $incomming;


        $x = 0;
        $z = count($excluder);
        if ($tablediv = true) {
            self::$returnstring .= " <div class=\"table-responsive\"><table class=\"table table-centered table-hover mb-0\">";
        }
        if (!empty($object)) {
            foreach ($object as $key) {

                /*tablehead*/
                if ($i < 1) {
                    self::$string = '<thead><tr>';
                    foreach ($key->db_tables() as $keyvalue) {
                        foreach ($excluder as $exclude) {
                            if ($exclude != $keyvalue) {
                                $x++;
                            }
                        }
                        if ($x == $z) {
                            /*Replace strings int th*/
                            $keyvalue = str_replace('_id', "", $keyvalue);
                            $keyvalue = str_replace('_', " ", $keyvalue);
                            $keyvalue = ucfirst($keyvalue);
                            self::$string .= "<th>$keyvalue</th>";
                        }
                        $x = 0;
                    }
                    /*Extra column toeveoegen*/
                    self::$string .= !$search?"<th>quikfix</th>":"";
                    self::$string .= !$search?"<th>Deletion</th>":"<th>Append</th>";
                    self::$string .= "</tr></thead>";
                    self::$string .= "<tbody> <tr>";
                }

                foreach ($key->db_tables() as $keyvalue) {

                    foreach ($excluder as $exclude) {
                        if ($exclude != $keyvalue) {
                            $x++;
                        }
                    }

                    if ($x == $z && $keyvalue != "photo_id" && $keyvalue != "address_id" && $keyvalue != "role_id" && $keyvalue != "selected_address_id" && $keyvalue != "brand_id" && $keyvalue != "category_id" && $keyvalue != "serie_id" && $keyvalue != "specs_id") {
                        self::$string .= "<td>{$key->getAttribute($keyvalue)}</td>";
                    } elseif ($x == $z && $keyvalue == "photo_id") {
                        $imgSource = $key->photo ? asset($key->photo['file']) : 'https://via.placeholder.com/150.it/62x62';

                        self::$string .= "<td><img style='max-width: 62px;' src='$imgSource' alt=''></td>";


                    } elseif ($x == $z && $keyvalue == "selected_address_id") {
                        self::$string .= "<td>";

                        if (isset($key->selected_address_id)) {
                            foreach ($address = Address::find([$key->selected_address_id]) as $result) {
                                foreach ($result->getFillable() as $attribute)
                                    self::$string .= $attribute != 'country_id' ? "{$result->getAttribute($attribute)} " : Country::pluck('name', 'id')->get($result['country_id']);
                            }

                        }
                        self::$string .= "</td>";

                    }
                    /*Users*/
                    elseif ($x == $z && $keyvalue == "role_id") {
                        self::$string .= "<td>" . Role::pluck('name', 'id')->get($key->role_id) . "</td>";
                    }
                    /*Products*/
                    elseif ($x == $z && $keyvalue == "brand_id") {

                        self::$string .= "<td>" . $key->brand->name. "</td>";
                    } elseif ($x == $z && $keyvalue == "category_id") {
                        self::$string .= "<td>" . $key->category->select('name') . "</td>";
                    } elseif ($x == $z && $keyvalue == "serie_id") {
                        self::$string .= "<td>" . $key->serie->serie . "</td>";
                    } elseif ($x == $z && $keyvalue == "specs_id") {
                        self::$string .= "<td><a class='btn btn-outline-success' href=" . route('specs.show', $key->id) . "><i class='fas fa-edit'></i></a></td>";
                    }

                    $x = 0;
                }

                /*extra toevoeging buttons*/
                $methFieldG = method_field('get');
                $methFieldp = method_field('patch');
                $methFieldD = method_field('DELETE');
                $csrfField = csrf_field(csrf_token());
                /*dd($incomming);*/
                if(!$search) {

                    self::$string .= "<td><a class='btn btn-outline-primary' href=" . route($key->table . '.edit', $key->id) . "><i class='fas fa-wrench'></i></a></td>";
                    self::$string .= $key->deleted_at ? "<td><form action=" . action('Admin' . ucfirst($key->table) . 'Controller@destroy', "$key->id") . " method='post'>$methFieldD$csrfField<button type='submit' class='btn btn-outline-success'><i class='fas fa-recycle'></i></input></form></td>" : "<td><form action=" . action('Admin' . ucfirst($key->table) . 'Controller@destroy', "$key->id") . " method='post'>$methFieldD$csrfField<button type='submit' class='btn btn-outline-danger'><i class='fas fa-trash'></i></input></form></td>";
                }else{
                    self::$string .= "<td><form action=" . action('Admin' . ucfirst($key->table) . 'Controller@addSearch', $extra) . " method='post'>$methFieldp$csrfField<input hidden name='syncS' value='$key->id'> <button type='submit' class='btn btn-outline-success'>add</i></input></form></td>";
                }

                self::$string .= "</tr></tbody>";

                $i++;
                self::$returnstring .= self::$string;
                self::$string = "";
            }
            if ($tablediv = true) {
                self::$returnstring .= "</div></div>";
            }
            if ($object instanceof \Illuminate\Pagination\AbstractPaginator) {
                return [self::$returnstring, $object->links()];
            } else {
                return [self::$returnstring];
            }


        } else {
            return "<thead><tr>somthing whent wrong</tr></thead>";
        }
    }




}