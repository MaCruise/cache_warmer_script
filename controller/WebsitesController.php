<?php




class WebsitesController
{




    public static function store($post)
    {
        $website = new Website();

        if ($website) {
            $website->name = trim($post['name']);
            $website->url = trim($post['url']);
            $website->path = trim($post['path']);
            $website->batch = trim($post['batch']);
            $website->framework_id = trim($post['select_framework']);
            return $website->create();

        }
    }

    public static function edit($id,$post)

    {


        $website = Website::find_byId($id);
        switch ($post){
            case isset($post["button"]):
                if ($website) {
                $website->active = trim($post['button']);
                return $website->update();
                break;
                }
            default:
                if ($website) {
                    $website->name = trim($post['name']);
                    $website->url = trim($post['url']);
                    $website->path = trim($post['path']);
                    $website->batch = trim($post['batch']);
                    $website->framework_id = trim($post['select_framework']);
                    return $website->update();


                }
        }


    }

    public static function delete($id)
    {
        $website = Website::find_byId($id);
        return $website->delete();


    }





}