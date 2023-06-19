<?php
if(!isset($_SESSION)) {
    session_start();
}

require_once(__DIR__ ."/../dbconfig.php");

class Controller{

    public function model($model){
        require_once "../app/models/" . $model . ".php";
        return new $model();
    }

    public function view($view, $data=[]){
        require_once ("../app/views/" . $view . ".php");
    }

}
