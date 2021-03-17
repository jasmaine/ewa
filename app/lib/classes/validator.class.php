<?php
    
/**
 * Validator class
 *
 * Handles basic validations.
 */
class Validator
{
    
    /**
     * Check if the chars are only Numbers and Letters
     *
     * @param int|string $v
     * @return 1 if the pattern matches given subject, 0 if it does not, or false if an error occurred
     */
    public static function isValidAlphaNum($v)
    {
        return preg_match('/^[A-Za-z0-9]+$/i', $v);
    }
    
    /**
     * Check if the chars are only Numbers
     *
     * @param int|string $v
     * @return 1 if the pattern matches given subject, 0 if it does not, or false if an error occurred
     */
    public static function isValidNum($v)
    {
        return preg_match('/^[0-9]+$/i', $v);
    }
    
    /**
     * Check if the e-mail is valid
     *
     * @param string $mail
     * return false|null
     */
    public static function isValidEmail($mail)
    {
        $mail = filter_var($mail, FILTER_SANITIZE_EMAIL);
        
        if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
    }
}
