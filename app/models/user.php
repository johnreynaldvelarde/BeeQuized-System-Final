<?php

Class User{

    // login account
    function login($POST){

        $DB = new Database();
        
        $_SESSION['error'] = "";
        if(isset($POST['username']) && isset($POST['password'])){

            $arr['username'] = $POST['username'];
            $arr['password'] = $POST['password'];
    
            $query = "SELECT * FROM User_Account where username = :username && password = :password LIMIT 1";
            $data = $DB->read($query, $arr);
    
            if(is_array($data) && count($data) > 0){    

                //logged in
                $_SESSION['user_name'] = $data[0]->username;
                $_SESSION['user_url'] = $data[0]->url_address;
                $_SESSION['user_id'] = $data[0]->id;

                header("Location:". ROOT . "controller_main");
				die;
            }
            else{

                $_SESSION['error'] = "Please enter a valid username and password";
            } 
        }
        else{

            $_SESSION['error'] = "Please enter a valid username and password";
        } 
    }

    // register account
    function register($POST){

        $DB = new Database();
        
        $_SESSION['error'] = "";
        
        // validates user input
        if(isset($POST['username']) && isset($POST['password'])){

            $arr['username'] = $POST['username'];
            $arr['email'] = $POST['email'];
            $arr['password'] = $POST['password'];
            $arr['url_address'] = get_random_string_max(60);
            $arr['date'] = date("Y-m-d H:i:S");
    
            $query = "insert into User_Account(username, email, password, url_address, date) values(:username, :email, :password, :url_address, :date)";
            $data = $DB->write($query, $arr);
    
            if($data){

                header("Location:". ROOT . "intro");
                die;
            }
        }
        else{

            $_SESSION['error'] = "Please enter a valid username and password";
        } 

    }

    public function logins($POST) {
        $DB = new Database();
        
        if (isset($POST['username']) && isset($POST['password'])) {
            $username = $POST['username'];
            $password = $POST['password'];

            // Hash the password for comparison
            $hashed_password = md5($password); // This is a basic example, consider stronger hashing methods

            $query = "SELECT * FROM User_Account WHERE username = :username AND password = :password LIMIT 1";
            $params = array(
                ':username' => $username,
                ':password' => $hashed_password
            );

            $data = $DB->read($query, $params);

            if ($data) {
                // User found, set session variables
                $_SESSION['user_name'] = $data[0]->username;
                $_SESSION['user_url'] = $data[0]->url_address;
                $_SESSION['user_id'] = $data[0]->id;

                // Redirect to main controller or any desired location
                header("Location: " . ROOT . "controller_main");
                exit;
            } else {
                $_SESSION['error'] = "Invalid username or password";
            }
        } else {
            $_SESSION['error'] = "Please enter username and password";
        }
    }

    // Register account
    public function registers($POST) {
        $DB = new Database();
        
        if (isset($POST['username']) && isset($POST['email']) && isset($POST['password'])) {
            $username = $POST['username'];
            $email = $POST['email'];
            $password = $POST['password'];

            // Hash the password before storing (using a basic hash here, consider stronger methods)
            $hashed_password = md5($password); // This is a basic example, consider stronger hashing methods

            // Generate a unique URL address for the user
            $url_address = get_random_string_max(60); // Assuming get_random_string_max is defined elsewhere

            // Current timestamp
            $date = date("Y-m-d H:i:s");

            // Prepare parameters for the query
            $params = array(
                ':username' => $username,
                ':email' => $email,
                ':password' => $hashed_password,
                ':url_address' => $url_address,
                ':date' => $date
            );

            // Query to insert user data into database
            $query = "INSERT INTO User_Account (username, email, password, url_address, date) 
                      VALUES (:username, :email, :password, :url_address, :date)";

            $success = $DB->write($query, $params);

            if ($success) {
                // Registration successful, redirect to intro page or any desired location
                header("Location: " . ROOT . "intro");
                exit;
            } else {
                $_SESSION['error'] = "Registration failed";
            }
        } else {
            $_SESSION['error'] = "Please enter all required fields";
        }
    }

    function check_logged_in(){

        $DB = new Database();

        if(isset($_SESSION['user_url'])){

            $arr['user_url'] = $_SESSION['user_url'];
        
            $query = "select * from User_Account where url_address = :user_url limit 1";
            $data = $DB->read($query, $arr);
    
            if(is_array($data)){

                //logged in
                //$_SESSION['user_id'] = $data[0]->User_ID;
                $_SESSION['user_name'] = $data[0]->username;
                $_SESSION['user_url'] = $data[0]->url_address;

                return true;
            }
            return false;
        }
    }

    function logout(){

        unset($_SESSION['user_name']);
        unset($_SESSION['user_url']);

        header("Location:" . ROOT . "get_code");
        die;
    }
}