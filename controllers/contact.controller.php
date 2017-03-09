<?php

class ContactController extends Controller
{
    public function __construct(array $data = array())
    {
        parent::__construct($data);
        $this->model = new ContactModel();
    }

    public function index()
    {
        if ($_POST) {
            if ($this->model->save($_POST)) {
                Session::setMessage('success', 'Success');
                Router::redirect(getUrl('contact'));
            }
        } else {
            View::renderView();
        }
    }
}