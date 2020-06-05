<?php




class WebsitesController
{




    public static function store(Framework $framework){


        if ($framework) {
            $framework->name = trim($framework['name']);

            return $framework->create();

        }
    }

    public static function edit($id,$post){
        $framework = Framework::find_byId($id);

        if ($framework) {
            $framework->name = trim($post['name']);
            return $framework->update();

        }
    }


    public static function delete($id){
        $framework = Framework::find_byId($id);

        return $framework->delete();


    }





}