<?php
$filepath = realpath(dirname(__FILE__));
include ($filepath.'/../lib/session.php');
Session::checkLogin();
include ($filepath.'/../lib/database.php');
include ($filepath.'/../helpers/format.php');
?>

<?php

class AdminLogin
{
    
    private $db;
    private $fm;

    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }


    public function login_admin($adminUser, $adminPass)
    {
        $adminUser = $this->fm->validation($adminUser);
        $adminPass = $this->fm->validation($adminPass);

        $adminUser = mysqli_real_escape_string($this->db->link,$adminUser);
        $adminPass = mysqli_real_escape_string($this->db->link,$adminPass);

        if(empty($adminUser) || empty($adminPass)){
            $alert = 'username or password is not empty';
            return $alert;
        }
        else{
            $sql = "SELECT * FROM tbl_admin WHERE adminUser = '$adminUser' AND adminPass = '$adminPass' LIMIT 1";
            $result = $this->db->select($sql);

            if($result){
                $value = $result->fetch_assoc();
                Session::set('adminLogin',true);
                Session::set('adminId',$value['adminId']);
                Session::set('adminUser',$value['adminUser']);
                Session::set('adminName',$value['adminName']);

                header("Location: index.php");
            }
            else{
                $alert = "Sai tên đăng nhập hoặc mật khẩu";
                return $alert;
            }
        }
    }
}
