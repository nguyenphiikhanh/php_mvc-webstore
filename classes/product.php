<?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../lib/database.php');
include_once($filepath . '/../helpers/format.php');
?>

<?php

class Product
{

    private $db;
    private $fm;

    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }


    public function insert_product($data, $files)
    {

        $productName = mysqli_real_escape_string($this->db->link, $data['productName']);
        $category = mysqli_real_escape_string($this->db->link, $data['category']);
        $brand = mysqli_real_escape_string($this->db->link, $data['brand']);
        $product_desc = mysqli_real_escape_string($this->db->link, $data['product_desc']);
        $price = mysqli_real_escape_string($this->db->link, $data['price']);
        $type = mysqli_real_escape_string($this->db->link, $data['type']);

        //kiểm tra và up ảnh vào folder 'uploads'
        $permited = array('jpg', 'jpeg', 'png', 'gif');
        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_temp = $_FILES['image']['tmp_name'];

        $div = explode('.', $file_name);
        $file_ext = strtolower(end($div));
        $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
        $uploaded_image = "uploads/" . $unique_image;

        if ($productName == "" || $category == "" || $brand == "" || $product_desc == "" || $price == "" || $type == "" || $file_name == "") {
            $alert = "<span class='adderror'>Các trường không được để trống</span>";
            return $alert;
        } else {
            move_uploaded_file($file_temp, $uploaded_image);
            $sql = "INSERT INTO tbl_product(productName,brandId,catId,product_desc,price,type,image) VALUES('$productName',
                '$brand','$category','$product_desc','$price','$type','$unique_image')";
            $result = $this->db->insert($sql);
            if ($result) {
                $alert = "<span class='addsuccess'>Thêm sản phẩm thành công</span>";
                return $alert;
            } else {
                $alert = "<span class='adderror'>Thêm sản phẩm không thành công,vui lòng thử lại</span>";
                return $alert;
            }
        }
    }

    public function show_products()
    {
        $sql = "SELECT productId,productName,image,catId,brandId,type,price FROM tbl_product ORDER BY productId DESC";
        $result = $this->db->select($sql);
        return $result;
    }

    public function getProductById($id)
    {
        $sql = "SELECT * FROM tbl_product WHERE productId = '$id'";
        $result = $this->db->select($sql);
        return $result;
    }

    public function update_product($data, $files, $id)
    {
        $productName = mysqli_real_escape_string($this->db->link, $data['productName']);
        $category = mysqli_real_escape_string($this->db->link, $data['category']);
        $brand = mysqli_real_escape_string($this->db->link, $data['brand']);
        $product_desc = mysqli_real_escape_string($this->db->link, $data['product_desc']);
        $price = mysqli_real_escape_string($this->db->link, $data['price']);
        $type = mysqli_real_escape_string($this->db->link, $data['type']);

        //kiểm tra và up ảnh vào folder 'uploads'
        $permited = array('jpg', 'jpeg', 'png', 'gif');
        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_temp = $_FILES['image']['tmp_name'];

        $div = explode('.', $file_name);
        $file_ext = strtolower(end($div));
        $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
        $uploaded_image = "uploads/" . $unique_image;

        if ($productName == "" || $category == "" || $brand == "" || $product_desc == "" || $price == "" || $type == "") {
            $alert = "<span class='adderror'>Các trường không được để trống</span>";
            return $alert;
        } else {
            if (!empty($file_name)) { // nếu user upload ảnh
                if ($file_size > 102400) { //check kích thước tập tin
                    $alert = "<span class='adderror'>Tệp tin không được vượt quá 10Mb</span>";
                    return $alert;
                } elseif (in_array($file_ext, $permited) === false) { //check định dạng ảnh
                    $alert = "<span class='adderror'>Chỉ có thể tải lên tệp tin " . implode(", ", $permited) . "</span>";
                    return $alert;
                }
                $query = "SELECT image FROM tbl_product WHERE productId = '$id'"; //chọn ra ảnh cũ để xóa đi
                $imageToDel = $this->db->update($query);
                $resultImg = $imageToDel->fetch_assoc();

                move_uploaded_file($file_temp, $uploaded_image);
                $sql = "UPDATE tbl_product SET 
                productName = '$productName',
                catId = '$category',
                brandId = '$brand',
                product_desc = '$product_desc',
                price = '$price',
                image = '$unique_image',
                type = '$type' WHERE productId = '$id'";

                unlink("uploads/" . $resultImg['image']); // xóa ảnh cũ
            } else { // user không upload ảnh
                $sql = "UPDATE tbl_product SET 
                productName = '$productName',
                catId = '$category',
                brandId = '$brand',
                product_desc = '$product_desc',
                price = '$price',
                type = '$type' WHERE productId = '$id'";
            }
        }
        $result = $this->db->update($sql);
        if ($result) {
            $alert = "<span class='addsuccess'>Sửa sản phẩm thành công</span>";
            return $alert;
        } else {
            $alert = "<span class='adderror'>Có lỗi xảy ra,vui lòng thử lại</span>";
            return $alert;
        }
    }

    public function del_product($id)
    {
        $sql = "DELETE FROM tbl_product WHERE productId = '$id'";
        $result = $this->db->delete($sql);
        if ($result) {
            $query = "SELECT image FROM tbl_product WHERE productId = '$id'"; //chọn ra ảnh cũ để xóa đi
            $imageToDel = $this->db->update($query);
            $resultImg = $imageToDel->fetch_assoc();
            unlink("uploads/" . $resultImg['image']);  // xóa ảnh cũ

            $alert = "<span class='addsuccess'>Xóa sản phẩm thành công</span>";
            return $alert;
        } else {
            $alert = "<span class='adderror'>Có lỗi xảy ra,vui lòng thử lại</span>";
            return $alert;
        }
    }

    public function getProduct_featured()
    {
        $sql = "SELECT * FROM tbl_product WHERE type = 0";
        $result = $this->db->select($sql);
        return $result;
    }

    public function getProduct_new()
    {
        $sql = "SELECT * FROM tbl_product ORDER BY productId desc LIMIT 4";
        $result = $this->db->select($sql);
        return $result;
    }

    public function get_details($id)
    {
        $query = "SELECT tbl_product.*,tbl_category.catName,tbl_brand.brandName
        from tbl_product INNER JOIN tbl_category on tbl_category.catId = tbl_product.catId
        INNER JOIN tbl_brand on tbl_product.brandId = tbl_brand.brandId
        WHERE tbl_product.productId = '$id'";

        $result = $this->db->select($query);
        return $result;
    }

    public function getLastestDell(){
        $query = "SELECT tbl_product WHERE brandId = '5'";
    }
}
