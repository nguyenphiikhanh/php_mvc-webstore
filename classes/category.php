<?php
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../lib/database.php');
include_once ($filepath.'/../helpers/format.php');
?>

<?php

class Category
{

    private $db;
    private $fm;

    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }


    public function insert_category($catName)
    {
        $catName = $this->fm->validation($catName);

        $catName = mysqli_real_escape_string($this->db->link, $catName);

        if (empty($catName)) {
            $alert = "<span class='adderror'>Tên danh mục không được để trống</span>";
            return $alert;
        } else {
            // $slt = "SELECT * FROM tbl_category WHERE catName = '$catName'";
            // $kq = $this->db->select($slt);
            // $rowCount = mysqli_num_rows($kq);
            // if ($rowCount > 0) {
            //     $alert = "<span class='adderror'>Danh mục đã tồn tại,vui lòng thêm danh mục khác hoặc sửa đổi danh mục</span>";
            //     return $alert;
            // } else {
                $sql = "INSERT INTO tbl_category(catName) VALUES('$catName')";
                $result = $this->db->insert($sql);
                if ($result) {
                    $alert = "<span class='addsuccess'>Thêm danh mục thành công</span>";
                    return $alert;
                } else {
                    $alert = "<span class='adderror'>Thêm danh mục không thành công</span>";
                    return $alert;
                }
            // }
        }
    }

    public function showCategories()
    {
        $sql = "SELECT * FROM tbl_category ORDER BY catId DESC";
        $result = $this->db->select($sql);
        return $result;
    }

    public function getCateById($id)
    {
        $sql = "SELECT * FROM tbl_category WHERE catId = '$id'";
        $result = $this->db->select($sql);
        return $result;
    }

    public function update_category($catName, $id)
    {
        $catName = $this->fm->validation($catName);
        $catName = mysqli_real_escape_string($this->db->link, $catName);
        $id = mysqli_real_escape_string($this->db->link, $id);

        if (empty($catName)) {
            $alert = "<span class='adderror'>Tên danh mục không được bỏ trống</span>";
            return $alert;
        } else {
            $sql = "UPDATE tbl_category SET catName = '$catName' WHERE catId = '$id'";
            $result = $this->db->update($sql);
            if ($result) {
                $alert = "<span class='addsuccess'>Sửa thành công</span>";
                return $alert;
            } else {
                $alert = "<span class='adderror'>Sửa danh mục không thành công,vui lòng thử lại</span>";
                return $alert;
            }
        }
    }

    public function del_category($id){
        $sql = "DELETE FROM tbl_category WHERE catId = '$id'";
        $result = $this->db->delete($sql);
        if($result){
            $alert = "<span class='addsuccess'>Xóa danh mục thành công</span>";
            return $alert;
        }else{
            $alert = "<span class='adderror'>Xóa danh mục không thành công,vui lòng thử lại</span>";
            return $alert;
        }
    }
}
