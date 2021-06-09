<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php include '../classes/brand.php'; ?>
<?php include '../classes/category.php';
include '../classes/product.php';

$pd = new Product();
if (!isset($_GET['productid']) || $_GET['productid'] == null) {
    echo "<script>window.location='productlist.php'</script>";
} else {
    $id = $_GET['productid'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $update_pd = $pd->update_product($_POST, $_FILES, $id);
}
?>


<div class="grid_10">
    <div class="box round first grid">
        <h2>Chỉnh sửa sản phẩm</h2>
        <div class="block">
            <?php
            if (isset($update_pd)) {
                echo $update_pd;
            }
            ?>
            <?php
            $get_product = $pd->getProductById($id);
            if ($get_product) {
                while ($resultpd = $get_product->fetch_assoc()) {


            ?>
                    <form action="" method="post" enctype="multipart/form-data">
                        <table class="form">

                            <tr>
                                <td>
                                    <label>Tên sản phẩm</label>
                                </td>
                                <td>
                                    <input name="productName" type="text" value="<?php echo $resultpd['productName'] ?>" class="medium" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Danh mục</label>
                                </td>
                                <td>
                                    <select id="select" name="category">
                                        <option>----Chọn danh mục----</option>
                                        <?php
                                        $cat = new Category();
                                        $catList = $cat->showCategories();
                                        if ($catList) {
                                            while ($result = $catList->fetch_assoc()) {
                                        ?>
                                                <option
                                                <?php if($result['catId']== $resultpd['catId']){ echo 'selected';} ?>
                                                
                                                 value="<?php echo $result['catId'] ?>"><?php echo $result['catName'] ?></option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Thương hiệu</label>
                                </td>
                                <td>
                                    <select id="select" name="brand">
                                        <option>----Chọn thương hiệu----</option>
                                        <?php
                                        $brand = new Brand();
                                        $brandList = $brand->showBrand();
                                        if ($catList) {
                                            while ($result = $brandList->fetch_assoc()) {
                                        ?>
                                                <option
                                                <?php if($result['brandId'] == $resultpd['brandId']) { echo 'selected';}?>

                                                 value="<?php echo $result['brandId'] ?>"><?php echo $result['brandName'] ?></option>
                                        <?php
                                            }
                                        }
                                        ?>

                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td style="vertical-align: top; padding-top: 9px;">
                                    <label>Mô tả sản phẩm</label>
                                </td>
                                <td>
                                    <textarea name="product_desc" class="tinymce"><?php echo $resultpd['product_desc'] ?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Giá</label>
                                </td>
                                <td>
                                    <input name="price" type="text" value="<?php echo $resultpd['price'] ?>" class="medium" />
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <label>Hình ảnh</label>
                                </td>
                                <td>
                                    <img src="uploads/<?php echo $resultpd['image']; ?>" width="50" height="50"><br>
                                    <input name="image" type="file" />
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <label>Loại sản phẩm</label>
                                </td>
                                <td>
                                    <select id="select" name="type">
                                        <option>--Loại--</option>
                                        <?php if ($resultpd['type'] == '0') {

                                        ?>
                                            <option selected value="0">Nổi bật</option>
                                            <option value="1">Thường</option>
                                        <?php } else {
                                        ?>
                                            <option  value="0">Nổi bật</option>
                                            <option selected value="1">Thường</option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td></td>
                                <td>
                                    <input type="submit" name="submit" Value="Lưu" />
                                </td>
                            </tr>
                        </table>
                    </form>
            <?php
                }
            }
            ?>
        </div>
    </div>
</div>
<!-- Load TinyMCE -->
<script src="js/tiny-mce/jquery.tinymce.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function() {
        setupTinyMCE();
        setDatePicker('date-picker');
        $('input[type="checkbox"]').fancybutton();
        $('input[type="radio"]').fancybutton();
    });
</script>
<!-- Load TinyMCE -->
<?php include 'inc/footer.php'; ?>