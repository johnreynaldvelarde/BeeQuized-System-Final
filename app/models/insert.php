<?php

class Insert {

    public function set_team($POST) {
        $DB = new Database();
        $_SESSION['error'] = "";

        if (isset($POST["teamName"]) && !empty($POST["teamName"]) && isset($_SESSION['event_id'])) {
          
            $arr['team_name'] = $POST['teamName'];
            $arr['event_id'] = $_SESSION['event_id']; 


            // Check if team name already exists for the event
            $checkQuery = "SELECT * FROM Team WHERE team_name = :team_name AND event_id = :event_id";
            $checkResult = $DB->read($checkQuery, $arr);

            if (!empty($checkResult)) {
                // Team name already exists
                $_SESSION['error'] = "Team name already exists. Please choose another name.";
                echo json_encode(["success" => false, "error" => $_SESSION['error']]);
                //echo json_encode(["success" => false, "error" => "Team name already exists. Please choose another name."]);
                return;
            }

            // Insert the team
            $query = "INSERT INTO Team (team_name, event_id) VALUES (:team_name, :event_id)";
            $result = $DB->write($query, $arr);

            if ($result) {

                $team_id = $DB->lastInsertId();

                $_SESSION['team_id'] = $team_id;

                if (isset($POST['members']) && is_array($POST['members'])) {
                    foreach ($POST['members'] as $member) {
                        $memberArr = [
                            'team_id' => $team_id,
                            'team_member' => $member
                        ];
                        $memberQuery = "INSERT INTO Team_Members (team_id, team_member) VALUES (:team_id, :team_member)";
                        $DB->write($memberQuery, $memberArr);
                    }
                }

                echo json_encode(["success" => true]);
                return;
            } else {
                echo json_encode(["success" => false, "error" => "Team creation failed. Try again."]);
                return;
            }
        } else {
            echo json_encode(["success" => false, "error" => "Team name is required or event session expired."]);
            return;
        }
    }

    /*
    public function set_quizmaster($POST){

        $DB = new Database();
        $_SESSION['error'] = "";

        if (isset($POST["quizmasterName"]) && !empty($POST["quizmasterName"]) && isset($_SESSION['event_id'])){

            $arr['quizmaster_name'] = $POST['quizmasterName'];
            $arr['event_id'] = $_SESSION['event_id'];
            $arr['url_address'] = get_random_string_max(60);


            $query = "INSERT INTO Quiz_Master (event_id, quizmaster_name, url_address) 
                      VALUES (:event_id, :quizmaster_name, :url_address)";

            $result = $DB->write($query, $arr);

            if ($result) {

                echo json_encode(["success" => true]);
                return;
            } else {
                echo json_encode(["success" => false, "error" => "Quizmaster creation failed. Try again."]);
                return;
            }
        }
        else {
            echo json_encode(["success" => false, "error" => "Quizmaster name is required or event session expired."]);
            return;
        }
    }
    */

    /*
    public function set_quizmaster($POST){

        $DB = new Database();
        $_SESSION['error'] = "";
    
        if (isset($POST["quizmasterName"]) && !empty($POST["quizmasterName"]) && isset($_SESSION['event_id'])){
    
            // Check if a quizmaster is already assigned to the event
            $query_check = "SELECT id FROM Quiz_Master WHERE event_id = :event_id LIMIT 1";
            $params_check = [':event_id' => $_SESSION['event_id']];
            $existing_quizmaster = $DB->read($query_check, $params_check);
    
            if ($existing_quizmaster) {
                // Quizmaster already assigned
                echo json_encode(["success" => false, "error" => "Quizmaster is already assigned to this event."]);
                return;
            }
    
            // Proceed to insert new quizmaster
            $arr['quizmaster_name'] = $POST['quizmasterName'];
            $arr['event_id'] = $_SESSION['event_id'];
            $arr['url_address'] = get_random_string_max(60);
    
            $query_insert = "INSERT INTO Quiz_Master (event_id, quizmaster_name, url_address) 
                             VALUES (:event_id, :quizmaster_name, :url_address)";
    
            $result = $DB->write($query_insert, $arr);
    
            if ($result) {
                echo json_encode(["success" => true]);
                return;
            } else {
                echo json_encode(["success" => false, "error" => "Quizmaster creation failed. Try again."]);
                return;
            }
        } else {
            echo json_encode(["success" => false, "error" => "Quizmaster name is required or event session expired."]);
            return;
        }
    }
    */

    public function set_quizmaster($POST) {
        $DB = new Database();
        $_SESSION['error'] = "";
    
        // Check if required POST data and event_id session are set
        if (isset($POST["quizmasterName"]) && !empty($POST["quizmasterName"]) && isset($_SESSION['event_id'])) {
    
            // Check current status of the Quiz Event
            $query_check_event = "SELECT status FROM Quiz_Event WHERE id = :event_id";
            $params_check_event = [':event_id' => $_SESSION['event_id']];
            $event_status = $DB->read($query_check_event, $params_check_event);
    
            if (!$event_status) {
                // Event not found or database error
                $_SESSION['error'] = "Quiz Event not found or database error.";
                echo json_encode(["success" => false, "error" => $_SESSION['error']]);
                return;
            }
    
            // Check if the event status allows setting a quizmaster
            $allowed_statuses = [0, 1]; // Add more statuses as needed
            if (!in_array($event_status[0]->status, $allowed_statuses)) {
                // Event status does not allow setting a quizmaster
                if ($event_status[0]->status == 0) {
                    $_SESSION['error'] = "Cannot set quizmaster. Quiz Event is in preparation.";
                } else if ($event_status[0]->status == 3) {
                    $_SESSION['error'] = "Cannot set quizmaster. Quiz Event is finished.";
                } else {
                    $_SESSION['error'] = "Cannot set quizmaster. Event status does not allow this action.";
                }
                echo json_encode(["success" => false, "error" => $_SESSION['error']]);
                return;
            }
    
            // Check if a quizmaster is already assigned to the event
            $query_check = "SELECT id FROM Quiz_Master WHERE event_id = :event_id LIMIT 1";
            $existing_quizmaster = $DB->read($query_check, $params_check_event);
    
            if ($existing_quizmaster) {
                // Quizmaster already assigned
                echo json_encode(["success" => false, "error" => "Quizmaster is already assigned to this event."]);
                return;
            }
    
            // Proceed to insert new quizmaster
            $arr['quizmaster_name'] = $POST['quizmasterName'];
            $arr['event_id'] = $_SESSION['event_id'];
            $arr['url_address'] = get_random_string_max(60);
    
            $query_insert = "INSERT INTO Quiz_Master (event_id, quizmaster_name, url_address) 
                             VALUES (:event_id, :quizmaster_name, :url_address)";
    
            $result = $DB->write($query_insert, $arr);
    
            if ($result) {
                echo json_encode(["success" => true]);
                return;
            } else {
                echo json_encode(["success" => false, "error" => "Quizmaster creation failed. Try again."]);
                return;
            }
        } else {
            echo json_encode(["success" => false, "error" => "Quizmaster name is required or event session expired."]);
            return;
        }
    }
    
    

    public function set_category($POST) {
        $DB = new Database();
        $_SESSION['error'] = "";
    
        if (isset($POST["categoryName"]) && isset($POST["basePoints"]) && !empty($POST["categoryName"]) && !empty($POST["basePoints"])) {
            $arr['category_name'] = $POST['categoryName'];
            $arr['base_points'] = $POST['basePoints'];
            $arr['event_id'] = $_SESSION['event_id'];
            $arr['dateCreated'] = date("Y-m-d H:i:s");
    
            $query = "INSERT INTO category (event_id, category_name, base_points, date_added, archive) 
                      VALUES (:event_id, :category_name, :base_points, :dateCreated, 0)";
    
            $data = $DB->write($query, $arr);
    
            if ($data) {
                return ["success" => true];
            } else {
                return ["success" => false, "error" => "Try Again"];
            }
        } else {
            return ["success" => false, "error" => "Category Name and Base Points are required."];
        }
    }

    
    public function set_team_score($POST) {
        $DB = new Database();
        $_SESSION['error'] = "";
    
        if (isset($POST["questionID"]) && isset($POST["score"])) {
            $team_id = $_SESSION['team_id']; // Fetch team_id from session
            $question_id = $POST['questionID'];
            $score = isset($POST['score']) ? $POST['score'] : 0; // Default score to 0 if not provided
    
            // Insert team score into Team_Score table
            $scoreArr = [
                'team_id' => $team_id,
                'question_id' => $question_id,
                'score' => $score
            ];

            $scoreQuery = "INSERT INTO Team_Score (team_id, question_id, score) VALUES (:team_id, :question_id, :score)";
            $scoreResult = $DB->write($scoreQuery, $scoreArr);
    
            if (!$scoreResult) {
                return ["success" => false, "error" => "Failed to insert team score. Please try again."];
            }
    
            // Update question status to 2 (answered)
            $updateArr = [
                'question_id' => $question_id,
                'status' => 2
            ];
            $updateQuery = "UPDATE Questions SET status = :status WHERE id = :question_id";
            $updateResult = $DB->write($updateQuery, $updateArr);
    
            if ($updateResult) {
                return ["success" => true];
            } else {
                return ["success" => false, "error" => "Failed to update question status. Please try again."];
            }
    
        } else {
            return ["success" => false, "error" => "Required parameters are missing."];
        }
    }

    public function register($POST) {
        $DB = new Database();
    
        if (isset($POST['username']) && isset($POST['email']) && isset($POST['password'])) {
            $username = $POST['username'];
            $email = $POST['email'];
            $password = $POST['password'];
    
            // Check if username or email already exists
            $queryCheck = "SELECT * FROM User_Account WHERE username = :username OR email = :email LIMIT 1";
            $paramsCheck = array(
                ':username' => $username,
                ':email' => $email
            );
    
            $existingUser = $DB->read($queryCheck, $paramsCheck);
    
            if ($existingUser) {
                // Username or email already taken
                return ['success' => false, 'error' => 'Username or email is already taken.'];
            }
    
            // Hash the password for storage
            $hashed_password = md5($password); // Consider using stronger hashing methods
    
            $query = "INSERT INTO User_Account (username, email, password, url_address, date) VALUES (:username, :email, :password, :url_address, :date)";
            $params = array(
                ':username' => $username,
                ':email' => $email,
                ':password' => $hashed_password,
                ':url_address' => get_random_string_max(60), // Generate a random URL address
                ':date' => date("Y-m-d H:i:s")
            );
    
            $result = $DB->write($query, $params);
    
            if ($result) {
                // User successfully registered
                return ['success' => true, 'redirectUrl' => ROOT . 'intro'];
            } else {
                // Error during registration
                return ['success' => false, 'error' => 'Registration failed, please try again.'];
            }
        } else {
            // Missing required fields
            return ['success' => false, 'error' => 'Please provide all required fields.'];
        }
    }
    
}
?>
