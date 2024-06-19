<?php

class Quizbee_module{

    function createQuizBeeEvent($POST) {

        $DB = new Database();
        $_SESSION['error'] = "";

        // validate create quiz event module 
        if(isset($POST['quizTitle'])){

            $arr['event_title'] = $POST['quizTitle'];
            $arr['quizmaster_code'] = $POST['quizMasterCode'];
            $arr['participant_code'] = $POST['participantCode'];
            $arr['audience_code'] = $POST['audienceCode'];
            $arr['dateCreated'] = date("Y-m-d H:i:s");
            $arr['user_id'] = $_SESSION['user_id'];
            $arr['url_address'] = get_random_string_max(60);

            $query = "INSERT INTO quiz_event (event_title, quizmaster_code, participant_code, audience_code, date, status, userID, url_address) 
                      VALUES (:event_title, :quizmaster_code, :participant_code, :audience_code, :dateCreated, 0, :user_id, :url_address)";

            $data = $DB->write($query, $arr);
    
            if($data){

                // get event details
                //$_SESSION['event_title'] = $data[0]->event_title;
                //$_SESSION['quizmaster_code'] = $data[0]->quizmaster_code;
                //$_SESSION['participant_code'] = $data[0]->participant_code;
                //$_SESSION['audience_code'] = $data[0]->audience_code;
                
                 //header("Location:". ROOT . "create_question"); 
                 
                 // Fetch the inserted event details
                $query = "SELECT id, event_title, quizmaster_code, participant_code, audience_code 
                          FROM quiz_event 
                          WHERE url_address = :url_address 
                          LIMIT 1";
                          
                $eventDetails = $DB->read($query, ['url_address' => $arr['url_address']]);

                if (is_array($eventDetails) && count($eventDetails) > 0) {
                    // Store event details in session
                    $_SESSION['event_id'] = $eventDetails[0]->id;
                    $_SESSION['event_title'] = $eventDetails[0]->event_title;
                    $_SESSION['quizmaster_code'] = $eventDetails[0]->quizmaster_code;
                    $_SESSION['participant_code'] = $eventDetails[0]->participant_code;
                    $_SESSION['audience_code'] = $eventDetails[0]->audience_code;

                    $event_id = $eventDetails[0]->id;
                    
                }else{
                    $_SESSION['error'] = "Failed to retrieve event details.";
                    $event_id = null;
                }
            } else {
                $_SESSION['error'] = "Please fill in the blank";
            }
        }
    }

    // method show the list of quiz event
    function viewQuizBeeEvent() {

        if (!isset($_SESSION['user_id'])) {
            return false;
        }
    
        $user_id = $_SESSION['user_id'];
    
        $query = "SELECT * FROM Quiz_Event WHERE userID = :user_id ORDER BY id DESC LIMIT 12";
    
        $DB = new Database();
        
        $params = [':user_id' => $user_id];
        
        // read data from the database
        $data = $DB->read($query, $params);
    
        if (is_array($data)) {
            return $data;
        }
        
        return false;
    }

    
     /*

    public function get_status_text($status) {
        switch ($status) {
            case 0:
                return "On Hold";
            case 1:
                return "Ongoing";
            case 2:
                return "Ended";
            default:
                return "Unknown";
        }
    }

   
    function getDetailsQuizEvent($POST){

        $DB = new Database();

        $arr['evemt'] = $POST['username'];
        $arr['password'] = $POST['password'];

        $query = "SELECT * FROM Quiz_Event where username = :username && password = :password LIMIT 1";
        $data = $DB->read($query, $arr);

        if(is_array($data) && count($data) > 0){    

            //logged in
            $_SESSION['user_name'] = $data[0]->username;
            $_SESSION['user_url'] = $data[0]->url_address;
            $_SESSION['user_id'] = $data[0]->id;

            header("Location:". ROOT . "controller_main");
            die;
        }
    }
        */


}

