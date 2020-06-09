<?php


class CacheWarmer
{

    public function run()
    {
        $url = "https://www.yourmindourwork.be/sitemap.xml";
        return $this->process_sitemap($url);
    }

    public function process_sitemap($url)
    {
        $urls = [];

        $sitemmap_xml = file_get_contents($url);
        $sitemap = simplexml_load_string($sitemmap_xml);

        foreach($sitemap->sitemap as $subsitemap){

            $urls[] = $this->process_sitemap_Get_Url($subsitemap->loc);
        }


        return $urls;

    }

    public function process_sitemap_Get_Url($url){
        $urls = [];
        $sitemmap_xml = file_get_contents($url);
        $sitemap = simplexml_load_string($sitemmap_xml);

        foreach($sitemap->url as $url){
            $urls[] = $url;
        }
            return $urls;
    }


}
