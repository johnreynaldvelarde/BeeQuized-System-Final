<?php

class Quiz_event{

    function change_event(){

        $DB = new Database();
        $_SESSION['error'] = "";

        $arr['event_id'] = $_SESSION['event_id'];

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

}