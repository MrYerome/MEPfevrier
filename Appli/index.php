<?php
session_start();
//var_dump($_SESSION);
include "Dispatcher.php";
$dispatcher = new Dispatcher();
$dispatcher->dispatch();
?>