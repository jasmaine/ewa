<?php

/**
 * Mysql class
 */
class Mysql
{
    protected static $where;
    protected static $limit;
    protected static $orderby;

    /**
     * Start database connection and store in object
     * @return void
     */
    public function __construct()
    {
        $this->db = \Database::initConnection();
    }
    
    /**
     * Protected static for method 'where'
     *
     * @param string|array $info
     * @param string $type
     * @return string self::$where
     */
    protected static function _where($info, $type = 'AND')
    {
        foreach ($info as $row => $value) {
            if (empty($where)) {
                $where['clause'] = " WHERE $row = ?";
                $where['params'] = array($value);
                $where['type'] = substr(gettype($value), 0, 1);
            } else {
                $where['clause'] .= " $type $row = ?";
                $where['params'][] = $value;
                $where['type'] .= substr(gettype($value), 0, 1);
            }
        }
        
        self::$where = $where;
    }
    
    /**
     * Protected static for method 'limit'
     *
     * @param int $from
     * @param int $to
     * @return string self::$limit
     */
    protected static function _limit($from, $to)
    {
        if ($to == null) {
            $limit = sprintf(" LIMIT %s", $from);
        } else {
            $limit = sprintf(" LIMIT %s, %s", $from, $to);
        }
        
        self::$limit = $limit;
    }
    
    /**
     * Protected static for method 'orderby'
     *
     * @param string $field
     * @param string $order
     * @return string self::$orderby
     */
    protected static function _orderby($field, $order)
    {
        if ($field == "") {
            self::$orderby = null;
        } else {
            self::$orderby = sprintf(" ORDER BY %s %s", $field, $order);
        }
    }
    
    /**
     * Protected static to build extra select option for the get query
     *
     * @return string $extra
     */
    protected static function _extra()
    {
        $extra = '';
        
        if (self::$orderby != null) {
            $extra .= self::$orderby;
        }
        if (self::$limit != null) {
            $extra .= self::$limit;
        }
        
        return $extra;
    }
    
    /**
     * Method database where
     *
     * @param string|array $field
     * @param string $equal
     * @return $this
     */
    public function where($field, $equal = null)
    {
        if (is_array($field)) {
            self::_where($field, $equal = 'AND');
        } else {
            self::_where(array($field => $equal));
        }
        
        return $this;
    }
    
    /**
     * Method database limit
     *
     * @param int $from
     * @param int $to
     * @return $this
     */
    public function limit($from, $to = null)
    {
        self::_limit($from, $to);
        
        return $this;
    }
    
    /**
     * Method database orderby
     *
     * @param string $field
     * @param string $order
     * @return $this
     */
    public function orderby($field, $order = 'ASC')
    {
        if ($order != 'DESC' || $order != 'ASC') {
            $order = 'ASC';
        }
        self::_orderby($field, $order);
        
        return $this;
    }

    /**
     * Method database SELECT
     *
     * @param string $table
     * @param string $select
     * @return boolean false|string $data
     */
    public function get($table, $select = '*')
    {
        $where = '';
        $type = '';
        $params = false;
        $extra = self::_extra();
        
        if (self::$where != null) {
            $where = self::$where['clause'];
            $params = self::$where['params'];
            $type = self::$where['type'];
        }
        
        $sql = "SELECT $select FROM $table".$where.$extra;
        
        $stmt = $this->db->prepare($sql);

        if ($params) {
            $stmt->bind_param($type, ...$params);
        }
        
        $stmt->execute();
         
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            $data = false;
        } elseif ($result->num_rows == 1) {
            $data = $result->fetch_object();
        } else {
            $data = array();
            
            while ($row = $result->fetch_object()) {
                $data[] = $row;
            }
        }
        
        return $data;
    }
}
