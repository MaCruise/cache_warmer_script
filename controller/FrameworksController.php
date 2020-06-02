<?php




class FrameworksController
{




    public function store($post){

        $framework = new Framework();
        if ($framework) {
            $framework->name = trim($post['name']);
            $framework->create();

        }
    }

    public function edit($id,$post){
        $framework = Framework::find_byId($id);

        if ($framework) {
            $framework->name = trim($post['name']);
            $framework->update();

        }
    }

}