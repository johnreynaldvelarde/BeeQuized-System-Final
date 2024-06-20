<?php

class Update {

    function update_quiz_event($POST){

        $DB = new Database();
        $_SESSION['error'] = "";

        if (!isset($_SESSION['event_id'])) {
            echo json_encode(["success" => false, "error" => "Event ID not set"]);
            return;
        }

        $arr['event_id'] = $_SESSION['event_id'];
        $arr['status'] = 1;  

        $query = "UPDATE Quiz_Event SET status = :status WHERE id = :event_id";

        $data = $DB->write($query, $arr);

        if($data){

            echo json_encode(["success" => true]);
            return;

        }else {

            echo json_encode(["success" => false, "error" => "Try Again"]);
            return;
            //$_SESSION['error'] = "Try Again";
        }
    }

    public function update_questions($question_id){
        $DB = new Database();
    
        // Update query
        $query = "UPDATE Questions SET status = 1 WHERE id = :question_id";
        $params = [':question_id' => $question_id];
    
        // Execute the update query
        $result = $DB->write($query, $params);
    
        return $result; 
    }

    public function update_realtime_questions($question_id){
        $DB = new Database();
    
        // Update query
        $query = "UPDATE Questions SET status = 2 WHERE id = :question_id";
        $params = [':question_id' => $question_id];
    
        // Execute the update query
        $result = $DB->write($query, $params);
    
        return $result; 
    }

    public function update_quizevent($event_id){
        $DB = new Database();
    
        // Update query
        $query = "UPDATE Quiz_Event SET status = 3 WHERE id = :event_id";
        $params = [':event_id' => $event_id];
    
        // Execute the update query
        $result = $DB->write($query, $params);

        // Unset the event_id from session
        unset($_SESSION['event_id']);
    
        return $result; 
    }
    

}