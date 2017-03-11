<?php

class ContactAdminController extends Controller
{
    public function __construct(array $data = array())
    {
        parent::__construct($data);
        $this->model = new ContactModel();
    }

    public function index()
    {
        $content = $this->model->getList();
        View::renderView($content);
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
                Router::redirect(getAdminUrl('contact'));
            }

        }
        View::renderView();
    }

    protected function validateData($data)
    {
        $msg = array();
        if (empty($data['email'])) {
            $msg[] = 'Missing email';
        }
        if (empty($data['name'])) {
            $msg[] = 'Missing name';
        }
        if (empty($data['message'])) {
            $msg[] = 'Missing message';
        }
        return $msg;
    }

    protected function sanitizeData($data)
    {
        $escapeData = [
            'email' => $this->cleanInput($data['email']),
            'name' => $this->cleanInput($data['name']),
            'message' => $this->cleanInput($data['message'])
        ];
        return $escapeData;
    }
}