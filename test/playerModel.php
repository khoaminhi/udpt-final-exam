<?php
require_once "./../service/paginator.php";
class PlayerModel{
    public $PlayerID;
    public $FullName;
    public $ClubID;
    public $DOB;
    public $Position;
    public $Nationality;
    public $Number;

    function __constructor(){
        $this->PlayerID="";
        $this->FullName="";
        $this->ClubID="";
        $this->DOB="";
        $this->Position="";
        $this->Nationality="";
        $this->Number="";
    }

    public static function getAllPlayerClub($page=1, $limit=10){
        dbconnect::connect();
        $query = "SELECT PlayerID, FullName, Position, Nationality, Number, DOB, ClubName, club.ClubID "
         ."FROM player left JOIN club ON player.ClubID = club.ClubID";
         
        //echo "model page: " . $page ."limit" . $limit;

        //use pagination
        $Paginator = new Paginator( dbconnect::$conn, $query );
        $result = $Paginator->getData( $page, $limit );

        //bootstrap pagination button
        $paginButton = $Paginator->createLinks( $links="", 'pagination justify-content-center' );
        
        //return pagination html and result
        $listAllPlayer = new stdClass();
        $listAllPlayer->paginButton = $paginButton;
        $listAllPlayer->listAllPlayer = array();

        if ($result) 
        {            
            foreach ($result->data as $row) {
                $player = new PlayerModel();
                $player->PlayerID = $row["PlayerID"];
                $player->FullName = $row["FullName"];
                $player->Position = $row["Position"];
                $player->Nationality = $row["Nationality"];
                $player->Number=$row["Number"];
                $player->DOB=$row["DOB"];
                $player->ClubName=$row["ClubName"];
                $player->ClubID=$row["ClubID"];            
                $listAllPlayer->listAllPlayer[] = $player;
            }
        }
        dbconnect::disconnect();


        return $listAllPlayer;
    }
}
?>