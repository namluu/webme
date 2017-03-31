<?php

class CommentController extends Controller
{
    protected $articleModel;

    public function __construct(array $data = array())
    {
        parent::__construct($data);
        $this->model = new CommentModel();
        $this->articleModel = new ArticleModel();
    }

    public function add()
    {
        if ($_POST) {
            $article = $this->articleModel->getBy('id', $_POST['article_id']);
            $data = [
                'article_id' => $this->cleanInput($_POST['article_id']),
                'content' => $this->cleanInput($_POST['content'])
            ];
            $result = $this->model->save($data);
            if ($result) {
                Session::setMessage('success', 'Adding Successfully');
            } else {
                Session::setMessage('error', 'Adding Fail');
            }
            Router::redirect(getUrl('article/view/'.$article['alias']));
        }
    }
}