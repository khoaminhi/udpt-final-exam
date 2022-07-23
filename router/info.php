<?php
require_once "./../controller/storeController.php";
require_once "./../controller/authController.php";

if(AuthController::checkSession() == false){
    echo "<script>alert('Vui lòng đăng nhập!'); window.location.href='auth.php'</script>";
    //header("Location:auth.php");
    return;
}

$storeInfo = new StoreController();
$action = "";
if (isset($_REQUEST["action"])) {
    $action = $_REQUEST["action"];
}

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'PUT':
        //$storeInfo->updateStoreInfo();
        break;
    case 'POST':
        switch ($action) {
            case "update":
                if($_SESSION["active-store"] == 1){
                    $storeInfo->updateStoreInfo();
                    return;
                }
                echo "<script>alert('Tài khoản chưa kích hoạt! Vui lòng liên hệ quản trị viên'); window.location.href='info.php'</script>";
                return;
            case "updatelogo":
                if($_SESSION["active-store"] == 1){
                    $storeInfo->updateStoreLogo();
                    return;
                }
                echo "<script>alert('Tài khoản chưa kích hoạt! Vui lòng liên hệ quản trị viên'); window.location.href='info.php'</script>";
                return;
            default:
                $storeInfo->getStoreInfo();
                return;
        }
    case 'GET':
        switch ($action) {
            default:
                $storeInfo->getStoreInfo();
                return;
        }
}

// switch ($action) {
//     case "update":
//         //$storeInfo->updateStoreInfo();
//         break;
//     default:
//         $storeInfo->getStoreInfo();
//         break;
// }
?>