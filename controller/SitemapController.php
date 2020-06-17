<?php




class SitemapController
{

    public static function disable_website($post)
    {

    }


    public static function store($post)
    {

    }

    public static function edit($id,$post)
    {

    }


    public static function delete($id)
    {
        $sitemap = Sitemap::find_byId($id);
        return $sitemap->delete();


    }





}