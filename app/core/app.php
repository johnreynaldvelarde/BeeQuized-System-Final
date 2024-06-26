<?php

Class App
{
    private $controller = "get_code";
    private $method = "index";
    private $params = [];

    public function __construct(){

        //print_r($_GET);
        $url = $this->split_URL();
        
        if(file_exists("../app/controllers/". strtoLower($url[0]) .".php" )){

            $this->controller = strtoLower($url[0]);
            unset($url[0]);
        }

        require "../app/controllers/". $this->controller .".php";
        $this->controller = new $this->controller;

        if(isset($url[1])){
            if(method_exists($this->controller, $url[1])){
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        // run the class and method
        $this->params = array_values($url);
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    private function split_URL(){
       $url = isset($_GET['url']) ? $_GET['url'] : "get_code";
       return explode("/", filter_var(trim($url , "/"),FILTER_SANITIZE_URL));
    }
}
