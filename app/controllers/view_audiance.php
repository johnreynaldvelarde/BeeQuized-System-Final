<?php

Class Createteam extends Controller{

    function index()
    {
        $data['page_title'] = "Event Leaderboard";
        $this->view("interface-main/realtime_audiance", $data);
    }
}
