<?php

/*
Class Set_team{

    function createTeam($POST){

        $DB = new Database();
        $_SESSION['error'] = "";
    
        if(isset($_POST['teamName'], $_POST['eventID'], $_POST['members'])){

            // Check if team name already exists
            $teamName = $_POST['teamName'];
            $eventID = $_POST['eventID'];
            $checkTeamQuery = "SELECT id FROM Team WHERE teamname = :teamname AND eventID = :eventID";
            $checkTeamData = array(
                ':teamname' => $teamName,
                ':eventID' => $eventID
            );
            $existingTeam = $DB->read($checkTeamQuery, $checkTeamData);
            
            if($existingTeam) {
                $_SESSION['error'] = "Team name already exists for this event.";
                return false;
            }

            // Insert into Team table
            $insertTeamQuery = "INSERT INTO Team (teamname, eventID) VALUES (:teamname, :eventID)";
            $teamData = array(
                ':teamname' => $teamName,
                ':eventID' => $eventID
            );
            $teamID = $DB->write($insertTeamQuery, $teamData);
            
            if($teamID){

                // Insert into Team_Members table
                $members = $_POST['members'];
                foreach($members as $member){
                    $insertMemberQuery = "INSERT INTO Team_Members (teamID, membername) VALUES (:teamID, :membername)";
                    $memberData = array(
                        ':teamID' => $teamID,
                        ':membername' => $member
                    );
                    $DB->write($insertMemberQuery, $memberData);
                }

                // Team and its members successfully created
                $_SESSION['success'] = "Team created successfully.";
                return true;
            } else {
                // Error in creating team
                $_SESSION['error'] = "Error creating team.";
                return false;
            }
        } else {
            $_SESSION['error'] = "Incomplete data provided.";
            return false;
        }
    }
}
*/

class Set_team {
    
    function createTeam($POST) {
        $DB = new Database();
        $_SESSION['error'] = "";

        if (isset($POST['teamName'], $POST['eventID'])){


            $teamName = $POST['teamName'];
            $eventID = $POST['eventID'];

            // Check if team name already exists for this event
            $checkTeamQuery = "SELECT id FROM Team WHERE teamname = :teamname AND eventID = :eventID";
            $checkTeamData = array(':teamname' => $teamName, ':eventID' => $eventID);
            $existingTeam = $DB->read($checkTeamQuery, $checkTeamData);

            if ($existingTeam) {
                $_SESSION['error'] = "Team name already exists for this event.";
                return false;
            }

            // Insert into Team table
            $insertTeamQuery = "INSERT INTO Team (teamname, eventID) VALUES (:teamname, :eventID)";
            $teamData = array(':teamname' => $teamName, ':eventID' => $eventID);
            $teamID = $DB->write($insertTeamQuery, $teamData);
            
            if ($teamID) {
                $_SESSION['success'] = "Team created successfully.";

                 // Redirect to main_quiz_event
                 header("Location: " . ROOT . "main_quiz_event");
                 exit;
                 
            } else {
                $_SESSION['error'] = "Error creating team.";
                return false;
            }
        }
        else {
            $_SESSION['error'] = "Team name and event ID are required.";
            return false;
        }
    }
}

   /*
        if (isset($POST['teamName'], $POST['eventID'], $POST['selectedNumMembers'])) {
            $teamName = $POST['teamName'];
            $eventID = $POST['eventID'];
            $selectedNumMembers = $POST['selectedNumMembers'];

            // Check if team name already exists
            $checkTeamQuery = "SELECT id FROM Team WHERE teamname = :teamname AND eventID = :eventID";
            $checkTeamData = array(
                ':teamname' => $teamName,
                ':eventID' => $eventID
            );
            $existingTeam = $DB->read($checkTeamQuery, $checkTeamData);

            if ($existingTeam) {
                $_SESSION['error'] = "Team name already exists for this event.";
                return false;
            }

            // Insert into Team table
            $insertTeamQuery = "INSERT INTO Team (teamname, eventID) VALUES (:teamname, :eventID)";
            $teamData = array(
                ':teamname' => $teamName,
                ':eventID' => $eventID
            );
            $teamID = $DB->write($insertTeamQuery, $teamData);

            if ($teamID) {
                // Insert into Team_Members table
                for ($i = 1; $i <= $selectedNumMembers; $i++) {
                    $memberName = $POST['member' . $i];
                    $insertMemberQuery = "INSERT INTO Team_Members (teamID, membername) VALUES (:teamID, :membername)";
                    $memberData = array(
                        ':teamID' => $teamID,
                        ':membername' => $memberName
                    );
                    $DB->write($insertMemberQuery, $memberData);
                }

                // Team and its members successfully created
                $_SESSION['success'] = "Team created successfully.";
                return true;
            } else {
                // Error in creating team
                $_SESSION['error'] = "Error creating team.";
                return false;
            }
        } else {
            $_SESSION['error'] = "Kulang ang data provided.";
            return false;
        }
        */

