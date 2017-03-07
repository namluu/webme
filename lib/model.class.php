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
     * @return null
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

    public function delete($id)
    {
        $id = (int)$id;
        $sql = "DELETE FROM {$this->table} WHERE id = {$id}";
        return $this->db->query($sql);
    }

    public function save($data, $id)
    {
        $update = "UPDATE ".$this->table." SET ";
        foreach ($data as $field => value) {
        {
            $update .= $field . " = '{value}','";
        }
    }
    }
}