<?php




class FrameworksController
{




    public static function store($post){

        $framework = new Framework();
        if ($framework) {
            $framework->name = trim($post['name']);
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




}