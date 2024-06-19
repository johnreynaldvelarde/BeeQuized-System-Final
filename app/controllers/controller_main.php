<?php

Class Controller_main extends Controller{

    function index()
    {

        $data['page_title'] = "Dashboard";

        if(isset($_POST['quizTitle'])){
            $createQuizEvent  = $this->loadModel("quizbee_module");
            $createQuizEvent->createQuizBeeEvent($_POST);
        }
        
        $showQuizEventList  = $this->loadModel("quizbee_module");
        $result = $showQuizEventList->viewQuizBeeEvent();

        $data["quizbee_module"] = $result;
        
        $this->view("interface-main/interface_dashboard", $data);
        
    }
}