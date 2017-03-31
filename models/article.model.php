<?php
class ArticleModel extends Model
{
    protected $table = 'cms_article';

    public function getList($onlyActive = false)
    {
        $sql = "SELECT a.*, count(c.id) as comment_number FROM {$this->table} AS a";
        $sql .= " LEFT JOIN cms_comment AS c ON a.id = c.article_id";
        if ($onlyActive) {
            $sql .= ' and a.is_active = 1';
        }
        $sql .= ' GROUP by a.id';
        return $this->db->query($sql);
    }
}