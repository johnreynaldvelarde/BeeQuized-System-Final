<?php

class Create_team extends Controller {
    
    function index() {

        $data['page_title'] = "Team Creation";

        $detailTeam = $this->loadModel("insert");


        if(isset($_POST['action'])){

            // add team and members
            if($_POST['action'] == 'set_team'){
                $detailTeam->set_team($_POST);
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


        $this->view("interface-main/interface_create_team", $data);
    }
}
