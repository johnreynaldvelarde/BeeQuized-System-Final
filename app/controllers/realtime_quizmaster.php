<?php

class Realtime_quizmaster extends Controller{


    function index()
    {
        $data['page_title'] = "Quiz Master";

        $readMode = $this->loadModel("read");
        $insertMode = $this->loadModel("insert");
        $updateMode = $this->loadModel("update");
        
        if (isset($_SESSION['event_id'])) {
            $data['event_id'] = $_SESSION['event_id']; 
        } else {
            $_SESSION['error'] = "No event ID provided.";
            header("Location: " . ROOT . "error_page"); 
            exit;
        }

        if(isset($_GET['action'])){


            // displat teams and score
            if($_GET['action'] == 'get_teams'){

                $event_id = $_SESSION['event_id']; // Assuming event_id is stored in session
                $teams = $readMode->get_teams($event_id);
                
                if (is_array($teams)) {
                    echo json_encode($teams);
                } else {
                    echo json_encode(['error' => $teams]); // Return error message
                }

                exit; 
            }
            

            // get list of categories
            if($_GET['action'] == 'get_category'){

                $event_id = $_SESSION['event_id'];
                $category = $readMode->get_category($event_id);
                
                if (is_array($category)) {
                    echo json_encode($category);
                } else {
                    echo json_encode(['error' => $category]); // Return error message
                }

                exit; 
            }

            // get list of questions
            if($_GET['action'] == 'get_questions' && isset($_GET['category_id'])){

               
                $questions = $readMode->get_questions($_GET['category_id']);
                
                if (is_array($questions)) {
                    echo json_encode($questions);
                } else {
                    echo json_encode(['error' => $questions]); // Return error message
                }
                exit; 
            }

            // Update question status
            if ($_GET['action'] == 'update_question_status' && isset($_GET['question_id'])) {
                $question_id = $_GET['question_id'];
                $result = $updateMode->update_questions($question_id);

                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Question status updated successfully']);
                } else {
                    echo json_encode(['error' => 'Failed to update question status']);
                }
                exit;
            }

             // Update question event
             if ($_GET['action'] == 'update_quizevent') {
                $event_id = $_SESSION['event_id']; 
                $result = $updateMode->update_quizevent($event_id);

                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Quiz Event status updated successfully']);
                    
                } else {
                    echo json_encode(['error' => 'Failed to update quiz event status']);
                }
                exit;
            }
        }

        // inserting purposes
        if (isset($_POST['action']) && $_POST['action'] == 'set_category') {
            $result = $insertMode->set_category($_POST);
            echo json_encode($result); // Ensure this line sends JSON
            exit;
        }

        $this->view("interface-main/realtime_quizmaster_one", $data);
    }
}