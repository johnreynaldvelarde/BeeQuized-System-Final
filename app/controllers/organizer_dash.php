<?php

Class Organizer_dash extends Controller{

    
    function index()
    {
        $data['page_title'] = "Dashboard";
        //$this->view("dashboard1", $data);
        $this->view("interface-dash/organizer_dashboard", $data);
    }

}