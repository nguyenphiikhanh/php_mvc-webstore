<?php
include 'inc/header.php';
include 'inc/slider.php';
?>

<div class="main">
	<div class="content">
		<div class="content_top">
			<div class="heading">
				<h3>Sản phẩm nổi bật</h3>
			</div>
			<div class="clear"></div>
		</div>
		<div class="section group">
			<?php $pb_features = $product->getProduct_featured();
			if ($pb_features) {
				while ($result = $pb_features->fetch_assoc()) {
			?>
					<div class="grid_1_of_4 images_1_of_4">
						<a href="details.php"><img src="admin/uploads/<?php echo $result['image'] ?>" alt="" /></a>
						<h2><?php echo $result['productName'] ?> </h2>
						<p><?php echo $fm->textShorten($result['product_desc'], 50) ?></p>
						<p><span class="price"><?php echo $result['price'] . " VNĐ" ?></span></p>
						<div class="button"><span><a href="details.php?proid=<?php echo $result['productId'] ?>" class="details">Xem chi tiết</a></span></div>
					</div>
			<?php
				}
			}
			?>
		</div>
		<div class="content_bottom">
			<div class="heading">
				<h3>Sản phẩm mới</h3>
			</div>
			<div class="clear"></div>
		</div>
		<div class="section group">
			<?php $pb_new = $product->getProduct_new();
			if ($pb_new) {
				while ($resultNew = $pb_new->fetch_assoc()) {
			?>
					<div class="grid_1_of_4 images_1_of_4">
						<a href="details.php"><img src="admin/uploads/<?php echo $resultNew['image'] ?>" alt="" /></a>
						<h2><?php echo $resultNew['productName'] ?> </h2>
						<p><?php echo $fm->textShorten($resultNew['product_desc'], 50) ?></p>
						<p><span class="price"><?php echo $resultNew['price'] . " VNĐ" ?></span></p>
						<div class="button"><span><a href="details.php?proid=<?php echo $resultNew['productId'] ?>" class="details">Xem chi tiết</a></span></div>
					</div>
			<?php
				}
			}
			?>
		</div>
	</div>
</div>

<?php
include 'inc/footer.php';
?>