<?php

Class Get_code extends Controller{

    function index()
    {
        $data['page_title'] = "Get a event code";

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $response = [];
    
                if (isset($_POST['getcode'])) {
                    $quizEvent = $this->loadModel("read");
                    $result = $quizEvent->check_quiz_event_codes($_POST);
    
                    if ($result['success']) {
                        $response['success'] = true;
                        $response['redirectUrl'] = $result['redirectUrl'];
                    } else {
                        $response['success'] = false;
                        $response['error'] = $result['error'];
                    }
                }

                elseif (isset($_POST['action']) && $_POST['action'] === 'register') {
                    $user = $this->loadModel("insert");
                    $result = $user->register($_POST);
            
                    if ($result['success']) {
                        $response['success'] = true;
                        $response['redirectUrl'] = $result['redirectUrl'];
                    } else {
                        $response['success'] = false;
                        $response['error'] = $result['error'];
                    }
                }
                // Check if 'action' is set for user login
                elseif (isset($_POST['action']) && $_POST['action'] === 'login') {
                    $user = $this->loadModel("read");
                    $result = $user->login($_POST);
            
                    if ($result['success']) {
                        $response['success'] = true;
                        $response['redirectUrl'] = ROOT . 'controller_main'; 
                    } else {
                        $response['success'] = false;
                        $response['error'] = $result['error'];
                    }
                } else {
                    $response['success'] = false;
                    $response['error'] = "Invalid request.";
                }
                
                echo json_encode($response);
                exit;
            }

        //$this->view("quizbee/intro", $data);
        $this->view("interface-view/starting_page", $data);
    }
}