<?php

/*
 * autoload classes only when the are initialized
 * use the path_to_the_file_and_classname
 *
 */

spl_autoload_register(function ($className) {

    /*
     * replace underscore to build the path to the file and classname
     *
     */
     
    $includeClass = 'app/lib/classes/' . str_replace("\\", DIRECTORY_SEPARATOR, strtolower($className));
    
    /*
     * include the file with the requested classname
     *
     */
     
    include_once(BASEPATH. '/' . $includeClass . '.class.php');
});
