<?php

class Helper
{
    /**
     * Generate a PIN code with only numbers
     *
     * @param int $length
     * @return string $pin
     */
    public static function generatePin($length)
    {
        $i = 0;
        $pin = "";

        while ($i < $length) {
            $pin .= mt_rand(0, 9);
            $i++;
        }

        return $pin;
    }

    /**
     * Generate a code based numbers and letter
     *
     * @param int $length
     * @return string $result
     */
    public static function generateCode($length)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $countChars = strlen($characters) - 1;
        $result = '';

        for ($i = 0; $i < $length; $i++) {
            $result .= $characters[mt_rand(0, $countChars)];
        }

        return $result;
    }

    /**
     * Generate a password hash
     *
     * @param string $password
     * @return string
     */
    public static function generatePassHash($password)
    {
        $options = [
            'cost' => PASSWORD_HASH_STRENGTH,
        ];

        return password_hash($password, PASSWORD_DEFAULT, $options);
    }
}
