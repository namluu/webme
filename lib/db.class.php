<?php
class Db
{
    protected $connection;

    protected $table = '';

    public function __construct($host, $user, $password, $db_name)
    {
        $this->connection = new mysqli($host, $user, $password, $db_name);

        if (mysqli_connect_error()) {
            throw new Exception('Could not connect to DB');
        }
    }

    /**
     * Execute query SQL
     *
     * @param $sql
     * @return array|bool|mysqli_result
     * @throws Exception
     */
    public function query($sql)
    {
        if (!$this->connection) {
            return false;
        }
        $result = $this->connection->query($sql);

        if (mysqli_error($this->connection)) {
            throw new Exception(mysqli_error($this->connection));
        }
        if (is_bool($result)) {
            return $result;
        }
        $data = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        return $data;
    }

    public function count($sql)
    {
        if (!$this->connection) {
            return false;
        }
        $result = $this->connection->query($sql);

        if (mysqli_error($this->connection)) {
            throw new Exception(mysqli_error($this->connection));
        }
        if (is_bool($result)) {
            return $result;
        }

        $row = $result->fetch_row();
        return $row[0];
    }

    /**
     * Escapes special characters in a string for use in an SQL
     *
     * @param $str
     * @return string
     */
    public function escape($str)
    {
        return mysqli_escape_string($this->connection, $str);
    }

    /**
     * Check column exists in table
     *
     * @param $table
     * @param $column
     * @return bool
     */
    public function tableColumnExists($table, $column)
    {
        $result = $this->query("SHOW COLUMNS FROM {$table} LIKE '{$column}'");
        return count($result) ? TRUE : FALSE;
    }
}