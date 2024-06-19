<?php

Class Audience extends Controller{

    function index(){

        $data['page_title'] = "Quiz Event";
        $this->view("check-generated-code/audiance", $data);
    }
}