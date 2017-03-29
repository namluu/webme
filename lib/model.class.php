<?php
class Model
{
    protected $db;

    protected $table = '';

    public function __construct()
    {
        $this->db = App::getDb();

        if (!$this->table) {
            throw new Exception('Select the table for class: '.get_class($this));
        }
    }

    /**
     * Get list items
     *
     * @param bool $onlyActive
     * @return array|bool|mysqli_result
     */
    public function getList($onlyActive = false)
    {
        $sql = "SELECT * FROM {$this->table} WHERE 1";
        if ($onlyActive) {
            $sql .= ' and is_active = 1';
        }
        return $this->db->query($sql);
    }

    /**
     * Get one record by column
     *
     * @param $key
     * @param $value
     * @return null|array
     */
    public function getBy($key, $value)
    {
        $value = $this->db->escape($value);
        if ($this->db->tableColumnExists($this->table, $key)) {
            $sql = "SELECT * FROM {$this->table} WHERE {$key} = '{$value}' limit 1";
            $result = $this->db->query($sql);
            return isset($result[0]) ? $result[0] : null;
        }
        return null;
    }

    public function countBy($key, $value)
    {
        $value = $this->db->escape($value);
        if ($this->db->tableColumnExists($this->table, $key)) {
            $sql = "SELECT COUNT(*) FROM {$this->table} WHERE {$key} = '{$value}'";
            $result = $this->db->count($sql);
            return $result;
        }
        return 0;
    }

    public function delete($id)
    {
        $id = (int)$id;
        $sql = "DELETE FROM {$this->table} WHERE id = {$id}";
        return $this->db->query($sql);
    }

    /**
     * @param $data
     * @param null $id
     * @return array|bool|mysqli_result
     */
    public function save($data, $id = null)
    {
        if (!$id) {
            $fields = '';
            $values = '';
            foreach ($data as $field => $value) {
                $value = $this->escape($value);
                $fields .= "$field,";
                $values .= (is_numeric($value) && (intval($value) == $value)) ? $value . ',' : "'$value',";
            }
            // remove our trailing
            $fields = substr($fields, 0, -1);
            // remove our trailing
            $values = substr($values, 0, -1);
            $insert = "INSERT INTO {$this->table} ({$fields}) VALUES ({$values})";
            return $this->db->query($insert);
        } else {
            $update = "UPDATE {$this->table} SET ";
            foreach ($data as $field => $value) {
                $value = $this->escape($value);
                $update .= $field . " = '{$value}',";
            }
            // remove our trailing ,
            $update = substr($update, 0, -1);
            $update .= " WHERE id = " . $id;
            return $this->db->query($update);
        }
    }

    public function escape($str)
    {
        return $this->db->escape($str);
    }

    public function searchBy($wheres, $cond = 'or')
    {
        $sql = "SELECT * FROM {$this->table} WHERE ";
        $i = 0;
        foreach ($wheres as $key => $value) {
            $value = $this->db->escape($value);
            if ($i == 0) {
                $sql .= "{$key} LIKE '%{$value}%' ";
            } else {
                $sql .= "{$cond} {$key} LIKE '%{$value}%' ";
            }
            $i++;
        }
        return $this->db->query($sql);
    }
}