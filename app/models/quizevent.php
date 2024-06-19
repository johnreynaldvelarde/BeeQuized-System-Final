<?php

Class Quizevent{

    function check_quiz_code($POST) {
        $DB = new Database();
        $_SESSION['error'] = "";
    
        if(isset($POST['getcode'])) {
            $arr['getcode'] = $POST['getcode'];
    
            $query = "SELECT * FROM Quiz_Event WHERE (quizmaster_code = :getcode OR participant_code = :getcode OR audience_code = :getcode) AND status = 0";
            $data = $DB->read($query, $arr);
    
            if (is_array($data) && count($data) > 0) {
                // Code exists and status is ongoing (0)
                // Check which column the code was found in
                $found_in_column = '';
                foreach($data[0] as $key => $value) {
                    if ($value === $POST['getcode']) {
                        $found_in_column = $key;
                        break;
                    }
                }
    
                // Redirect based on the column where the code was found
                if ($found_in_column === 'quizmaster_code') {
                    header("Location: " . ROOT . "quizmaster");
                    exit;
                } elseif ($found_in_column === 'participant_code') {
                    // Get the eventID and pass it to create_team route
                    $eventID = $data[0]->id; // Assuming 'id' is the eventID column name
                    header("Location: " . ROOT . "create_team?eventID=" . $eventID);
                    exit;
                } else {
                    header("Location: " . ROOT . "view_audience");
                    exit;
                }
    
            } else {
                // Code doesn't exist or status is not ongoing
                $_SESSION['error'] = "Code not found or quiz has already finished.";
            }
        } else {
            $_SESSION['error'] = "No quiz code provided.";
        } 
    }
}
