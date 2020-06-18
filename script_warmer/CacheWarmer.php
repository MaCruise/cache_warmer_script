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

                        $this->error_message("Problem at loading urls from sitemap, $urls[$x] not found.");
                        $this->error_message($this->curl_error_test($urls[$x]));
                        // create a new cURL resource



                    }

                    if ($url_content === FALSE) {
                        $this->countpagesvisited++;
                        $this->error_message("Cannot access '$urls[$x]' to read contents.");
                        $this->error_message($this->curl_error_test($urls[$x]));
                    } else {
                        echo "$urls[$x] succes\n";
                        $this->countpagesvisited++;

                        $this->SessionVarSitemap['countallurlsfound']--;

                        if ($this->countpagesvisited == $this->SessionVarSitemap[$sitemapurl]['batch'] || $x == 0) {
                            $this->countpagesvisited = 0;
                            Sitemap::update_sitemap($this->SessionVarSitemap[$sitemapurl]['id'], $x);       /*update sitmap*/
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


        if(($sitemap_xml = @file_get_contents($url, false, $this->context)) == false)
        {
            $this->error_message("Problem finding url/sitemap, check url/sitemap.",true);
            $this->error_message($this->curl_error_test($sitemap_xml));

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

                        /*generating pasre url when sitemap xml cuts piece*/

                        if (strpos((string)$url->loc, $parseUrl) !== false) {
                            $urls[] = (string)$url->loc;
                        } else {
                            $urls[] = $parseUrl . (string)$url->loc;



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
            $this->error_message("Problem at simplexml_load_string when loading urls, check url/sitemap.",true);
            $this->error_message($this->curl_error_test($sitemap_xml));
        }


    }

    function error_message($error,$disableUrl = false){
        ErrorMessage::create_log($this->SessionVarSitemap[$this->sitemapurl]["website_url_id"],$error);
        is_bool($disableUrl)===true
            ?WebsitesController::edit($this->SessionVarSitemap[$this->sitemapurl]["website_url_id"], ["button" => ''])
            :null;
        return;
    }

        function curl_error_test($url) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $responseBody = curl_exec($ch);
            /*
             * if curl_exec failed then
             * $responseBody is false
             * curl_errno() returns non-zero number
             * curl_error() returns non-empty string
             * which one to use is up too you
             */
            if ($responseBody === false) {
                return "CURL Error: " . curl_error($ch);
            }

            $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            /*
             * 4xx status codes are client errors
             * 5xx status codes are server errors
             */
            if ($responseCode >= 400) {
                return "HTTP Error: " . $responseCode;
            }

            return "No CURL or HTTP Error";
        }


}
