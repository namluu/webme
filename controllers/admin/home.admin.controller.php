<?php
class HomeAdminController extends Controller
{
    public function __construct(array $data = array())
    {
        parent::__construct($data);
    }

    public function index()
    {
        View::renderView();
    }
}