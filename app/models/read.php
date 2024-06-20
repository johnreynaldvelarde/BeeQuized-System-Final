<?php

class Read{

    public function check_quiz_event_code($POST) {
        $DB = new Database();
        $_SESSION['error'] = "";

        if (isset($POST['getcode'])) {
            $arr['getcode'] = $POST['getcode'];

            $query = "SELECT * FROM Quiz_Event WHERE (quizmaster_code = :getcode OR participant_code = :getcode OR audience_code = :getcode) AND status = 1";
            $data = $DB->read($query, $arr);

            // code exists and status is ongoing (0)
            if (is_array($data) && count($data) > 0) {
                
                // get event_id
                $event_id = $data[0]->id;
                $event_title = $data[0]->event_title;
                $_SESSION['event_id'] = $event_id;
                $_SESSION['event_title'] = $event_title; // store event_id in session

                // check which column the code was found in
                $found_in_column = '';
                foreach ($data[0] as $key => $value) {
                    if ($value === $POST['getcode']) {
                        $found_in_column = $key;
                        break;
                    }
                }

                // redirect when the code was found
                if ($found_in_column === 'quizmaster_code') {
                    header("Location: " . ROOT . "quiz_master");
                    exit;
                } elseif ($found_in_column === 'participant_code') {
                    header("Location: " . ROOT . "create_team");
                    exit;
                } else {
                    header("Location: " . ROOT . "view_audience");
                    exit;
                }
            } else {
                
                $_SESSION['error'] = "Code not found or BeeQuized event has already finished.";
            }
        } else {
            $_SESSION['error'] = "No quiz code provided.";
        }
    }

    public function check_quiz_event_codes($POST) {
        $DB = new Database();
        $response = ['success' => false, 'error' => ""];
    
        if (isset($POST['getcode']) && !empty($POST['getcode'])) {
            $arr['getcode'] = $POST['getcode'];
    
            $query = "SELECT * FROM Quiz_Event WHERE (quizmaster_code = :getcode OR participant_code = :getcode OR audience_code = :getcode) AND status = 1";
            $data = $DB->read($query, $arr);
    
            if (is_array($data) && count($data) > 0) {
                $event_id = $data[0]->id;
                $event_title = $data[0]->event_title;
                $_SESSION['event_id'] = $event_id;
                $_SESSION['event_title'] = $event_title;
    
                $found_in_column = '';
                foreach ($data[0] as $key => $value) {
                    if ($value === $POST['getcode']) {
                        $found_in_column = $key;
                        break;
                    }
                }
    
                if ($found_in_column === 'quizmaster_code') {
                    $response['success'] = true;
                    $response['redirectUrl'] = ROOT . "quiz_master";
                } elseif ($found_in_column === 'participant_code') {
                    $response['success'] = true;
                    $response['redirectUrl'] = ROOT . "create_team";
                } else {
                    $response['success'] = true;
                    $response['redirectUrl'] = ROOT . "view_audience";
                }
            } else {
                $response['error'] = "Code not found or BeeQuized event has already finished.";
            }
        } else {
            $response['error'] = "No quiz code provided.";
        }
    
        return $response;
    }
    


    public function get_quiz_masters($event_id) {
        $DB = new Database();

        $query = "SELECT * FROM Quiz_Master WHERE event_id = :event_id";
        $params = [':event_id' => $event_id];

        $quiz_masters = $DB->read($query, $params);

        return $quiz_masters;
    }

    public function get_team($event_id) {
        $DB = new Database();

        $query = "SELECT * FROM Team WHERE event_id = :event_id";
        $params = [':event_id' => $event_id];

        $teams = $DB->read($query, $params);

        if (!$teams) {
            return "No team participants yet"; 
        }

        return $teams;
    }

    public function get_teams($event_id) {
        $DB = new Database();
    
        $query = "
            SELECT 
                T.id,
                T.team_name,
                COALESCE(SUM(TS.score), 0) AS total_score
            FROM 
                Team T
            LEFT JOIN 
                Team_Score TS ON T.id = TS.team_id
            WHERE 
                T.event_id = :event_id
            GROUP BY 
                T.id, T.team_name
            ORDER BY 
                total_score DESC
        ";
        $params = [':event_id' => $event_id];
    
        $teams = $DB->read($query, $params);
    
        if (!$teams) {
            return "No team participants yet"; 
        }
    
        return $teams;
    }
    

    public function get_team_members($team_id) {
        $DB = new Database();
    
        $query = "SELECT * FROM TeamMembers WHERE team_id = :team_id";
        $params = [':team_id' => $team_id];
    
        $team_members = $DB->read($query, $params);
    
        echo json_encode($team_members);
        exit;
    }

    // get category in database
    public function get_category($event_id){

        $DB = new Database();


        $query = "SELECT * FROM Category WHERE event_id = :event_id";
        $params = [':event_id' => $event_id];

        $category = $DB->read($query, $params);

        if (!$category) {
            return "No category created yet"; 
        }
        return $category;
    }

    // get question 
    public function get_questions($category_id){
        $DB = new Database();
    
        $query = "SELECT * FROM Questions WHERE category_id = :category_id AND archive = 0 ORDER BY status ASC";
        $params = [':category_id' => $category_id];
    
        $questions = $DB->read($query, $params);
    
        if (!$questions) {
            return "No questions created yet"; 
        }
    
        return $questions;
    }

    public function get_category_and_questions($event_id) {
        $DB = new Database();
    
        $categoryQuery = "SELECT id FROM Category WHERE event_id = ?";
        $categoryParams = [$event_id];
        $categories = $DB->read($categoryQuery, $categoryParams);
    
        if (!$categories) {

            return [
                'debug' => 'No categories found for the event_id'
            ];
        }
    
        $categoryIds = array_column($categories, 'id');
        $placeholders = implode(',', array_fill(0, count($categoryIds), '?'));
    
        $questionQuery = "
            SELECT 
                q.id, q.category_id, q.question_type, q.question_image, 
                q.correct_answer, q.choice_1, q.choice_2, q.choice_3, q.choice_4, q.timer,
                c.base_points
            FROM 
                Questions q
            JOIN
                Category c ON q.category_id = c.id    
            WHERE 
                q.category_id IN ($placeholders) 
                AND q.status = 1";
    
        $questions = $DB->read($questionQuery, $categoryIds);
    
        if (!$questions) {
            return [
                'debug' => 'No questions fetched from the database'
            ];
        }
    
        return [
            'questions' => $questions,
        ];
    }
    
    public function login($POST) {
        $DB = new Database();
        
        if (isset($POST['username']) && isset($POST['password'])) {
            $username = $POST['username'];
            $password = $POST['password'];
    
            $hashed_password = md5($password); 
    
            $query = "SELECT * FROM User_Account WHERE username = :username AND password = :password LIMIT 1";
            $params = array(
                ':username' => $username,
                ':password' => $hashed_password
            );
    
            $data = $DB->read($query, $params);
    
            if ($data) {

                $_SESSION['user_name'] = $data[0]->username;
                $_SESSION['user_url'] = $data[0]->url_address;
                $_SESSION['user_id'] = $data[0]->id;
                // User found
                return ['success' => true, 'redirectUrl' => ROOT . 'controller_main'];
            } else {
                return ['success' => false, 'error' => 'Invalid username or password'];
            }
        } else {
            return ['success' => false, 'error' => 'Please enter username and password'];
        }
    }
    
}
