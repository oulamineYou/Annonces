<?php
namespace App_Olm\Controllers;


class MainController extends Controller
{
    public function index(){
        $this->render("main/index.php");
    }
}
?>