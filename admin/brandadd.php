<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';
include "../classes/brand.php";

$brand = new Brand();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$brandName = $_POST['brandName'];

	$insert_brand = $brand->insert_brand($brandName);
}
?>
        <div class="grid_10">
            <div class="box round first grid">
                <h2>Thêm thương hiệu</h2>
               <div class="block copyblock"> 
               <?php 
                    if(isset($insert_brand)){
                        echo $insert_brand;
                    }
                ?>
                 <form action="brandadd.php" method="post">
                    <table class="form">					
                        <tr>
                            <td>
                                <input type="text" name="brandName" placeholder="Tên thương hiệu" class="medium" />
                            </td>
                        </tr>
						<tr> 
                            <td>
                                <input type="submit" name="submit" Value="Thêm thương hiệu" />
                            </td>
                        </tr>
                    </table>
                    </form>
                </div>
            </div>
        </div>
<?php include 'inc/footer.php';?>