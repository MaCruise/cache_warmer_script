<?php

require_once('../database/init.php');
require_once ('../script_warmer/CacheWarmer.php');



    $SessionVarSitemap = [];



runScript();

    function runScript()
    {
        set_time_limit(0);
        $SessionVarSitemap['countallurlsfound'] = 0;

        $sitemaps = Sitemap::find_all();
        if(!empty($sitemaps)){

            foreach ($sitemaps as $id=>$value){

                $SessionVarSitemap[$value->session_url_sitemap]['session_sitemap_url_count'] = $value->session_sitemap_url_count;
                $SessionVarSitemap[$value->session_url_sitemap]['id'] = $value->id;
                $SessionVarSitemap[$value->session_url_sitemap]['active'] = $value->active;
                $value->session_sitemap_url_count == 0?$SessionVarSitemap[$value->session_url_sitemap]['empty'] = true:$SessionVarSitemap[$value->session_url_sitemap]['empty'] = false;
                $SessionVarSitemap['countallurlsfound'] += $value->session_sitemap_url_count;


            }$SessionVarSitemap["active"]= true;


        }else{
            $SessionVarSitemap["active"]= false;
        }





        $sitemap_urls = array();
        $all_Sitemaps = Website::find_all();


        foreach ($all_Sitemaps as $sitemap_url){

            switch ($sitemap_url->active){
                case true:

                    if(!isset($SessionVarSitemap[$sitemap_url->url.$sitemap_url->path])){
                    $SessionVarSitemap[$sitemap_url->url.$sitemap_url->path]['session_url_sitemap'] = $sitemap_url->url.$sitemap_url->path;
                    $SessionVarSitemap[$sitemap_url->url.$sitemap_url->path]['session_sitemap_url_count'] = 0;
                    $SessionVarSitemap[$sitemap_url->url.$sitemap_url->path]['website_url_id'] = $sitemap_url->id;
                    $SessionVarSitemap[$sitemap_url->url.$sitemap_url->path]['active'] = $sitemap_url->active;
                    $SessionVarSitemap[$sitemap_url->url.$sitemap_url->path]['empty'] = true;

                    }
                    $SessionVarSitemap[$sitemap_url->url.$sitemap_url->path]['batch'] = $sitemap_url->batch;
                    $sitemap_urls[] = "{$sitemap_url->url}{$sitemap_url->path}";
                    break;

                case false :
                    if(Sitemap::if_exists_single("website_url_id",$sitemap_url->id)){
                        Sitemap::remove_script_url_sitemap($sitemap_url->id);
                        unset($SessionVarSitemap[$sitemap_url->url.$sitemap_url->path]);
                    }else{
                        unset($SessionVarSitemap[$sitemap_url->url.$sitemap_url->path]);
                    }
                    break;


            }


        }


        $cache = new CacheWarmer($SessionVarSitemap);
        $return = $cache->run($sitemap_urls);




      if(isset($return['countallurlsfound']) && $return['countallurlsfound'] == 0 && $SessionVarSitemap["active"] === false )
        {
            Sitemap::removeTable();
            ErrorMessage::create_log(0,"Script ended");
            echo "Script end";
            exit();

        }else{

          runScript();


        }

    }
    ErrorMessage::create_log(0,"function runScript ended");


?>
