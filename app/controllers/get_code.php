<?php

Class Get_code extends Controller{

    function index()
    {
        $data['page_title'] = "Get a event code";

       // $detailGetCode = $this->loadModel("read");

       /*
       if(isset($_POST['action'])){
            // get code and check
            if (isset($_POST['getcode'])) {

                $quizEvent = $this->loadModel("read");
                $quizEvent->check_quiz_event_codes($_POST);
            }
       }
            */

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
                        $response['redirectUrl'] = ROOT . 'controller_main'; // Adjust redirect URL as needed
                    } else {
                        $response['success'] = false;
                        $response['error'] = $result['error'];
                    }
                } else {
                    $response['success'] = false;
                    $response['error'] = "Invalid request.";
                }
                
                
                /*elseif (isset($_POST['action']) && $_POST['action'] === 'register') {
                    $user = $this->loadModel("insert");
                    $result = $user->register($_POST);
    
                    $response = $result;
                } else {
                    $response['success'] = false;
                    $response['error'] = "Invalid request.";
                }
                    */
    
                echo json_encode($response);
                exit;
            }

            /*
        // Handle user registration or login
        if (isset($_POST['email'])) {
            $user = $this->loadModel("user");
            $user->register($_POST);
        } elseif (isset($_POST['username']) && !isset($_POST['email'])) {
            $user = $this->loadModel("user");
            $user->logins($_POST);
        }
        

        // Handle user registration if email, username, and password are provided
        if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])) {
            $user = $this->loadModel("insert");
            $result = $user->register($_POST);

            // Return JSON response based on registration result
            if ($result['success']) {
                $response['success'] = true;
                $response['message'] = $result['message']; // Registration success message
            } else {
                $response['success'] = false;
                $response['error'] = $result['error']; // Registration error message
            }

            // Output JSON response and exit for registration
            echo json_encode($response);
            exit;
        }
            

        if(isset($_POST['action'])){
            
            // add team and members
            if($_POST['action'] == 'register'){
                $data->register($_POST);
                exit;
            }

        }    
            */


        //$this->view("quizbee/intro", $data);
        $this->view("interface-view/starting_page", $data);
    }
}