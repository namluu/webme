<?php
class ContactModel extends Model
{
    protected $table = 'contact_message';

    /**
     * @param $data
     * @param int $id
     * @return bool
     */
    public function save($data, $id = null)
    {
        if (!isset($data['email']) || !isset($data['name']) || !isset($data['message'])) {
            return false;
        }
        $id = (int)$id;
        $escapeData = [
            'email' => $this->db->escape($data['email']),
            'name' => $this->db->escape($data['name']),
            'message' => $this->db->escape($data['message'])
        ];

        return parent::save($escapeData, $id);
    }
}