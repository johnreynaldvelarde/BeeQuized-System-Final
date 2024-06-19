<?php

Class Main_quiz_event extends Controller{

    
    function index(){

        $data['page_title'] = "Quiz Event";
        $this->view("interface-view/realtime_quiz_event", $data);
    }
}