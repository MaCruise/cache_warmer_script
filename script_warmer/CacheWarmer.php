<?php


class CacheWarmer extends Dbobject
{
    var $context;
    var $continue;
    var $countpagesvisited;
    var $sitemapurl;
    var $sitemapurls;
    var $SessionVarSitemap;
    var $log;


    function __construct($SessionVarSitemap)
    {

        $this->context = stream_context_create();
        $this->countpagesvisited = 0;
        $this->SessionVarSitemap = $SessionVarSitemap;
        $this->log = [];


    }


    public function run($sitemap_urls)
    {

        $this->sitemapurls = $sitemap_urls;
        $this->continue = count($this->sitemapurls);


        foreach ($this->sitemapurls as $sitemapurl) {
            $this->sitemapurl = $sitemapurl;

            $this->SessionVarSitemap[$sitemapurl]['urls'] = $this->process_sitemap($sitemapurl);
            if (empty($this->SessionVarSitemap[$sitemapurl]['urls'])) {
                ErrorMessage::create_log($this->SessionVarSitemap[$this->sitemapurl]["website_url_id"], "Urls should not be empty");
                WebsitesController::edit($this->SessionVarSitemap[$this->sitemapurl]["website_url_id"], ["button" => '']);

            }


            !isset($this->SessionVarSitemap["active"]) || !Sitemap::if_exists_single('session_url_sitemap', $sitemapurl)
                ? $this->SessionVarSitemap[$sitemapurl]['id'] = Sitemap::create_sitemap($this->SessionVarSitemap[$sitemapurl])
                : null;

            !isset($this->SessionVarSitemap[$sitemapurl]['id'])
                ? ErrorMessage::create_log($this->SessionVarSitemap[$this->sitemapurl]["website_url_id"], "error creating a class Sitemap")
                : null;



        }


        foreach ($this->sitemapurls as $sitemapurl) {

            $this->sitemapurl = $sitemapurl;
            $urls = $this->SessionVarSitemap[$sitemapurl]['urls'];

            if (!empty($urls)) {
                for ($x = $this->SessionVarSitemap[$sitemapurl]['session_sitemap_url_count'] - 1; $x >= 0; $x--) {

                    $url_content = @file_get_contents(trim($urls[$x]), false, $this->context);
                    if (empty($url_content)) {
                        $this->log[$this->sitemapurl]["error"] = "Problem at loading urls from sitemap, $urls[$x] not found. ";
                        ErrorMessage::create_log($this->SessionVarSitemap[$this->sitemapurl]["website_url_id"], $this->log[$this->sitemapurl]["error"]);
                    }

                    if ($url_content === FALSE) {
                        $this->countpagesvisited++;
                        throw new Exception("Cannot access '$urls[$x]' to read contents.");
                    } else {
                        echo "$urls[$x] succes\n";
                        $this->countpagesvisited++;

                        $this->SessionVarSitemap['countallurlsfound']--;

                        if ($this->countpagesvisited == $this->SessionVarSitemap[$sitemapurl]['batch'] || $x == 0) {
                            $this->countpagesvisited = 0;
                            Sitemap::update_sitemap($this->SessionVarSitemap[$sitemapurl]['id'], $x/*$_SESSION[$sitemapurl]['session_sitemap_url_count']*/);
                            $this->continue--;

                            continue 2;


                        }
                    }
                }
            }

        }

        return $this->SessionVarSitemap;

    }


    public function process_sitemap($url)
    {

        $urls = array();
        $urlcounter = 0;


        if(($sitemap_xml = @file_get_contents($url, false, $this->context)) == false){
            $this->log[$this->sitemapurl]["error"] = "Problem findingurl/sitemap, check url/sitemap.";
            WebsitesController::edit($this->SessionVarSitemap[$this->sitemapurl]["website_url_id"], ["button" => '']);
            ErrorMessage::create_log($this->SessionVarSitemap[$this->sitemapurl]["website_url_id"], $this->log[$this->sitemapurl]["error"]);
        }



        if (($sitemap = @simplexml_load_string(trim($sitemap_xml))) !== false) {

            switch ($sitemap->getName()) {
                case 'sitemapindex':
                    foreach ($sitemap->sitemap as $subsitemap) {
                        $subsitemap_url = $subsitemap->loc;
                        $urls = array_merge($urls, $this->process_sitemap($subsitemap_url));
                    }

                case 'urlset':
                    $parsedUrl = parse_url($this->sitemapurl);
                    $parseUrl = $parsedUrl['scheme'] . '://' . $parsedUrl['host'];
                    foreach ($sitemap->url as $url) {
                        if (strpos((string)$url->loc, $parseUrl) !== false) {
                            $urls[] = (string)$url->loc;
                        } else {
                            $urls[] = $parseUrl . (string)$url->loc;
                            $this->log[$this->sitemapurl]["error"] = "url part missing, check sitemap.";


                        }
                        !isset($this->SessionVarSitemap["active"]) ? $this->SessionVarSitemap['countallurlsfound']++ : null;
                        $urlcounter++;
                    }

            }

            if (empty($this->SessionVarSitemap[$this->sitemapurl]['empty'] === false)) {
                $this->SessionVarSitemap[$this->sitemapurl]['session_sitemap_url_count'] = count($urls);
            }


            return $urls;
        } else {
            $this->log[$this->sitemapurl]["error"] = "Problem at simplexml_load_string when loading urls, check url/sitemap.";
            WebsitesController::edit($this->SessionVarSitemap[$this->sitemapurl]["website_url_id"], ["button" => '']);
            ErrorMessage::create_log($this->SessionVarSitemap[$this->sitemapurl]["website_url_id"], $this->log[$this->sitemapurl]["error"]);
        }


    }


}
