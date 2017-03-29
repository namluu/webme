<?php
class ArticleAdminController extends Controller
{
    public function __construct(array $data = array())
    {
        parent::__construct($data);
        $this->model = new ArticleModel();
    }

    public function index()
    {
        $data = $this->model->getList();
        View::renderView($data);
    }

    public function edit()
    {
        if ($_POST) {
            $id = isset($_POST['id']) ? (int)$_POST['id'] : null;
            $errorMsg = $this->validateData($_POST);
            if ($errorMsg) {
                Session::setMessage('error', join('<br>', $errorMsg));
            } else {
                $data = $this->sanitizeData($_POST);
                $result = $this->model->save($data, $id);
                if ($result) {
                    Session::setMessage('success', 'Edit Successfully');
                } else {
                    Session::setMessage('error', 'Edit Fail');
                }
                Router::redirect(getAdminUrl('article'));
            }
        } else {
            if (isset($this->params[0])) {
                $id = (int)$this->params[0];
                $content = $this->model->getBy('id', $id);
                if ($content) {
                    View::renderView($content);
                }
                else {
                    Session::setMessage('error', 'Wrong article id');
                    Router::redirect(getAdminUrl('article'));
                }
            }
        }
    }

    public function add()
    {
        if ($_POST) {
            $errorMsg = $this->validateData($_POST);
            if ($errorMsg) {
                Session::setMessage('error', join('<br>', $errorMsg));
            } else {
                $data = $this->sanitizeData($_POST);
                $result = $this->model->save($data);
                if ($result) {
                    Session::setMessage('success', 'Adding Successfully');
                } else {
                    Session::setMessage('error', 'Adding Fail');
                }
                Router::redirect(getAdminUrl('article'));
            }

        }
        View::renderView();
    }

    protected function validateData($data)
    {
        $msg = array();
        if (empty($data['title'])) {
            $msg[] = 'Missing title';
        }
        if (empty($data['alias'])) {
            $msg[] = 'Missing alias';
        }
        if (empty($data['content'])) {
            $msg[] = 'Missing content';
        }
        return $msg;
    }

    protected function sanitizeData($data)
    {
        $escapeData = [
            'title' => $this->cleanInput($data['title']),
            'alias' => $this->cleanInput($data['alias']),
            'description' => $this->cleanInput($data['description']),
            'content' => $this->cleanInput($data['content']),
            'is_active' => isset($data['is_active']) ? 1 : 0
        ];
        return $escapeData;
    }

    public function delete()
    {
        if (isset($this->params[0])) {
            $result = $this->model->delete($this->params[0]);
            if ($result) {
                Session::setMessage('success', 'Success');
            } else {
                Session::setMessage('error', 'Fail');
            }
        }
        Router::redirect(getAdminUrl('article'));
    }
}