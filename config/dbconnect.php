<?php
class dbconnect{
    private $server = "localhost";
    private $username = "root";
    private $password = "";
    private $db = "footballdb";
    public static $conn;
    
    static function connect(){
        self::$conn = new mysqli($server, $username, $password, $db);
        if (self::$conn->connect_errno) {
            die("<script>console.log('Couldnt connect to thicuoiky database: " . self::$conn->connect_error . "')</script>");
        }
        echo "<script>console.log('Connected to thicuoiky successfully')</script>";
    }
    static function disconnect(){
        self::$conn->close();
        echo "<script>console.log('Disconnected from thicuoiky successfully')</script>";
    }
}
?>
