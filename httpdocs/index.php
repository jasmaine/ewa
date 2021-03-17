<?php
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/
/**********************************
 *                                *
 * Mesic / Pasarella WebApp v.2.  *
 * Date: 15 March 2021            *
 *                                *
 * (c) STUDIO PASARELLA 2021      *
 *                                *
 * by Mike Pasarella              *
 *                                *
 * studio@psaarella.eu            *
 * www.pasarella.eu               *
 *                                *
 **********************************/
 
session_start();

/**
 * Define basic path
 * Used within the complete website
 * Needed for the autoloader
 */
define("BASEPATH", explode('httpdocs', $_SERVER['DOCUMENT_ROOT'])[0]);

/**
 * Include the autoloader
 */
include_once(BASEPATH.'/app/lib/autoload.php');

/**
 * Initiate the website app
 * autoload the config
 */
$app = new Website('basic');

/*
 * Set the basic startpage to load
 *
 * @var string $page
 */
$page = START_PAGE;

/*
 * Load Language File
 *
 * @param string @lang
 * @return string
 */
function trans($lang)
{
    return Lang::get($lang);
}
 
/**
 * Catch the vars from the url
 */
if (isset($_GET['find'])) {
    if (preg_match("/^[a-z0-9-\/]+$/i", $_GET['find'])) {
        $page = $_GET['find'];
    }
}

/**
 * Load the template
 */
$app->loadTemplate($page, $app);
