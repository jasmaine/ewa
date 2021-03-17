<?php

/**
 * EwaException class
 */
class EwaException extends Exception
{
    private $error;
    
    /**
     * get the error code and set private @var $error
     */
    public function __construct($error = '')
    {
        $this->error = $error;
    }
    
    /**
     * Get data and build an error array
     *
     * @return $errorData
     */
    public function errorData()
    {
        $errorData = array(
            'timestamp' =>  date('Y-m-d H:m:s'),
            'page'      =>  $_SERVER['REQUEST_URI'],
            'language'  =>  substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2),
            'message'   =>  $this->error
        );
        
        return $errorData;
    }
    
    /**
     * Return error message as plain text
     *
     * @return $this->error
     */
    public function errorMessage()
    {
        return $this->error;
    }
    
    /**
     * Return error message styled
     *
     * @return void
     */
    public function errorDisplay()
    {
        return "<div class='error-message'><strong>Error message</strong><br/>(".date('Y-m-d H:m:s').") ".$this->error;
    }
}
