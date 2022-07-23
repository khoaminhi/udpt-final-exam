<?php
//DAKHOITAO
//DAXACNHAN
//DANGTIENHANH
//HOANTAT
//HUY
//date('Y-m-d H:i:s')
require_once "./../service/generator.php";
require_once "./../service/paginator.php";
//define("orderStatus", array("DAKHOITAO" => 1, "DAXACNHAN"=> 2, "DANGTIENHANH" => 3, "HOANTAT" => 4, "HUY" => 5));

class DonHangModel{
    public $MaDH; public $TenKH; public $DienThoai; public $DiaChi; 
    public $ThoiGianBD; public $TrangThai; public $ThoiGianKT;
    public $MaDV; public $SoLuong; public $ThanhTien;
    public $GhiChu; public $MaDangKy;
    const ORDER_STATUS = array("DAKHOITAO" => 1, "DAXACNHAN"=> 2, "DANGTIENHANH" => 3, "HOANTAT" => 4, "HUY" => 5);

    function __constructor($MaDH="", $TenKH="", $DienThoai="", $DiaChi="",
        $ThoiGianBD=null, $TrangThai="DAKHOITAO", $ThoiGianKT=null,
        $MaDV=null, $SoLuong=0, $ThanhTien=0, 
        $GhiChu="", $MaDangKy="")
    {
        $this->MaDH=$MaDH;  $this->TenKH=$TenKH;  $this->DienThoai=$DienThoai; $this->DiaChi=$DiaChi; 
        $this->ThoiGianBD=$ThoiGianBD;  $this->TrangThai=$TrangThai;  $this->ThoiGianKT=$ThoiGianKT; 
        $this->MaDV=$MaDV;  $this->SoLuong=$SoLuong;  $this->ThanhTien=$ThanhTien;  
        $this->GhiChu=$GhiChu;  $this->MaDangKy=$MaDangKy;
    }

    //admin//////////////////////////////////////////////
    public static function updateOrderedServiceStatus($MaDangKy, $TrangThai){
        if(empty(self::ORDER_STATUS[$TrangThai])){
            return "Trạng thái đưa vào không hợp lệ. Vui lòng thử lại.";
        }
        $inputStatusLevel = self::ORDER_STATUS[$TrangThai];
        //Check
        $dbOrderStatus = self::findOneOrderedService($MaDangKy)[0];
        if(empty($dbOrderStatus->TrangThai)){
            return "Lấy mã trạng thái db thất bại. Vui lòng thử lại.";
        }
        $dbStatusLevel = self::ORDER_STATUS[$dbOrderStatus->TrangThai];

        if($inputStatusLevel <= $dbStatusLevel){
            return "Không thể quay lui trạng thái!";
        }

        dbconnect::connect();
        $query = "UPDATE donhang set TrangThai = '$TrangThai' where MaDangKy = '$MaDangKy'";

        $result = dbconnect::$conn->query($query);
                
        if(!$result){
            return "Giá trị trả về bằng false. Thực hiện cập nhật thất bại.";
        }
        
        $dbOrderStatus->TrangThai = $TrangThai;

        $orderAndStatusLevel = new stdClass();
        $orderAndStatusLevel->data = $dbOrderStatus;
        $orderAndStatusLevel->statusLevel = $inputStatusLevel;
        
        dbconnect::disconnect();
        return $orderAndStatusLevel;
    }
    
    public static function getAllOrderedServiceAdmin($page=1, $limit=3){
        dbconnect::connect();
        $query = "SELECT * FROM donhang";

        //use pagination
        $Paginator = new Paginator( dbconnect::$conn, $query );
        $orderd = $Paginator->getData( $page, $limit );
        //var_dump($orderd);
        //bootstrap pagination button
        $paginButton = $Paginator->createLinks( $links="action=danhsachdv&", 'pagination justify-content-center' );
        
        //return pagination html and result
        $result = new stdClass();
        $result->paginButton = $paginButton;
        $result->result = array();

        
        if ($orderd) 
        {            
            foreach ($orderd->data as $row) {
                $order = new DonHangModel();
                $order->MaDH = $row['MaDH'];
                $order->TenKH = $row["TenKH"];
                $order->DienThoai = $row["DienThoai"];
                $order->DiaChi = $row['DiaChi'];
                $order->ThoiGianBD = $row['ThoiGianBD'];
                $order->TrangThai = $row["TrangThai"];
                $order->ThoiGianKT = $row['ThoiGianKT'];
                $order->MaDV = $row["MaDV"];
                $order->SoLuong = $row["SoLuong"];
                $order->ThanhTien = $row["ThanhTien"];
                $order->GhiChu = $row["GhiChu"];
                $order->MaDangKy = $row["MaDangKy"];
                
                $result->result[] = $order; //add an item into array
            }
        }

        dbconnect::disconnect();
        return $result;
    }





    //Khách hàng//////////////////////////////////////////////////
    //dat don hang dich vu
    public function createDonHang(){
        //asign the some rested column
        $this->ThoiGianBD=date('Y-m-d H:i:s');  $this->TrangThai= "DAKHOITAO";  $this->ThoiGianKT=date('Y-m-d H:i:s');
        $this->MaDangKy = rand_str();
        $dichvu = DichVuModel::findOneService($this->MaDV);
        $dv = array();
        if ($dichvu) 
        {            
            foreach ($dichvu as $row) {
                $temp = new DichVuModel();
                $temp->MaDV = $row['MaDV'];
                $temp->TenDV = $row["TenDV"];
                $temp->LoaiDV = $row["LoaiDV"];
                $temp->DonGia = (float)$row["DonGia"];
                $dv[] = $temp; //add an item into array
            }
        }

        //thanh tien
        $this->ThanhTien = $dv[0]->DonGia * $this->SoLuong;


        dbconnect::connect();
        $query = "INSERT INTO donhang(TenKH,  DienThoai,DiaChi, 
            ThoiGianBD,  TrangThai,  ThoiGianKT,
            MaDV,  SoLuong, ThanhTien, 
            GhiChu, MaDangKy) 
            VALUES('$this->TenKH',  '$this->DienThoai', '$this->DiaChi', 
            '$this->ThoiGianBD',  '$this->TrangThai',  '$this->ThoiGianKT',
            $this->MaDV,  $this->SoLuong, $this->ThanhTien, 
            '$this->GhiChu', '$this->MaDangKy')";

        $ordered = dbconnect::$conn->query($query);
                
        if($ordered) return $this;

        return false;
    }

    //find a ordered service
    public static function findOneOrderedService($MaDangKy){
        dbconnect::connect();
        $query = "SELECT * FROM donhang where MaDangKy = '$MaDangKy'";
        $orderd = dbconnect::$conn->query($query);
        $result = array();
        if ($orderd) 
        {            
            foreach ($orderd as $row) {
                $order = new DonHangModel();
                $order->MaDH = $row['MaDH'];
                $order->TenKH = $row["TenKH"];
                $order->DienThoai = $row["DienThoai"];
                $order->DiaChi = $row['DiaChi'];
                $order->ThoiGianBD = $row['ThoiGianBD'];
                $order->TrangThai = $row["TrangThai"];
                $order->ThoiGianKT = $row['ThoiGianKT'];
                $order->MaDV = $row["MaDV"];
                $order->SoLuong = $row["SoLuong"];
                $order->ThanhTien = $row["ThanhTien"];
                $order->GhiChu = $row["GhiChu"];
                $order->MaDangKy = $row["MaDangKy"];
                
                $result[] = $order; //add an item into array
            }
        }

        dbconnect::disconnect();
        return $result;
    }

    public static function cancelOrderedService($MaDangKy){
        $isCanceled = self::findOneOrderedService($MaDangKy)[0];

        dbconnect::connect();
        $result = false;
        if($isCanceled){
            if(!empty($isCanceled->TrangThai) && $isCanceled->TrangThai == "DAKHOITAO"){
                $query = "UPDATE donhang set TrangThai = 'HUY' where MaDangKy = '$MaDangKy'";
                $result = dbconnect::$conn->query($query);
            }
        }
        
        dbconnect::disconnect();
        return $result;
    }

    public function updateOrderedService(){
        //Check
        $isCanceled = self::findOneOrderedService($this->MaDangKy)[0];
        if(!empty($isCanceled->TrangThai)){
            if($isCanceled->TrangThai != "DAKHOITAO"){
                return false;
            }
        }

        //asign the some rested column
        $this->ThoiGianKT=date('Y-m-d H:i:s');
        $dichvu = DichVuModel::findOneService($this->MaDV);
        $dv = array();
        if ($dichvu) 
        {            
            foreach ($dichvu as $row) {
                $temp = new DichVuModel();
                $temp->MaDV = $row['MaDV'];
                $temp->TenDV = $row["TenDV"];
                $temp->LoaiDV = $row["LoaiDV"];
                $temp->DonGia = (float)$row["DonGia"];
                $dv[] = $temp; //add an item into array
            }
        }

        //thanh tien
        $this->ThanhTien = $dv[0]->DonGia * $this->SoLuong;


        dbconnect::connect();
        $query = "UPDATE donhang set TenKH = '$this->TenKH',  DienThoai = '$this->DienThoai', DiaChi = '$this->DiaChi', 
            SoLuong = $this->SoLuong, ThanhTien = $this->ThanhTien, 
            GhiChu = '$this->GhiChu' where MaDangKy = '$this->MaDangKy'";

        $ordered = dbconnect::$conn->query($query);
                
        if($ordered) return $this;
        dbconnect::disconnect();
        return false;
    }
}
?>