<?php

/**
 * autoload classes only when the are initialized
 * use the path_to_the_file_and_classname
 *
 * @param string $className
 * @return void
 */
spl_autoload_register(function ($className) {
    $includeClass = 'app/lib/classes/' . str_replace("\\", DIRECTORY_SEPARATOR, $className);
     
    include_once(BASEPATH. '/' . $includeClass . '.php');
});
