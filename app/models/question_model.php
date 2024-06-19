<?php

class Question_model{

    function add_category($POST){

        $DB = new Database();
        $_SESSION['error'] = "";

        if(isset($_POST["categoryName"])){


            $arr['category_name'] = $POST['categoryName'];
            $arr['base_points'] = $POST['basePoints'];
            $arr['event_id'] = $_SESSION['event_id'];
            $arr['dateCreated'] = date("Y-m-d H:i:s");


            $query = "INSERT INTO category (event_id, category_name, base_points, date_added, archive) 
                      VALUES (:event_id, :category_name, :base_points, :dateCreated, 0)";

            $data = $DB->write($query, $arr);

            if($data){

                
            }else {
                $_SESSION['error'] = "Try Again";
            }
        }
    }


    function view_all_category(){

        if (!isset($_SESSION['event_id'])) {
            return false;
        }
    
        $event_id = $_SESSION['event_id'];
    
        //$query = "SELECT * FROM Category WHERE event_id = :event_id ORDER BY id DESC LIMIT 12";
        $query = "SELECT id AS category_id, category_name, base_points FROM Category WHERE event_id = :event_id ORDER BY id DESC LIMIT 12";
    
        $DB = new Database();
        
        $params = [':event_id' => $event_id];
        
        // read data from the database
        $data = $DB->read($query, $params);
    
        if (is_array($data)) {
            return $data;
        }
        return false;
    }
}