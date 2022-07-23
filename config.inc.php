<?php
class dbconnect{
    private static $server = "localhost";
    private static $username = "root";
    private static $password = "";//"root";
    private static $db = "DichVuDB";//"footballdb";
    public static $conn;
    
    static function connect(){
        self::$conn = new mysqli(self::$server, self::$username, self::$password, self::$db);
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
