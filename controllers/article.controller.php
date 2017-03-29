<?php

class ArticleController extends Controller
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

    public function view()
    {
        $params = $this->getParams();

        if (isset($params[0])) {
            $alias = strtolower($params[0]);
            $data = $this->model->getBy('alias', $alias);
            View::renderView($data);
        }
    }
}