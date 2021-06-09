<?php
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../lib/database.php');
include_once ($filepath.'/../helpers/format.php');
?>

<?php

class Brand
{

    private $db;
    private $fm;

    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }


    public function insert_brand($brandName)
    {
        $brandName = $this->fm->validation($brandName);

        $brandName = mysqli_real_escape_string($this->db->link, $brandName);

        if (empty($brandName)) {
            $alert = "<span class='adderror'>Tên thương hiệu không được để trống</span>";
            return $alert;
        } else {
            // $slt = "SELECT * FROM tbl_brand WHERE brandname = '$brandname'";
            // $kq = $this->db->select($slt);
            // $rowCount = mysqli_num_rows($kq);
            // if ($rowCount > 0) {
            //     $alert = "<span class='adderror'>Danh mục đã tồn tại,vui lòng thêm danh mục khác hoặc sửa đổi danh mục</span>";
            //     return $alert;
            // } else {
                $sql = "INSERT INTO tbl_brand(brandName) VALUES('$brandName')";
                $result = $this->db->insert($sql);
                if ($result) {
                    $alert = "<span class='addsuccess'>Thêm thương hiệu thành công</span>";
                    return $alert;
                } else {
                    $alert = "<span class='adderror'>Thêm thương hiệu không thành công</span>";
                    return $alert;
                }
            // }
        }
    }

    public function showBrand()
    {
        $sql = "SELECT * FROM tbl_brand ORDER BY brandId DESC";
        $result = $this->db->select($sql);
        return $result;
    }

    public function getBrandById($id)
    {
        $sql = "SELECT * FROM tbl_brand WHERE brandId = '$id'";
        $result = $this->db->select($sql);
        return $result;
    }

    public function update_brand($brandname, $id)
    {
        $brandname = $this->fm->validation($brandname);
        $brandname = mysqli_real_escape_string($this->db->link, $brandname);
        $id = mysqli_real_escape_string($this->db->link, $id);

        if (empty($brandname)) {
            $alert = "<span class='adderror'>Tên thương hiệu không được bỏ trống</span>";
            return $alert;
        } else {
            $sql = "UPDATE tbl_brand SET brandName = '$brandname' WHERE brandId = '$id'";
            $result = $this->db->update($sql);
            if ($result) {
                $alert = "<span class='addsuccess'>Sửa thành công</span>";
                return $alert;
            } else {
                $alert = "<span class='adderror'>Sửa thương hiệu không thành công,vui lòng thử lại</span>";
                return $alert;
            }
        }
    }

    public function del_brand($id){
        $sql = "DELETE FROM tbl_brand WHERE brandId = '$id'";
        $result = $this->db->delete($sql);
        if($result){
            $alert = "<span class='addsuccess'>Xóa thương hiệu thành công</span>";
            return $alert;
        }else{
            $alert = "<span class='adderror'>Xóa thương hiệu không thành công,vui lòng thử lại</span>";
            return $alert;
        }
    }
}
