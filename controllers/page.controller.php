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
}