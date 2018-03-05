<?php
include "Controller/HomeController.php";
include "Controller/AdminController.php";
class Dispatcher
{
    public function __construct(){
    }
    public function dispatch() {
        $controller = (isset($_GET['Controller'])) ? $_GET['Controller'] : "Home";
        $controller .= "Controller";
        $action = (isset($_GET['action'])) ? $_GET['action'] : "home";
        $action .= "Action";
        $call_controller = new $controller();
        $call_controller->$action();
    }
}