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
            if (empty($_POST['email']) || empty($_POST['name']) || empty($_POST['message'])) {
                Session::setMessage('error', 'Please enter your contact');
            } else {
                $escapeData = [
                    'email' => $this->cleanInput($_POST['email']),
                    'name' => $this->cleanInput($_POST['name']),
                    'message' => $this->cleanInput($_POST['message'])
                ];
                if ($this->model->save($escapeData)) {
                    Session::setMessage('success', 'Add contact successfully');
                    Router::redirect(getUrl('contact'));
                }
            }
        }
        View::renderView();
    }
}