<?php

class Controller_leaderboards extends Controller {

    function index()
    {
        $data['page_title'] = "Services";
        $this->view("interface-main/interface_leaderboards", $data);
    }
}