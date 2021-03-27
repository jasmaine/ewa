<?php

/**
 * Validator class
 *
 * Handles basic validations.
 */
class Validator
{
    /**
     *
     * @param string $string
     *
     * @return void
     */
    private static function _s_has_low_letters($string)
    {
        return preg_match('/[a-z]/', $string);
    }

    /**
     *
     * @param string $string
     *
     * @return void
     */
    private static function _s_has_upper_letters($string)
    {
        return preg_match('/[A-Z]/', $string);
    }

    /**
     *
     * @param string $string
     *
     * @return void
     */
    private static function _s_has_numbers($string)
    {
        return preg_match('/\d/', $string);
    }

    /**
     *
     * @param string $string
     *
     * @return void
     */
    private static function _s_has_special_chars($string)
    {
        return preg_match('/[^a-zA-Z\d]/', $string);
    }

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

    /**
     * Check if the password is valid. Strict means to check for the 4 types of characters.
     * By default strict is disabled
     *
     * @param string $password
     * @param integer $length
     * @param boolean $strict
     *
     * @return bolean
     */
    public static function isValidPassword($password, $length = PASSWORD_LENGTH, $strict = false)
    {
        if (strlen($password) < $length) {
            throw new EwaException(Lang::get('password.too_short', array('length'=>$length)));
        } elseif ($strict) {
            if (self::_s_has_low_letters($password) && self::_s_has_upper_letters($password) && self::_s_has_numbers($password) && self::_s_has_special_chars($password)) {
                return true;
            } else {
                throw new EwaException(Lang::get('password.need_all'));
            }
        } else {
            return true;
        }
    }

    /**
     * Return if password match the hash
     *
     * @param string $hash
     * @param string $password
     *
     * @return bolean
     */
    public static function isMatchedPassword($hash, $password)
    {
        return password_verify($password, $hash);
    }
}
