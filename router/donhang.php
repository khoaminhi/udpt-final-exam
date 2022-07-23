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
            case "suadondichvu":
                $donhang->updateOrderedService();
                return;
            case "datdichvu":
                $donhang->datDichVU();
                return;
            case "huy":
                $donhang->huyDichVu();
                return;
            default:
                $donhang->timDonDichVu();
                return;
        }
    case 'GET':
        switch ($action) {
            case "tracuu-dondv":
                $donhang->findOrderedServiceHtml();
                return;
            default:
                $donhang->datDichVuHtml();
                return;
        }
}
?>