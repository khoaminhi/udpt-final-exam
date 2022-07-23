<?php
class PlayerController{
    private $cssRefPath = "./../";


    public function getAllPlayerClub(){
        $page = urldecode(empty($_GET["page"]) == true ? 1 : $_GET["page"]);
        $limit = urldecode(empty($_GET["limit"]) == true ? 10 : $_GET["limit"]);
        
        $page = urldecode($_GET["page"] < 1 ? 1 : $_GET["page"]);
        $limit = urldecode($_GET["limit"] < 1 ? 10 : $_GET["limit"]);

        $result = PlayerModel::getAllPlayerClub($page, $limit);
        $listAllPlayer = $result->listAllPlayer;
        $paginButton = $result->paginButton;

        $cssRefPath = $this->cssRefPath;
        
        $CONTENT_PATH = "test/getListPlayerClub.phtml";
        require_once("./../template/template.phtml");
    }
} 