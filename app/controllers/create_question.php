<?php

class Create_question extends Controller{

    function index()
    {
        
        $data['page_title'] = "Create a question";

        $detailCategory = $this->loadModel("category");
        $detailQuestion = $this->loadModel("questions");
        $detailEvent = $this->loadModel("update");

        if(isset($_POST['action'])){
            
            // add category
            if($_POST['action'] == 'add_category'){
                $detailCategory->add_category($_POST);
                exit;
            }

            // add question
            if($_POST['action'] == 'add_question'){
                $detailQuestion->add_question($_POST, $_FILES);
                exit; 
            }

            // change quiz event status to 1
            if($_POST['action'] == 'update_quiz_event'){
                $detailEvent->update_quiz_event($_POST);
                exit; 
            }
        }

        if(isset($_GET['action'])){
            
            // get list of categories
            if($_GET['action'] == 'view_all_category'){
                $result = $detailCategory->view_all_category();
                echo json_encode($result);
                exit; 
            }
            
            // get questions
            if($_GET['action'] == 'view_all_question' && isset($_GET['category_id'])){

                error_log('Fetching questions for category ID: ' . $_GET['category_id']);

                $resultQuestion = $detailQuestion->view_all_question($_GET['category_id']);
                echo json_encode($resultQuestion);
                exit; 
            }
                
        }    

        $result = $detailCategory->view_all_category();
        $data["category"] = $result;

        $resultQuestion = $detailQuestion->view_all_question();
        $data["questions"] = $resultQuestion;

        $this->view("interface-main/interface_add_question", $data);
    }
}
