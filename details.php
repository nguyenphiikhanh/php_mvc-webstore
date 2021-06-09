<?php
include 'inc/header.php';
// include 'inc/slider.php';

if (!isset($_GET['proid']) || $_GET['proid'] == null) {
	echo "<script>window.location='404.php'</script>";
} else {
	$id = $_GET['proid'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
	$quantity = $_POST['quantity'];
	$addToCart = $ct->add_to_cart($quantity,$id);
}
?>

<div class="main">
	<div class="content">
		<div class="section group">
			<?php
			$get_details = 	$product->get_details($id);
			if ($get_details) {
				while ($result_details = $get_details->fetch_assoc()) {

			?>
					<div class="cont-desc span_1_of_2">
						<div class="grid images_3_of_2">
							<img src="admin/uploads/<?php echo $result_details['image'] ?>" alt="" />
						</div>
						<div class="desc span_3_of_2">
							<h2><?php echo $result_details['productName'] ?></h2>
							<p><?php echo $fm->textShorten($result_details['product_desc'], 200) ?></p>
							<div class="price">
								<p>Giá: <span><?php echo $result_details['price'] . ' VNĐ' ?></span></p>
								<p>Danh mục: <span><?php echo $result_details['catName'] ?></span></p>
								<p>Thương hiệu:<span><?php echo $result_details['brandName'] ?></span></p>
							</div>
							<div class="add-cart">
								<form action="" method="post">
									<input type="number" class="buyfield" name="quantity" value="1" min="1" />
									<input type="submit" class="buysubmit" name="submit" value="Mua ngay" />	
								</form>
							</div>
						</div>
						<div class="product-desc">
							<h2>Mô tả sản phẩm</h2>
							<p><?php echo $result_details['product_desc'] ?></p>
						</div>

					</div>
			<?php
				}
			}
			?>
			<div class="rightsidebar span_3_of_1">
				<h2>Danh mục sản phẩm</h2>
				<ul>

					<li><a href="productbycat.php">Mobile Phones</a></li>

				</ul>

			</div>
		</div>
	</div>
</div>
<?php
include 'inc/footer.php';
?>