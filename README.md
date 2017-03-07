# webme
_A beautiful PHP Framework_
- Good organization - MVC
- Easy to reuse code - libraries
- Isolating the Layout
- Front Controller
###Controller
```php
# controllers/page.controller.php
public function index()
{
    $data = $this->model->getList();
    View::renderView($data);
}
```

###Model
```php
# models/page.model.php
class PageModel extends Model
{
    protected $table = 'cms_page';

    public function save($data, $id = null)
    {
        if (!isset($data['title']) || !isset($data['alias']) || !isset($data['content'])) {
            return false;
        }

        $id = (int)$id;
        $escapeData = [
            'title' => $this->db->escape($data['title']),
            'alias' => $this->db->escape($data['alias']),
            'description' => $this->db->escape($data['description']),
            'content' => $this->db->escape($data['content']),
            'is_active' => isset($data['is_active']) ? 1 : 0
        ];

        return parent::save($escapeData, $id);
    }
}
```


Markdown | Less | Pretty
--- | --- | ---
*Still* | `renders` | **nicely**
1 | 2 | 3