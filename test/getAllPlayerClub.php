<?php
require_once "./../config/dbconnect.php";
require_once "./playerController.php";
require_once "./playerModel.php";

$player=new PlayerController();
$action="";
$clubID="";
$keySearch="";
if (isset($_REQUEST["action"]))
{    
    $action = $_REQUEST["action"];
}
if(isset($_GET["keySearch"])){
    $keySearch=$_GET["keySearch"];
}
if (isset($_GET["clubID"])) {
    $clubID = $_GET["clubID"];
}

switch ($action) {
    case "getAllPlayer":
        $player->getAllPlayer();
        break;
    case "getAllPlayerClub":
        $player->getAllPlayerClub();
        break;
    case "getAClubPlayer":
        $player->getAClubPlayer();
        break;
    case "searchPlayer":
        $player->searchPlayer($keySearch);
        break;
    case "searchPlayerAdvanced":
        $player->advancedSearch();
        break;
    default:
        $player->getAllPlayerClub();
        break;
}
?>