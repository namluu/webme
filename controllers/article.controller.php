<?php

class ArticleController extends Controller
{

    protected $commentModel;

    public function __construct(array $data = array())
    {
        parent::__construct($data);
        $this->model = new ArticleModel();
        $this->commentModel = new CommentModel();
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
            $data['comments'] = $this->commentModel->searchBy(['article_id' => $data['id']]);
            View::renderView($data);
        }
    }

    public function add()
    {
        if ($_POST) {
            $data = [
                'title' => $this->cleanInput($_POST['title']),
                'alias' => $this->cleanInput($_POST['alias']),
                'description' => $this->cleanInput($_POST['description']),
                'content' => $this->cleanInput($_POST['content'])
            ];
            $result = $this->model->save($data);
            if ($result) {
                Session::setMessage('success', 'Adding Successfully');
                Router::redirect(getUrl('article/view/'.$data['alias']));
            } else {
                Session::setMessage('error', 'Adding Fail');
            }
        }
        View::renderView();
    }
}