<?php

class Questions{

    // add question
    function add_question($POST, $FILES){

        $DB = new Database();
        $_SESSION['error'] = "";

        $allowed = ["image/jpeg", "image/png"];

        if(isset($_POST["timer"]) && !empty($_POST["timer"]) &&isset($FILES['file'])) {

            // upload file
            if($FILES['file']['name'] != "" && $FILES['file']['error'] == 0 && in_array($FILES['file']['type'], $allowed)){

                
                $folder = "uploads/";
                if(!file_exists($folder)){

                    mkdir($folder,0777, true);
                }

                $destination = $folder . $FILES['file']['name'];
                if (!move_uploaded_file($FILES['file']['tmp_name'], $destination)) {
                    $_SESSION['error'] = "The question image is not uploaded";
                    echo json_encode(["success" => false, "error" => $_SESSION['error']]);
                    return;
                }
                //move_uploaded_file($FILES['file']['tmp_name'], $destination);
            }
            else {
                $_SESSION['error'] = "Invalid file type or error during upload";
                echo json_encode(["success" => false, "error" => $_SESSION['error']]);
                return;
            }

            // Fetch data from POST array
            $arr['category_id'] = $POST['selectedCategoryId'];
            $arr['timer'] = formatTime($POST['timer']);
            $arr["image_question"] = $destination;

            switch($_POST['questionType']){

                case 'multipleChoice':
                    // Fetch additional data for multiple choice questions
                    $arr['question_type'] = 'Multiple Choice';
                    $arr['correct_answer'] = $_POST['correctAnswer'];
                    $arr['choice_1'] = $_POST['choice1'];
                    $arr['choice_2'] = $_POST['choice2'];
                    $arr['choice_3'] = $_POST['choice3'];
                    $arr['choice_4'] = $_POST['choice4'];
                    break;
                case 'essay':
                    //$arr['question_type'] = 'Essay';
                    break;
                case 'trueFalse':
                        //$arr['question_type'] = 'trueFalse';
                    break;
                default:
                        echo json_encode(["success" => false, "error" => "Unsupported question type"]);
                    return;   
            }

            $query = "INSERT INTO questions (category_id, question_type, question_image, correct_answer, choice_1, choice_2, choice_3, choice_4, timer, status, archive) 
                      VALUES (:category_id, :question_type, :image_question, :correct_answer, :choice_1, :choice_2, :choice_3, :choice_4, :timer, 0, 0)";
        
            // Execute the query
            $data = $DB->write($query, $arr);
        
            // Check if the query was successful
            if($data) {
                echo json_encode(["success" => true]);
                return;
            } else {
                echo json_encode(["success" => false, "error" => "Try Again"]);
                return;
            }
        } else {
            echo json_encode(["success" => false, "error" => "Try Again! Image not upload"]);
            return;
        }
    }

    function view_all_question($category_id = null) {
        $query = "SELECT * FROM Questions";
        $params = [];
        
        if ($category_id) {
            $query .= " WHERE category_id = :category_id";
            $params[':category_id'] = $category_id;
        }
        
        $query .= " ORDER BY id DESC LIMIT 20";
    
        $DB = new Database();
        $data = $DB->read($query, $params);
    
        if (is_array($data)) {
            return $data;
        }
        return false;
    }


    /*
    function check_question_if_created($event_id){

        $DB = new Database();

        $query = "SELECT c.category_name, q.id AS question_id, q.question_type
              FROM Category c
              LEFT JOIN Question q ON c.id = q.category_id
              WHERE c.event_id = :event_id";


        $params = array(':event_id' => $event_id);

        $data = $DB->read($query, $params);
    
        if (is_array($data)) {
            return $data;
        }
        return false;


        
    }
        */

    
    

    /*
    function view_all_question($category_id){

        /*
        if (!isset($_SESSION['category_id'])) {
            return false;
        }
    
        $category_id = $_SESSION['category_id'];
        
        
        $query = "SELECT * FROM Questions WHERE category_id = :category_id ORDER BY id DESC LIMIT 20";
    
        $DB = new Database();
        
        $params = [':category_id' => $category_id];
        
        // read data from the database
        $data = $DB->read($query, $params);
    
        if (is_array($data)) {
            return $data;
        }
        return false;
    }
        */
}