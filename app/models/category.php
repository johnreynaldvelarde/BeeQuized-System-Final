<?php
//session_start();

class Category{
    
    function add_category($POST){

        $DB = new Database();
        $_SESSION['error'] = "";

        if(isset($POST["categoryName"]) && isset($POST["basePoints"]) && !empty($POST["categoryName"]) && !empty($POST["basePoints"])){


            $arr['category_name'] = $POST['categoryName'];
            $arr['base_points'] = $POST['basePoints'];
            $arr['event_id'] = $_SESSION['event_id'];
            $arr['dateCreated'] = date("Y-m-d H:i:s");


            $query = "INSERT INTO category (event_id, category_name, base_points, date_added, archive) 
                      VALUES (:event_id, :category_name, :base_points, :dateCreated, 0)";

            $data = $DB->write($query, $arr);

            if($data){

                echo json_encode(["success" => true]);
                return;

            }else {

                echo json_encode(["success" => false, "error" => "Try Again"]);
                return;
                //$_SESSION['error'] = "Try Again";
            }
        }
        else {

            echo json_encode(["success" => false, "error" => "Category Name and Base Points are required."]);
            return;
            //$_SESSION['error'] = "Category Name and Base Points are required.";
        }
    }

    function view_all_category(){

        if (!isset($_SESSION['event_id'])) {
            return false;
        }
    
        $event_id = $_SESSION['event_id'];
    
        $query = "SELECT * FROM Category WHERE event_id = :event_id ORDER BY id ASC LIMIT 12";
    
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
