<?php

Class History extends Controller{

    function index()
    {
        $data['page_title'] = "History";
        $this->view("interface-main/interface_history", $data);
    }
}