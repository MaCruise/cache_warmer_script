<?php


class Sitemap extends Dbobject
{
    public static $db_table = 'script_session';

    /**
     * Table properties declared dynamiclly
     */

    static public function create_sitemap($sessionVarSitemap)
    {


        $sitemap = new Sitemap();
        $sitemap->session_url_sitemap = $sessionVarSitemap['session_url_sitemap'];
        $sitemap->session_sitemap_url_count = $sessionVarSitemap['session_sitemap_url_count'];
        $sitemap->website_url_id = $sessionVarSitemap['website_url_id'];

        return $sitemap->create();


    }

    static public function  update_sitemap($session_id,$url_count)
    {
        $sitemap = Sitemap::find_byId($session_id);
        $sitemap->session_sitemap_url_count = $url_count;
        return $sitemap->update();


    }
    static public function  refresh_sitemap()
    {

        return $return = (static::removeTable_sitemap())===true?true:ErrorMessage::create_log(0,"error refreshing script");



    }



    static public function remove_script_url_sitemap($id){
        $sitemap = Sitemap::find_culomn_input("website_url_id",$id);

        return (!isset($sitemap)&&!empty($sitemap))
            ?ErrorMessage::create_log(0,"error removing script")
            :$sitemap->delete();
}

}