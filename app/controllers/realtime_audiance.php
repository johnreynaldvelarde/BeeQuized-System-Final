<?php

class Realtime_audiance extends Controller{

    
    function index()
    {
        $data['page_title'] = "Quiz Event Leaderboard";

        $readMode = $this->loadModel("read");


        if(isset($_GET['action'])){

            if($_GET['action'] == 'get_leaderboard'){

                $event_id = $_SESSION['event_id']; 
                $leaderboard = $readMode->get_leaderboard($event_id);
                
                if (is_array($leaderboard)) {
                    echo json_encode($leaderboard);
                } else {
                    echo json_encode(['error' => $leaderboard]); 
                }
                exit; 
            }
        }
        $this->view("interface-main/realtime_audiance", $data);
    }

}