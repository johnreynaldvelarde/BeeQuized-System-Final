<?php

Class Createteam extends Controller{

    function index()
    {
        $data['page_title'] = "Create a team";
        $this->view("interface-code/audiance", $data);
    }
}
