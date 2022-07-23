<?php
require_once "./../model/storeModel.php";
$cssRefPath = "./../";

class StoreController{
    public function getStoreInfo(){

        $_id="3bc0a610-0262-11ed-b589-a44cc8191af3";
        if(!empty($_GET["_id"])) $_id = $_GET["_id"];
        if(!empty($_SESSION["userid"])) $_id = $_SESSION["userid"];
        $active = $_SESSION['active-store'];
        $resultForModal = "<h3>getStoreInfo()</h3><h2>Session active: $active</h2>";
        $resultForModal .= "<p>Nếu đã kích hoạt mà chưa cập nhật được thông tin vui lòng logout rồi login lại</p>";

        $result = StoreModel::getStoreInfo($_id);
        
        if(!empty($result->code)){
            if($result->code >= 400 && $result->code <100000){
                $resultForModal .= serialize($result);
            }elseif($result){
                $resultForModal.='Thông tin trả về thành công!';
            }
            else{
                $resultForModal.='Thông tin trả về thất bại!';
            }
        }elseif($result){
            $resultForModal.='Thông tin trả về thành công!';
        }
        else{
            $resultForModal.='Thông tin trả về thất bại!';
        }

        global $cssRefPath;
        
        $CONTENT_PATH = "./view/infoView.phtml";
        require_once($cssRefPath . "template/template.phtml");
        return;
    }
    public function updateStoreInfo(){
        if((empty($_POST["name"]) && empty($_POST["phone"]) && empty($_POST["email"]) &&  
        empty($_POST["dayStart"]) && empty($_POST["timeOpen"]) && empty($_POST["timeClose"]) && empty($_POST["productCategory"]))){
            echo "<script>alert('Bạn đã bỏ trống ô thông tin!'); window.location.href='info.php'</script>";
            return;
        }
        
        $store = new StoreModel();
        $store->_id = $_SESSION["userid"];
        $store->name = urldecode($_POST["name"]);
        $store->phone = urldecode($_POST["phone"]);
        $store->email = urldecode($_POST["email"]);
        $store->dayStart = urldecode($_POST["dayStart"]);
        $store->timeOpen = urldecode($_POST["timeOpen"]);
        $store->timeClose = urldecode($_POST["timeClose"]);
        $store->productCategory = urldecode($_POST["productCategory"]);      
        
        $result=true;
        $resultForModal="<h3>updateStoreInfo()</h3>";
        //check error respone from api server
        $result = $store->updateStoreInfo();
        
        if(!empty($result->code)){
            if($result->code >= 400 && $result->code <100000){
                $resultForModal .= serialize($result);
            }elseif($result){
                $resultForModal.='Sửa thông tin thành công!';
            }
            else{
                $resultForModal.='Sửa thông tin thất bại!';
            }
        }elseif($result){
            $resultForModal.='Sửa thông tin thành công!';
        }
        else{
            $resultForModal.='Sửa thông tin thất bại!';
        }
        
        global $cssRefPath;
        $CONTENT_PATH = "./view/infoView.phtml";
        require_once($cssRefPath . "template/template.phtml");
        return;
    }

    //register view
    public function registerStoreHtml(){
        global $cssRefPath;
        $CONTENT_PATH = "./view/registerView.phtml";
        require_once($cssRefPath . "template/template.phtml");
        return;
    }
    //register store
    public function registerStore(){
        $resultForModal="<h3>registerStore()</h3>";
        if(empty($_POST["name"]) && empty($_POST["phone"]) && empty($_POST["email"]) &&  empty($_POST["password"]) &&
        empty($_POST["dayStart"]) && empty($_POST["timeOpen"]) && empty($_POST["timeClose"]) && empty($_POST["productCategory"]) && 
        empty($_POST["logo"]) && empty($_POST["agreeTerm"]) && 
        empty($_POST["province"]) && empty($_POST["district"]) && empty($_POST["ward"]) && empty($_POST["address"])){
            
            $resultForModal.='Bạn đã điền thiếu thông tin. Sửa thông tin thất bại!';
            global $cssRefPath;
            $CONTENT_PATH = "./view/registerView.phtml";
            require_once($cssRefPath . "template/template.phtml");
            return;
        }
        
        $store = new StoreModel();
        $store->name = urldecode($_POST["name"]);
        $store->phone = urldecode($_POST["phone"]);
        $store->email = urldecode($_POST["email"]);
        $store->password = urldecode($_POST["password"]);
        $store->dayStart = urldecode($_POST["dayStart"]);
        $store->timeOpen = urldecode($_POST["timeOpen"]);
        $store->timeClose = urldecode($_POST["timeClose"]);
        $store->productCategory = urldecode($_POST["productCategory"]);
        //$store->logo = urldecode($_POST["logo"]);
        $store->agreeTerm = intval(urldecode($_POST["agreeTerm"]));
        $store->province = urldecode($_POST["province"]);
        $store->district = urldecode($_POST["district"]);
        $store->ward = urldecode($_POST["ward"]);
        $store->address = urldecode($_POST["address"]);       
        
        $result=true;
        //check error respone from api server
        $result = $store->createStore();
        if(!empty($result->code)){
            if($result->code >= 400 && $result->code <100000){
                $resultForModal .= serialize($result);
            }elseif($result){
                $resultForModal.='Đăng ký cửa hàng thành công. Chờ kích hoạt!';
            }
            else{
                $resultForModal.='Đăng ký cửa hàng thất bại!';
            }
        }elseif($result){
            $resultForModal.='Đăng ký cửa hàng thành công. Chờ kích hoạt!';
        }
        else{
            $resultForModal.='Đăng ký cửa hàng thất bại!';
        }
        
        global $cssRefPath;
        $CONTENT_PATH = "./view/registerView.phtml";
        require_once($cssRefPath . "template/template.phtml");
        return;
    }

    public function updateStoreLogo(){
        if(empty($_POST["logo"])){
            $resultForModal='<h3>updateStoreLogo()</h3>Bạn chưa thêm logo mới. Thay logo thất bại!';
            global $cssRefPath;
            $CONTENT_PATH = "./view/infoView.phtml";
            require_once($cssRefPath . "template/template.phtml");
            return;
        }
        $result = StoreModel::updateStoreLogo($_POST["logo"]);
        if(!empty($result->code)){
            if($result->code >= 400 && $result->code <100000){
                $resultForModal .= serialize($result);
            }elseif($result){
                $resultForModal.='Cập nhật logo thành công';
            }
            else{
                $resultForModal.='Cập nhật logo thất bại!';
            }
        }elseif($result){
            $resultForModal.='Sửa thông tin thành công!';
        }
        else{
            $resultForModal.='Sửa thông tin thất bại!';
        }
        return;
    }

    public function sendCodeHtml($resultForModal=null){
        global $cssRefPath;
        $CONTENT_PATH = "./view/sendCode.phtml";
        require_once($cssRefPath . "template/template.phtml");
        return;
    }

    public function sendCode(){
        if(empty($_POST["email"])){
            $resultForModal='Bạn chưa cung cấp email. Gửi mã sao được!';
            $this->sendCodeHtml($resultForModal);
        }
        $email = urldecode($_POST["email"]);
        StoreModel::sendCode($email);
        //pass email to input hidden
        $this->rePasswordStoreHtml($email);
    }

    public function rePasswordStoreHtml($email=null){
        global $cssRefPath;
        $CONTENT_PATH = "./view/rePassword.phtml";
        require_once($cssRefPath . "template/template.phtml");
        return;
    }
    public function rePasswordStore(){
        if(empty($_POST["email"]) && empty($_POST["password"]) && empty($_POST["code"])){
            $resultForModal='Bạn chưa nhập đầy đủ. Chịu khó nhập vô nha!';
            $this->rePasswordStoreHtml($resultForModal);
        }
        $email = urldecode($_POST["email"]);
        $password = urldecode($_POST["password"]);
        $code = urldecode($_POST["code"]);
        StoreModel::rePasswordStore($email, $password, $code);
        echo "<script>window.location.href='auth.php'</script>";
        return;
    }
} 