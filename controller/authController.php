<?php
session_start();
require_once("./../model/storeModel.php");
$cssRefPath = "./../";

class AuthController
{
    public static function getLoginHtml($resultForModal=null)
    {
        global $cssRefPath;
        $CONTENT_PATH = "./view/login.phtml";
        require_once($cssRefPath . "template/template.phtml");
    }

    public static function checkSession($pathRedirect="Location:/18120418_PhamMinhKhoa/router/auth.php"){
        if(!isset($_SESSION["userid"])){
            return false;
        }
        return true;
    }

    public static function login()
    {
        $resultForModal = "<h3>login()</h3>";
        $email = "";
        $password = "";
        if (isset($_POST["email"]) and $_POST["email"] != "")
        {
            $email = urldecode($_POST["email"]);
        }
        if (isset($_POST["password"]) and $_POST["password"] != "")
        {
            $password = urldecode($_POST["password"]);
        }
        $result = false;
        if($email == "" or $password == "")
        {
            $resultForModal .= 'Vui lòng nhập đủ thông tin đăng nhập!';
            self::getLoginHtml($resultForModal);
        }

        $result = StoreModel::login($email, $password);
        if ($result == false)
        {
            $resultForModal .= 'Đăng nhập thất bại! Sai tên hoặc mật khẩu';
            self::getLoginHtml($resultForModal);
        }
        else
        {
            if(!empty($result->code)){
                //error
                if($result->code >= 400 && $result->code <100000){
                    $resultForModal .= serialize($result);
                    self::getLoginHtml($resultForModal);
                }else{//
                    //success
                    //the active code is the same code name error
                    //should be placed at model
                    $_SESSION["userid"] = $result->_id;
                    $_SESSION["active-store"] = $result->active;
                    $resultForModal .= "Đăng nhập thành thành công!";
                    header("Location:info.php");
                }
            }
            else{
                $_SESSION["userid"] = $result->_id;
                $_SESSION["active-store"] = $result->active;
                $resultForModal .= "Đăng nhập thành thành công!";
                //echo "<script>window.location.href='info.php?_id='$result->_id</script>";
                header("Location:info.php");
            }            
        }
    }

    public static function logout()
    {
        //session_start();
        unset($_SESSION["userid"]);
        unset($_SESSION["active-store"]);
        //header("Location:loginout.php");
        echo "<script>window.location.href='/18120418_PhamMinhKhoa/router/auth.php'</script>";
    }
}
?>