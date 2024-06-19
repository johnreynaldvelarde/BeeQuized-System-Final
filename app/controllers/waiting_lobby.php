<?php


class Waiting_lobby extends Controller{

    function index()
    {

        $data['page_title'] = "Waiting a team";

        $detailLobby = $this->loadModel("read");


        if(isset($_GET['action'])){


            // get quiz master list based on event_id
            if($_GET['action'] == 'get_quiz_master'){

                $event_id = $_SESSION['event_id']; // Assuming event_id is stored in session
                $quiz_masters = $detailLobby->get_quiz_masters($event_id);
                echo json_encode($quiz_masters);
                exit; 
            }

            if($_GET['action'] == 'get_teams'){

                $event_id = $_SESSION['event_id']; // Assuming event_id is stored in session
                $teams = $detailLobby->get_teams($event_id);
                echo json_encode($teams);
                exit; 
            }
        }
        
        $this->view("interface-main/interface_waiting_lobby", $data);
    }
}