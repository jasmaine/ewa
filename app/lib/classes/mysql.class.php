<?php


class Mysql
{
	
    protected static $where;
    protected static $limit;

    public function __construct()
    {
        $this->db = \Database::initConnection();
    }
    

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
    
    
    protected static function _limit($from, $to)
    {
        if ($to == null) {
            $limit = sprintf(" LIMIT %s", $from);
        } else {
            $limit = sprintf(" LIMIT %s, %s", $from, $to);
        }
        
        self::$limit = $limit;
    }
    

    public function where($field, $equal = null)
    {
        if (is_array($field)) {
            self::_where($field, $equal = 'AND');
        } else {
            self::_where(array($field => $equal));
        }
        
        return $this;
    }
    
    
    public function limit($from, $to = null)
    {
        self::_limit($from, $to);
        
        return $this;
    }


    public function get($table, $select = '*')
    {
        $where = '';
        $type = '';
        $params = false;
        $limit = '';
        
        if (self::$where != null) {
            $where = self::$where['clause'];
            $params = self::$where['params'];
            $type = self::$where['type'];
        }
        
        if (self::$limit != null) {
            $limit = self::$limit;
        }
        
        $sql = "SELECT $select FROM $table".$where.$limit;
        
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
