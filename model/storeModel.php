<?php
//CallAPI($url, $method = null, $data = false)
require_once("./../service/curl.php");
class StoreModel{
    public $_id; public $name; public $phone; public $email; public $password; 
    public $active; public $dayStart; public $timeOpen; public $timeClose;
    public $productCategory; public $logo; public $agreeTerm; public $area; 
    public $province; public $district; public $ward; public $address;

    function __constructor($_id="", $name="", $phone="", $email="", $password="", 
        $active="", $dayStart="", $timeOpen="", $timeClose="",
        $productCategory="", $logo="", $agreeTerm="", $area="", 
        $province="", $district="", $ward="", $address="")
    {
        $this->_id=$_id;  $this->name=$name;  $this->phone=$phone;  $this->email=$email;  $this->password=$password;  
        $this->active=$active;  $this->dayStart=$dayStart;  $this->timeOpen=$timeOpen;  $this->timeClose=$timeClose; 
        $this->productCategory=$productCategory;  $this->logo=$logo;  $this->agreeTerm=$agreeTerm;  $this->area=$area;  
        $this->province=$province;  $this->district=$district;  $this->ward=$ward;  $this->address=$address;
    }

    public static function getStoreInfo($_id=null){
        $url = "http://localhost:3000/api/store/$_id"; //?fields=name&fields=_id
        $result = CallAPI($url);
        if(empty($result)) return null;
        if(!empty($result->dayStart)) $result->dayStart = rtrim($result->dayStart, "Z");
        return $result;
    }

    public function updateStoreInfo(){
        $url = "http://localhost:3000/api/store/" . $this->_id . "?"; //?fields=name&fields=_id
        $result = CallAPI($url, "PUT", (array)$this);
        if(empty($result)) return null;
        if(!empty($result->dayStart)) $result->dayStart = rtrim($result->dayStart, "Z");
        return $result;
    }

    //register store
    public function createStore(){
        $url = "http://localhost:3000/api/store/register?"; //?fields=name&fields=_id
        $result = CallAPI($url, "POST", (array)$this);
        if(empty($result)) return null;
        if(!empty($result->dayStart)) $result->dayStart = rtrim($result->dayStart, "Z");
        return $result;
    }

    public static function updateStoreLogo($logo){
        // $url = "http://localhost:3000/api/file/"  . "?l" ; 
        // $result = CallAPI($url, "PUT", (array)$this);
        // if(empty($result)) return null;
        // if(!empty($result->dayStart)) $result->dayStart = rtrim($result->dayStart, "Z");
        // return $result;
        return null;
    }

    public static function login($email=null, $password=null){
        $url = "http://localhost:3000/api/store/email?email=$email"; //?fields=name&fields=_id
        $result = CallAPI($url);
        if(empty($result)) return false;
        if(!empty($result->password)){
            if($result->password != $password) return false;
        }
        if(!empty($result->dayStart)) $result->dayStart = rtrim($result->dayStart, "Z");
        return $result;
    }
//CallAPI($url, $method = null, $data = false)
    public static function sendCode($email){
        $url = "http://localhost:3000/api/store/sendcode?email=$email"; //?fields=name&fields=_id
        CallAPI($url, "PUT");
    }
    public static function rePasswordStore($email, $password, $code){
        $url = "http://localhost:3000/api/store/repassword?email=$email&password=$password&code=$code"; //?fields=name&fields=_id
        CallAPI($url, "PUT");
    }
}
?>