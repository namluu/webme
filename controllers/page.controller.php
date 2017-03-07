<?php

class PageController extends Controller
{
    public function __construct(array $data = array())
    {
        parent::__construct($data);
        $this->model = new PageModel();
    }

    public function index()
    {
        $data = $this->model->getList();
        View::renderView($data);
    }

    public function view()
    {
        $params = App::getRouter()->getParams();

        if (isset($params[0])) {
            $alias = strtolower($params[0]);
            $data = $this->model->getBy('alias', $alias);
            View::renderView($data);
        }
    }

    public function admin_index()
    {
        $data = $this->model->getList();
        View::renderView($data);
    }

    public function admin_edit()
    {
        if ($_POST) {
            $id = isset($_POST['id']) ? (int)$_POST['id'] : null;
            $result = $this->model->save($_POST, $id);
            if ($result) {
                Session::setMessage('success', 'Success');
            } else {
                Session::setMessage('error', 'Fail');
            }
            Router::redirect(getAdminUrl('page'));
        } else {

            if (isset($this->params[0])) {
                $id = (int)$this->params[0];
                $content = $this->model->getBy('id', $id);
                if ($content) {
                    View::renderView($content);
                }
                else {
                    Session::setMessage('error', 'Wrong page id');
                    Router::redirect(getAdminUrl('page'));
                }
            }
        }
    }

    public function admin_add()
    {
        if ($_POST) {
            $result = $this->model->save($_POST);
            if ($result) {
                Session::setMessage('success', 'Success');
            } else {
                Session::setMessage('error', 'Fail');
            }
            Router::redirect(getAdminUrl('page'));
        } else {
            View::renderView();
        }
    }

    public function admin_delete()
    {
        if (isset($this->params[0])) {
            $result = $this->model->delete($this->params[0]);
            if ($result) {
                Session::setMessage('success', 'Success');
            } else {
                Session::setMessage('error', 'Fail');
            }
        }
        Router::redirect(getAdminUrl('page'));
    }
}