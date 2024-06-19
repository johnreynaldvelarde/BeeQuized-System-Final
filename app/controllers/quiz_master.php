<?php

Class Quiz_master extends Controller{

    function index(){

        $data['page_title'] = "Quizmaster Creation";

        $detailsQuizMaster = $this->loadModel("insert");

        if(isset($_POST['action'])){

            // add quiz master
            if($_POST['action'] == 'set_quizmaster'){
                $detailsQuizMaster->set_quizmaster($_POST);
                exit;
            }
        }


        if (isset($_SESSION['event_id'])) {
            $data['event_id'] = $_SESSION['event_id']; 
        } else {
            $_SESSION['error'] = "No event ID provided.";
            header("Location: " . ROOT . "error_page"); 
            exit;
        }

        $this->view("interface-main/interface_quiz_master", $data);
    }

}