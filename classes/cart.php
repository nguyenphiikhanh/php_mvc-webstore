<?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../lib/database.php');
include_once($filepath . '/../helpers/format.php');
?>

<?php

class Cart
{

    private $db;
    private $fm;

    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }

    public function add_to_cart($quantity, $id)
    {
        $this->fm->validation($quantity);
        $quantity = mysqli_real_escape_string($this->db->link, $quantity);
        $id = mysqli_real_escape_string($this->db->link, $id);
        $sId = session_id();

        $sql = "SELECT * FROM tbl_product WHERE productId = '$id'";
        $result = $this->db->select($sql)->fetch_assoc();

        $image = $result['image'];
        $price = $result['price'];
        $productName = $result['productName'];

        //lọc sp trùng

        // $check_product = "SELECT * FROM tbl_cart WHERE productId = '$id' AND sId = '$sId'"; 

        // $rs_check = $this->db->select($check_product);

        // if (mysqli_num_rows($rs_check) > 0) {
        //     $alert = "<span class='adderror'>Sản phẩm đã tồn tại trong giỏ hàng</span>";
        //     return $alert;
        // } else {
        $query = "INSERT INTO tbl_cart(productId,quantity,sId,image,price,productName) VALUES('$id',
        '$quantity','$sId','$image','$price','$productName')";
        $insert_cart = $this->db->insert($query);
        if ($insert_cart) {
            header("Location:cart.php");
        } else {
            header("Location:404.php");
            // }
        }
    }

    public function get_product_cart()
    {
        $sId = session_id();
        $sql = "SELECT * FROM tbl_cart WHERE sId = '$sId'";

        $result = $this->db->select($sql);
        return $result;
    }

    public function update_quantity($quantity, $cartId)
    {
        $quantity = mysqli_real_escape_string($this->db->link, $quantity);
        $cartId = mysqli_real_escape_string($this->db->link, $cartId);

        $sql = "UPDATE tbl_cart SET 
                quantity = '$quantity' WHERE cartId = '$cartId'";
        $result = $this->db->update($sql);
        if($result){
            $alert = "<span class='addsuccess'>Cập nhật giỏ hàng thành công</span>";
            return $alert;
        } else {
            $alert = "<span class='adderror'>Có lỗi xảy ra,vui lòng thử lại</span>";
            return $alert;
        }
    }

    public function del_product_from_cart($cartid){
        $sql = "DELETE FROM tbl_cart WHERE cartId = '$cartid'";

        $result = $this->db->delete($sql);
        if ($result) {
            // header("Location:cart.php");
            $alert = "<span class='addsuccess'>Xóa sản phẩm thành công</span>";
            return $alert;
        } else {
            $alert = "<span class='adderror'>Có lỗi xảy ra,vui lòng thử lại</span>";
            return $alert;
        }
    }

    public function check_cart(){
        $sId = session_id();
        $sql = "SELECT * FROM tbl_cart WHERE sId = '$sId'";

        $result = $this->db->select($sql);
        return $result;
    }
}
