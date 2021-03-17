<?php
    
/**
 * Website class
 *
 * This will load the config file
 * And builds up the website template
 */
class Website
{

    /**
     * Load Config File
     *
     * @param string $config
     * @return void
     */
    public function __construct($config)
    {
        if (file_exists(BASEPATH.'app/lib/config/'.$config.'.conf.php')) {
            include_once(BASEPATH.'app/lib/config/'.$config.'.conf.php');
        }
    }

    /**
     * Load a template from the view folder
     * Parse data to the template by populating the @var $data
     *
     * @param string @view
     * @param string|array $data = ''
     * @return void
     */
    public function loadView($view, $data = '')
    {
        if (file_exists(BASEPATH.APPLOC.'/view/'.$view.'.php')) {
            include_once(BASEPATH.APPLOC.'/view/'.$view.'.php');
        }
    }
    
    /**
     * Parse the url and return the items
     * @var array $pda to parse the pages and get vars to use in methods
     * @var array $pda['renderPage'] to handle the template loader
     *
     * @param string $page
     * return array $pda
     */
    private function pageBuilder($page)
    {
        $pda['renderPage'] = explode('/', $page);
    
        /**
         * We declare this for the following reason
         * $pageData to use to catch all the key=>value
         * $pda['renderPage'] to look for the requested page
         */
        $pageData = $pda['renderPage'];
    
        array_shift($pageData);
    
        $pageDataCount = count($pageData);
    
        $i = 0;
        $pda['odd'] = false;
    
        // After the while you can get the key values in the complete app by
        // $pda['key'] which will get the attached value.
        while ($i < $pageDataCount) {
        
            // only set key values when the are both present
            if (isset($pageData[$i],$pageData[$i + 1])) {
            
                // set the first item as the key and the second as the value
                $pda[$pageData[$i]] = $pageData[$i + 1];
            } elseif (isset($pageData[$i])) {
            
                // This item will be made if there are odd vars in the url
                // So 1, 3, 5, etc. When the value of the key is missing
                $pda['odd'] = $pageData[$i];
            }
            
            // because we get the key value, we skip 2 items every loop
            $i = $i + 2;
        }
        
        return $pda;
    }
    
    /**
     * Load the SEO data and set the variables in a constant
     *
     * @param string $page
     * @param string $odd
     * @param string $title
     * return void
     */
    private function loadSEO($page, $odd, $title)
    {
        if ($odd) {
            $file = $odd;
        } else {
            $file = $page;
        }
    
        if (file_exists(BASEPATH.APPLOC.'/lib/config/seo/'.$file.'.conf.php')) {
            include_once(BASEPATH.APPLOC.'/lib/config/seo/'.$file.'.conf.php');
        } else {
            define("TITLE", $title);
            define("DESCRIPTION", "");
            define("KEYWORDS", "");
        }
    }
    
    /**
     * Load endpoint files for $_POST and $_GET methods
     * Post, sending data for saving | Get, for getting data
     *
     * @param string $file The requested action for example: getallusers
     * @param string $method defines if it is a post or get
     * @return void
     */
    private function loadJsFile($file, $method = 'get')
    {
        if (file_exists(BASEPATH.APPLOC.'/lib/actions/'.$method.'/'.$file.'.php')) {
            include_once(BASEPATH.APPLOC.'/lib/actions/'.$method.'/'.$file.'.php');
        } else {
            exit(Header('Location:'.URI));
        }
    }
    
    /**
     * Load the website template and return to the view
     *
     * @param string $page
     * @param object $app
     * @return void
     */
    public function loadTemplate($page, $app)
    {
        $rp = $this->pageBuilder($page);
        
        if ($rp['renderPage'][0] == 'post' || $rp['renderPage'][0] == 'get') {
            $this->loadJsFile($rp['odd'], $rp['renderPage'][0]);
        } else {
            $this->loadSEO($rp['renderPage'][0], $rp['odd'], WEBSITE_TITLE);
        
            if (file_exists(BASEPATH.APPLOC.'/index/'.$rp['renderPage'][0].'.php')) {
                $template = explode(',', TEMPLATE_PLAIN);
            
                if (!in_array($rp['renderPage'][0], $template)) {
                    include_once(BASEPATH.APPLOC.'/template/_header.php');
                    include_once(BASEPATH.APPLOC.'/index/'.$rp['renderPage'][0].'.php');
                    include_once(BASEPATH.APPLOC.'/template/_footer.php');
                } else {
                    include_once(BASEPATH.APPLOC.'/index/'.$rp['renderPage'][0].'.php');
                }
            } else {
                include_once(BASEPATH.APPLOC.'/template/404.php');
            }
        }
    }
    
    /**
     * Load the url page vars
     *
     * @param string $page
     * @return array
     */
    public function getPages($page)
    {
        return $this->pageBuilder($page);
    }
}
