<?php
class PageModel extends Model
{
    protected $table = 'cms_page';

    public function save($data, $id = null)
    {
        if (!isset($data['title']) || !isset($data['alias']) || !isset($data['content'])) {
            return false;
        }

        $id = (int)$id;
        $title = $this->db->escape($data['title']);
        $alias = $this->db->escape($data['alias']);
        $description = $this->db->escape($data['description']);
        $content = $this->db->escape($data['content']);
        $active = isset($data['is_active']) ? 1 : 0;

        if (!$id) {
            $sql = "INSERT INTO cms_page
                    SET title = '{$title}',
                        alias = '{$alias}',
                        description = '{$description}',
                        content = '{$content}',
                        is_active = {$active}";
        } else {
            $sql = "UPDATE cms_page
                    SET title = '{$title}',
                        alias = '{$alias}',
                        description = '{$description}',
                        content = '{$content}',
                        is_active = {$active}
                    WHERE id = {$id}";
        }
        return $this->db->query($sql);
    }
}