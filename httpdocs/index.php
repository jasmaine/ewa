<?php
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/
/*************************************
 *                                   *
 * Mesic / Pasarella WebApp v.2.0.0b *
 * Date: 22 March 2021               *
 *                                   *
 * (c) STUDIO PASARELLA 2021         *
 *                                   *
 * by Mike Pasarella                 *
 *                                   *
 * studio@psaarella.eu               *
 * www.pasarella.eu                  *
 *                                   *
 *************************************/

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
include_once(BASEPATH.'app/lib/autoload.php');

/**
 * Include the Composer autoloader
 */
include_once(BASEPATH.'/vendor/autoload.php');

/**
 * Initiate the website app
 * autoload the config
 */
$app = new Website('basic');

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
 * Load the template and passing the Website methods
 */
$app->loadTemplate($app);
