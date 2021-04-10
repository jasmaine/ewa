<?php

/**
* Language class
*/

class Lang
{
    /**
     * Return the language file path
     *
     * @return array
     */
    public static function getFileByLang()
    {
        $userLang = Lang::getUserLang();

        if (file_exists(BASEPATH.APPLOC.'/lib/config/lang/'.$userLang.'.lang.php')) {
            return include(BASEPATH.APPLOC.'/lib/config/lang/'.$userLang.'.lang.php');
        } else {
            return include(BASEPATH.APPLOC.'/lib/config/lang/'.WEBSITE_BASIC_LANG.'.lang.php');
        }
    }

    /**
     * Return the language key=>value
     *
     * @return string
     */
    public static function getUserLang()
    {
        if (isset($_SESSION['language'])) {
            return $_SESSION['language'];
        } else {
            return substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
        }
    }

    /**
     * Get the translation value based on a given key
     *
     * @param string $key
     * @return string
     */
    public static function get($key, $value = null)
    {
        // Explode the keys
        $keys = explode(".", $key);

        // Get the complete translation file as array
        $lang = Lang::getFileByLang();

        // Search the key value
        for ($i = 0;$i < count($keys) ;$i++) {
            if (array_key_exists($keys[$i], $lang)) {
                $lang = $lang[$keys[$i]];
            }
        }

        // Replace dynamic values
        if (is_array($value)) {
            foreach ($value as $k=>$v) {
                $lang = str_replace('{'.$k.'}', $v, $lang);
            }
        }

        // Return the translation
        if (!is_array($lang)) {
            return $lang;
        }
    }
}
