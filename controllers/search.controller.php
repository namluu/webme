<?php
class SearchController extends Controller
{
    public function __construct(array $data = array())
    {
        parent::__construct($data);
        $this->model = new UserModel();
    }

    public function index()
    {
        if ($_GET && isset($_GET['q'])) {
            $query = $_GET['q'];
            $data = [
                'username' => $query,
                'email' => $query
            ];
            $list = $this->model->searchBy($data);
        }
        View::renderView($list);
    }
}