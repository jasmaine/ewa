<?php

/*
 * Database class
 *
 * Connect to the database: $db = lib_classes_db::initConnection();
 */
class DbConn
{
    private static $_connection;

    private function __construct()
    {
    }

    /**
     * Initiate the connection and setup db connection
     *
     * @return object self::$_connection
     */
    public static function initConnection($type)
    {
        if (!isset(self::$_connection)) {
            switch ($type) {
                case 'mysql':
                    self::$_connection = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
                    break;
                default:
                    self::$_connection = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
                    break;
            }
        }

        return self::$_connection;
    }
}
