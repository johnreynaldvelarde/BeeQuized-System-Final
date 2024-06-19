<?php

class Delete{

    function delete_category($category_id){

        


    }

    public function delete_questions($question_id) {
        
        $DB = new Database();

        // Update the `archive` field to 1 for the specified question
        $query = "UPDATE Questions SET archive = 1 WHERE id = :question_id";
        $params = [':question_id' => $question_id];

        $result = $DB->write($query, $params);

        if ($result) {
            return "Question archived successfully.";
        } else {
            return "Error archiving question.";
        }
    }

    
}