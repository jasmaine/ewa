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

        if (is_array($select)) {
            $select = implode(",", $select);
        }

        $sql = "SELECT $select FROM $table".$where.$extra;

        if (!$stmt = $this->db->prepare($sql)) {
            throw new EwaException($this->db->error);
        }

        if ($params) {
            $stmt->bind_param($type, ...$params);
        }

        if (!$stmt->execute()) {
            throw new EwaException($stmt->error);
        }

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

    /**
     * Method database add (INSERT INTO)
     *
     * @param string $table
     * @param array $fields
     * @return true
     */
    public function add($table = null, $fields = null)
    {
        if (!empty($table) and !empty($fields) and is_array($fields)) {
            $amountFields = count($fields);
            $type = '';
            $value = array();

            foreach ($fields as $k => $v) {
                $inserFields[] = $k;
                $insertPlaceholder[] = '?';
                $value[] = $v;
                $type .= substr(gettype($v), 0, 1);

                if (Validator::isValidNum($k)) {
                    throw new EwaException('The insert rows and values do not match.');
                }
            }

            $sql = "INSERT INTO ".$table." (".implode(',', $inserFields).") VALUES (".implode(',', $insertPlaceholder).")";

            if (!$stmt = $this->db->prepare($sql)) {
                throw new EwaException($this->db->error);
            }

            $stmt->bind_param($type, ...$value);

            if (!$stmt->execute()) {
                throw new EwaException($stmt->error);
            }

            if ($stmt->affected_rows == 1) {
                return true;
            }
        } else {
            throw new EwaException('No correct insert data given.');
        }
    }

    /**
     * Method database update (UPDATE $table SET)
     *
     * @param string $table
     * @param array $fields
     * @return true
     */
    public function update($table, $fields = null)
    {
        if (!empty($table) and !empty($fields) and is_array($fields)) {
            $where = '';
            $params = false;
            $type = '';
            $value = array();

            foreach ($fields as $k => $v) {
                if (empty($set)) {
                    $set = $k ."= ?";
                } else {
                    $set .= ", ".$k ."= ?";
                }
                $value[] = $v;
                $type .= substr(gettype($v), 0, 1);
            }

            if (self::$where != null) {
                $where = self::$where['clause'];
                $params = self::$where['params'];
                $type .= self::$where['type'];
            }

            $sql = "UPDATE $table SET ".$set.$where;

            if (!$stmt = $this->db->prepare($sql)) {
                throw new EwaException($this->db->error);
            }

            $stmt->bind_param($type, ...$value, ...$params);

            if (!$stmt->execute()) {
                throw new EwaException($stmt->error);
            }

            if ($stmt->affected_rows < 1) {
                throw new EwaException('No records have been changed.');
            } else {
                return true;
            }
        } else {
            throw new EwaException('No correct insert data given.');
        }
    }

    /**
     * Method database remove (DELETE)
     *
     * @param string $table
     * @return true
     */
    public function remove($table)
    {
        if (!empty($table) && self::$where != null) {
            $where = '';
            $params = false;
            $type = '';

            $where = self::$where['clause'];
            $params = self::$where['params'];
            $type .= self::$where['type'];

            $sql = "DELETE FROM $table".$where;

            if (!$stmt = $this->db->prepare($sql)) {
                throw new EwaException($this->db->error);
            }

            $stmt->bind_param($type, ...$params);

            if (!$stmt->execute()) {
                throw new EwaException($stmt->error);
            }

            if ($stmt->affected_rows < 1) {
                throw new EwaException('No records have been changed.');
            } else {
                return true;
            }
        } else {
            throw new EwaException('No correct insert data given.');
        }
    }
}
