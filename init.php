<?php
include 'admin/connect.php';

$sessionUser = '';
if (isset($_SESSION['user'])){
$sessionUser = $_SESSION['user'];    

}

$tpl = "includes/templates/";
$lang = "includes/languages/";
$css = "layout/css/";
$js = "layout/js/";
$fun = "includes/functions/";

//include important files
include $fun . "function.php";
include $lang . "english.php";
include $tpl . "header.php"; 
 


