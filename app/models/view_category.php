<?php

class View_category{


    function view_all_category(){

        if (!isset($_SESSION['event_id'])) {
            return false;
        }
    
        $event_id = $_SESSION['event_id'];
    
        $query = "SELECT * FROM Category WHERE event_id = :event_id ORDER BY id DESC LIMIT 12";
    
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