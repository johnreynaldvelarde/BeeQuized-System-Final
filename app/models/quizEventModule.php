<?php

class QuizEventModule {

    function createEvent($POST) {

        $DB = new Database();
        $_SESSION['error'] = "";

        // validate create quiz event module 
        if(isset($POST['quizTitle'])){

            $arr['event_title'] = $POST['quizTitle'];
            $arr['quizmaster_code'] = $POST['quizMasterCode'];
            $arr['participant_code'] = $POST['participantCode'];
            $arr['audience_code'] = $POST['audienceCode'];
            $arr['dateCreated'] = date("Y-m-d H:i:s");

            $query = "INSERT INTO quiz_event (event_title, quizmaster_code, participant_code, audience_code, date, status) 
                      VALUES (:event_title, :quizmaster_code, :participant_code, :audience_code, :dateCreated, 0)";

            $data = $DB->write($query, $arr);
    
            if($data){
                 header("Location:". ROOT . "create_question");
                 die;
            } else {
                $_SESSION['error'] = "Please fill in the blank";
            }
        }
    }
}




        /*
        // Instantiate the Database class
        $DB = new Database();
        $response = array(); // Initialize an array to hold the response data

        // Check if the required fields are submitted
        if (isset($POST['quizTitle'])) {
            // Generate codes for quizmaster, participant, and audience
            $quizMasterCode = 'QM' . substr(md5(uniqid(mt_rand(), true)), 0, 8);
            $participantCode = 'PC' . substr(md5(uniqid(mt_rand(), true)), 0, 8);
            $audienceCode = 'AC' . substr(md5(uniqid(mt_rand(), true)), 0, 8);

            // Prepare the query to insert the new quiz event into the database
            $query = "INSERT INTO quiz_event (event_title, quizmaster_code, participant_code, audience_code, date, status) 
                      VALUES (:event_title, :quizmaster_code, :participant_code, :audience_code, NOW(), 0)";

            // Bind the parameters and execute the query
            $data = $DB->write($query, array(
                ':event_title' => $POST['quizTitle'],
                ':quizmaster_code' => $quizMasterCode,
                ':participant_code' => $participantCode,
                ':audience_code' => $audienceCode
            ));

            // Check if the insertion was successful
            if ($data) {
                // Set success message
                $response['status'] = 'success';
                $response['message'] = 'Quiz event created successfully!';
                $response['quizMasterCode'] = $quizMasterCode;
                $response['participantCode'] = $participantCode;
                $response['audienceCode'] = $audienceCode;
            } else {
                // Set error message
                $response['status'] = 'error';
                $response['message'] = 'Failed to create quiz event. Please try again.';
            }
        } else {
            // Set error message
            $response['status'] = 'error';
            $response['message'] = 'Event title is required.';
        }

        // Return the response data as JSON
        echo json_encode($response);
    }
    */

