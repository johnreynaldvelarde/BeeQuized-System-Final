<?php


class Realtime_participants extends Controller{

    function index(){

        $data['page_title'] = "Team Questions";

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

        if (isset($_SESSION['team_id'])) {
            $data['team_id'] = $_SESSION['team_id']; 
        } else {
            $_SESSION['error'] = "No team ID provided.";
            header("Location: " . ROOT . "error_page"); 
            exit;
        }

        if(isset($_GET['action']) && $_GET['action'] == 'get_category_and_questions') {
            $event_id = $_SESSION['event_id'];

            // Call method to retrieve category and questions
            $result = $readMode->get_category_and_questions($event_id);

            // Prepare JSON response based on result
            if ($result && isset($result['questions']) && !empty($result['questions'])) {
                echo json_encode(['success' => true, 'questions' => $result['questions']]);
            } else {
                echo json_encode([
                    'success' => false, 
                    'message' => 'No questions found',
                    'debug' => isset($result['debug']) ? $result['debug'] : 'Unknown error'
                ]);
            }
            exit;
        }

        // inserting purposes
        if (isset($_POST['action']) && $_POST['action'] == 'set_team_score') {
            $result = $insertMode->set_team_score($_POST);
            echo json_encode($result); // Ensure this line sends JSON
            exit;
        }

        $this->view("interface-main/realtime_participants", $data);
    }
}