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
}