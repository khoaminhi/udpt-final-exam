<?php
require_once "./../model/donhangModel.php";
require_once "./../model/dichvuModel.php";


$cssRefPath = "./../";

class DonHangController{
    
    ////admin///////////////////////////////////////////////////////////////////
    public function updateOrderedServiceStatus(){
        $resultForModal="<h3>updateOrderedServiceStatus()</h3>";
        if((empty($_POST["MaDangKy"]) || empty($_POST["TrangThai"]))
        ){
            $resultForModal .= 'Thiếu params truyền vào. Cập nhật trạng thái thất bại!';
            echo "<script>alert($resultForModal); window.location.href='/18120418_PhamMinhKhoa/router/admin.php'</script>";
            return;
        }

        $MaDangKy = urldecode($_POST["MaDangKy"]);
        $TrangThai = urldecode($_POST["TrangThai"]);
        $orderAndStatusLevel = DonHangModel::updateOrderedServiceStatus($MaDangKy, $TrangThai);

        if(gettype($orderAndStatusLevel) == 'string'){
            $resultForModal .= "Cập nhật trạng thái thất bại! $orderAndStatusLevel";
            echo "<script>alert('$resultForModal'); window.location.href='/18120418_PhamMinhKhoa/router/admin.php';</script>";
            return;
        }

        $order = $orderAndStatusLevel->data;
        $statusLevel = $orderAndStatusLevel->statusLevel;

        global $cssRefPath;
        $CONTENT_PATH = "./view/admin-trang6-chitietdh.phtml";
        require_once($cssRefPath . "template/template.phtml");
        return;
    }
    
    public function updateOrderedStatusHtml(){
        $resultForModal="<h3>updateOrderedStatusHtml()</h3>";

        // if(!(empty($_POST["TenKH"]) && empty($_POST["DienThoai"]) && empty($_POST["MaDV"]) && empty($_POST["SoLuong"]) &&
        //     empty($_POST["province"]) && empty($_POST["district"]) && empty($_POST["ward"]) && empty($_POST["address"]))
        // ){
        //     $resultForModal.='Bạn đã điền thiếu thông tin. Đặt dịch vụ thất bại!';
        //     $this->datDichVuHtml($resultForModal);
        //     return;
        // }
        
        $donhang = new DonHangModel();
        $donhang->TenKH = urldecode($_GET["TenKH"]);
        $donhang->DienThoai = urldecode($_GET["DienThoai"]);
        $donhang->DiaChi = urldecode($_GET["DiaChi"]);
        $donhang->ThoiGianBD = urldecode($_GET["ThoiGianBD"]);
        $donhang->TrangThai = urldecode($_GET["TrangThai"]);
        $donhang->ThoiGianKT = urldecode($_GET["ThoiGianKT"]);
        
        $donhang->MaDV = (int)urldecode($_GET["MaDV"]);
        $donhang->SoLuong = (int)urldecode($_GET["SoLuong"]);
        $donhang->ThanhTien = (int)urldecode($_GET["ThanhTien"]);
        $donhang->GhiChu = urldecode($_GET["GhiChu"]);
        $donhang->MaDangKy = urldecode($_GET["MaDangKy"]);

        $order = $donhang;
        //echo $order->TenKH;
        $resultForModal = empty($resultForModal) == true ? "updateOrderedStatusHtml()" : $resultForModal;
        global $cssRefPath;
        $CONTENT_PATH = "./view/admin-trang6-chitietdh.phtml";
        require_once($cssRefPath . "template/template.phtml");
        return;
    }
    
    public function getAllOrderedServiceAdminHtml($resultForModal=""){
        $page = urldecode(empty($_GET["page"]) == true ? 1 : $_GET["page"]);
        $limit = urldecode(empty($_GET["limit"]) == true ? 3 : $_GET["limit"]);
        
        $page = urldecode($page < 1 ? 1 : $page);
        $limit = urldecode($limit < 1 ? 3 : $limit);

        $resultForModal = empty($resultForModal) == true ? "findOrderedServiceHtml()" : $resultForModal;
        global $cssRefPath;
        
        $resultModel = DonHangModel::getAllOrderedServiceAdmin($page, $limit);
        $result = $resultModel->result;
        $paginButton = $resultModel->paginButton;
        
        //var_dump($paginButton);
        //echo "<h1>paginanttion donhang controllrr: " .serialize($paginButton)." </h1>";

        if(empty($result)){
            $resultForModal.="<h3 class='text-warning'>Không có đơn hàng nào được tìm thấy!</h3>";
        }
        else{
            $resultForModal.="<h3 class='text-success'>Đã lấy tất cả đơn hàng. Và phân trang chúng</h3>";
        }
        
        $CONTENT_PATH = "./view/admin-trang5-danhsachdv.phtml";
        require_once($cssRefPath . "template/template.phtml");
        return;
    }
    
    public function adminHomeHtml($resultForModal=""){
        $resultForModal = empty($resultForModal) == true ? "Xin chào admin đến với hệ thống" : $resultForModal;
        global $cssRefPath;


        $CONTENT_PATH = "./view/admin-home.phtml";
        require_once($cssRefPath . "template/template.phtml");
        return;
    }

    /// Khách hàng///////////////////////////////////////////////////////////
    //dat dich vu view
    public function datDichVuHtml($resultForModal=""){
        $resultForModal = empty($resultForModal) == true ? "Xin chào quý khách đến với dịch vụ của chúng tôi" : $resultForModal;
        global $cssRefPath;

        //get service list
        $dichvu = DichVuModel::getAllService();

        $CONTENT_PATH = "./view/trang2-datdichvu.phtml";
        require_once($cssRefPath . "template/template.phtml");
        return;
    }


    //đậ donhang
    public function datDichVU(){
        $resultForModal="<h3>datDichVU()</h3>";

        // if(!(empty($_POST["TenKH"]) && empty($_POST["DienThoai"]) && empty($_POST["MaDV"]) && empty($_POST["SoLuong"]) &&
        //     empty($_POST["province"]) && empty($_POST["district"]) && empty($_POST["ward"]) && empty($_POST["address"]))
        // ){
        //     $resultForModal.='Bạn đã điền thiếu thông tin. Đặt dịch vụ thất bại!';
        //     $this->datDichVuHtml($resultForModal);
        //     return;
        // }
        
        $donhang = new DonHangModel();
        $donhang->TenKH = urldecode($_POST["TenKH"]);
        $donhang->DienThoai = urldecode($_POST["DienThoai"]);
        $donhang->MaDV = (int)urldecode($_POST["MaDV"]);
        $donhang->SoLuong = (int)urldecode($_POST["SoLuong"]);
        //merge address
        //$province = urldecode($_POST["province"]);
        //$district = urldecode($_POST["district"]);
        //$ward = urldecode($_POST["ward"]);
        $address = urldecode($_POST["address"]);
        $donhang->DiaChi = $address;//, $ward, $district, $province"; 
        $donhang->GhiChu = urldecode($_POST["GhiChu"]);

        $result=true;

        //
        $result = $donhang->createDonHang();
        if(!empty($result->code)){
            if($result->code >= 400 && $result->code <100000){
                $resultForModal .= serialize($result);
            }elseif($result){
                $resultForModal.='Yêu cầu dịch vụ thành công!';
            }
            else{
                $resultForModal.='Yêu cầu dịch vụ thất bại!';
            }
        }elseif($result){
            $resultForModal.='Yêu cầu dịch vụ thành công!';
        }
        else{
            $resultForModal.='Yêu cầu dịch vụ thất bại!';
        }
        
        $dichvu = DichVuModel::getAllService();
        global $cssRefPath;
        $CONTENT_PATH = "./view/trang3-chitiet-dv.phtml";
        require_once($cssRefPath . "template/template.phtml");
        return;
    }

    //search the ordered service
    public function findOrderedServiceHtml($resultForModal=""){
        $resultForModal = empty($resultForModal) == true ? "findOrderedServiceHtml()" : $resultForModal;
        global $cssRefPath;
        $MaDangKy = (empty($_GET["MaDangKy"]) == true) ? "83591356" : $_GET["MaDangKy"];
        
        $result = DonHangModel::findOneOrderedService($MaDangKy)[0];
        if(empty($result)){
            $resultForModal.="<h3 class='text-warning'>Không có đơn hàng nào được tìm thấy. Quý khách vui lòng kiểm tra lại mã!</h3>";
        }
        else{
            $resultForModal.="<h3 class='text-success'>Có 1 đơn hàng đượC tìm thấy.</h3>";
        }
        $dichvu = DichVuModel::getAllService();
        
        $CONTENT_PATH = "./view/trang3-chitiet-dv.phtml";
        require_once($cssRefPath . "template/template.phtml");
        return;
    }

    public function huyDichVu($resultForModal=""){
        $resultForModal = empty($resultForModal) == true ? "findOrderedServiceHtml()" : $resultForModal;
        global $cssRefPath;
        $MaDangKy = empty($_POST["MaDangKy"]) == true ? "83591356" : $_POST["MaDangKy"];
        
        $deleteResult = DonHangModel::cancelOrderedService($MaDangKy);
        if($deleteResult){
            $resultForModal .= "Huy dich vu thành công";
        }
        else{
            $resultForModal .= "<h3 class='text-warning'>Huy dich vu thất bại. Có lẽ dịch vụ không còn trạng thái DAKHOITAO!</h3>";
        }

        $result = DonHangModel::findOneOrderedService($MaDangKy)[0];
        $dichvu = DichVuModel::getAllService();
        
        $CONTENT_PATH = "./view/trang3-chitiet-dv.phtml";
        require_once($cssRefPath . "template/template.phtml");
        return;
    }

    public function updateOrderedService(){
        $resultForModal="<h3>updateOrderedService()</h3>";

        // if(!(empty($_POST["TenKH"]) && empty($_POST["DienThoai"]) && empty($_POST["MaDV"]) && empty($_POST["SoLuong"]) &&
        //     empty($_POST["province"]) && empty($_POST["district"]) && empty($_POST["ward"]) && empty($_POST["address"])
        //     && empty($_POST["MaDangKy"]))
        // ){
        //     $resultForModal.='Bạn đã điền thiếu thông tin. Đặt dịch vụ thất bại!';
        //     $this->datDichVuHtml($resultForModal);
        //     return;
        // }
        
        $donhang = new DonHangModel();
        $donhang->TenKH = urldecode($_POST["TenKH"]);
        $donhang->DienThoai = urldecode($_POST["DienThoai"]);
        $donhang->MaDV = (int)urldecode($_POST["MaDV"]);
        $donhang->SoLuong = (int)urldecode($_POST["SoLuong"]);
        //merge address
        //$province = urldecode($_POST["province"]);
        //$district = urldecode($_POST["district"]);
        //$ward = urldecode($_POST["ward"]);
        $address = urldecode($_POST["address"]);
        $donhang->DiaChi = $address;//, $ward, $district, $province"; 
        $donhang->GhiChu = urldecode($_POST["GhiChu"]);
        $donhang->MaDangKy = urldecode($_POST["MaDangKy"]);


        $result=true;

        //
        $result = $donhang->updateOrderedService();
        if(!empty($result->code)){
            if($result->code >= 400 && $result->code <100000){
                $resultForModal .= serialize($result);
            }elseif($result){
                $resultForModal.='Sửa yêu cầu dịch vụ thành công!';
            }
            else{
                $resultForModal.='Sửa yêu cầu dịch vụ thất bại!';
            }
        }elseif($result){
            $resultForModal.='Sửa yêu cầu dịch vụ thành công!';
        }
        else{
            $resultForModal.='Sửa yêu cầu dịch vụ thất bại. Có lẽ đơn hàng đã không còn trạng thái DAKHOITAO!';
        }
        
        $dichvu = DichVuModel::getAllService();
        global $cssRefPath;
        $CONTENT_PATH = "./view/trang3-chitiet-dv.phtml";
        require_once($cssRefPath . "template/template.phtml");
        return;
    }
} 