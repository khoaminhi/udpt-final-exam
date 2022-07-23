<?php
require_once "./../config.inc.php";
class DichVuModel{
    public $MaDV;
    public $TenDV;
    public $LoaiDV;
    public $DonGia;

    function __constructor(){
        $this->MaDV = "";
        $this->TenDV="";
        $this->LoaiDV="";
        $this->DonGia="";
    }

    public static function findOneService($MaDV){
        dbconnect::connect();
        $query = "SELECT * FROM dichvu where MaDV = '$MaDV'";
        $result = dbconnect::$conn->query($query);
        
        dbconnect::disconnect();
        return $result;
    }

    public static function getAllService(){
        dbconnect::connect();
        $query = "SELECT * FROM dichvu";
        $result = dbconnect::$conn->query($query);
        $dichvu = array();
        if ($result) 
        {            
            foreach ($result as $row) {
                $dv = new DichVuModel();
                $dv->MaDV = $row['MaDV'];
                $dv->TenDV = $row["TenDV"];
                $dv->LoaiDV = $row["LoaiDV"];
                $dv->DonGia = $row["DonGia"];
                $dichvu[] = $dv; //add an item into array
            }
        }
        dbconnect::disconnect();
        return $dichvu;
    }

    public static function createdv($TenDV, $dvLoaiDV, $dvDonGia){
        dbconnect::connect();
        //check stadium id if exist
        $query = "SELECT DonGia FROM stadium WHERE DonGia = '$dvDonGia'";
        $result = dbconnect::$conn->query($query);
        if($result == false){
            echo "Stadium ID does not exist!";
            return false;
        }
        if (mysqli_num_rows($result) <= 0) {
            echo "Stadium ID does not exist";
            return;
        }

        //check coach id if exist
        $query = "SELECT CoachID FROM coach WHERE CoachID = '$dvCoachID'";
        $result = dbconnect::$conn->query($query);
        if (mysqli_num_rows($result) <= 0) {
            echo "Coach ID does not exist";
            return;
        }

        //create new dv id by geting max dv id
        $getMaxIDdvQuery = "SELECT MAX(MaDV) as maxID FROM dv";
        $result = dbconnect::$conn->query($getMaxIDdvQuery);
        $row = $result->fetch_assoc();
        $maxID = $row["maxID"];
        $maxID++;

        $query = "INSERT INTO dv (MaDV, TenDV, LoaiDV, DonGia, CoachID) 
            VALUES ('$maxID', '$TenDV', '$dvLoaiDV', '$dvDonGia', '$dvCoachID')";
        $result = dbconnect::$conn->query($query);
        dbconnect::disconnect();
        return $result;
    }

    public static function modifydv($MaDV, $TenDV, $dvLoaiDV, $dvDonGia, $dvCoachID){
        dbconnect::connect();
        //check stadium id if exist
        $query = "SELECT DonGia FROM stadium WHERE DonGia = '$dvDonGia'";
        $result = dbconnect::$conn->query($query);
        if (mysqli_num_rows($result) <= 0) {
            echo "Stadium ID does not exist";
            return;
        }

        //check coach id if exist
        $query = "SELECT CoachID FROM coach WHERE CoachID = '$dvCoachID'";
        $result = dbconnect::$conn->query($query);
        if (mysqli_num_rows($result) <= 0) {
            echo "Coach ID does not exist";
            return;
        }

        //check dv id if exist
        $query = "SELECT MaDV FROM dv WHERE MaDV = '$MaDV'";
        $result = dbconnect::$conn->query($query);
        if (mysqli_num_rows($result) <= 0) {
            echo "dv ID does not exist";
            return;
        }

        $query = "UPDATE dv SET TenDV = '$TenDV', LoaiDV = '$dvLoaiDV', DonGia = '$dvDonGia', 
            CoachID = '$dvCoachID' WHERE MaDV = '$MaDV'";
        $result = dbconnect::$conn->query($query);
        dbconnect::disconnect();
        return $result;
    }
}