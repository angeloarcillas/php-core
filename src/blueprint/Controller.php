<?php

class Controller
{
    public function render($view, $params = [])
    {
        extract($params);
        return require_once $view;
    }
}


class ChildController extends Controller
{
    public function index()
    {
        $this->render('welcocme');
    }
}
