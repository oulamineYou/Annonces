<?php
//On définit une constence contient le docier racine 
define('ROOT',dirname(__DIR__));

//on importe les namespaces nécessaires
use App_Olm\Autoload;
use App_Olm\Core\Main;

//on import l'autoload
require_once ROOT."/Autoload.php";
Autoload::register();

//on instancier le Main
$app = new Main;

//on démarre l'application
$app->start();
