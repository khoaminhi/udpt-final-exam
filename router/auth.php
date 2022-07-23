<?php
require_once "./../controller/authController.php";
require_once "./../controller/storeController.php";

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
            case "login":
                AuthController::login();
                break;
            case "register":
                $storeInfo->registerStore();
                break;
            case "sendcode":
                $storeInfo->sendCode();
                break;
            case "repassword":
                $storeInfo->rePasswordStore();
                break;
            default:
            break;
        }
    case 'GET':
        switch ($action) {
            case "logout":
                AuthController::logout();
                break;
            case "register":
                $storeInfo->registerStoreHtml();
                break;
            case "sendcode":
                $storeInfo->sendCodeHtml();
                break;
            case "repassword":
                $storeInfo->rePasswordStoreHtml();
                break;
            default:
                AuthController::getLoginHtml();
                break;
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