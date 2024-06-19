<?php
Class Controller_history extends Controller{

    function index()
    {
        $data['page_title'] = "History";
        $this->view("interface-main/interface_history", $data);
    }
}