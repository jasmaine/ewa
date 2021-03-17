<?php
    
/*
 * Database class
 *
 * Connect to the database: $db = lib_classes_db::initConnection();
 */
class Database
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
    public static function initConnection()
    {
        if (!isset(self::$_connection)) {
            self::$_connection = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
        }
        
        return self::$_connection;
    }
}
