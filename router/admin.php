<?php
require_once "./../controller/donhangController.php";
///require_once "./../controller/authController.php";

// if(AuthController::checkSession() == false){
//     echo "<script>alert('Vui lòng đăng nhập!'); window.location.href='auth.php'</script>";
//     //header("Location:auth.php");
//     return;
// }

$donhang = new DonHangController();

$action = "";
if (isset($_REQUEST["action"])) {
    $action = $_REQUEST["action"];
}

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST':
        switch ($action) {
            case "capnhattrangthai":
                $donhang->updateOrderedServiceStatus();
                return;
        }
    case 'GET':
        switch ($action) {
            case "danhsachdv":
                $donhang->getAllOrderedServiceAdminHtml();
                return;
            case "capnhattrangthai":
                $donhang->updateOrderedStatusHtml();
                return;
            default:
                $donhang->adminHomeHtml();
                return;
        }
}
?>