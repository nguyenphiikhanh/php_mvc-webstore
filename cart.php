<?php
include 'inc/header.php';
// include 'inc/slider.php';

if (isset($_GET['cartid'])) {
	$id = $_GET['cartid'];
	$del_product_fr_cat = $ct->del_product_from_cart($id);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
	$quantity = $_POST['quantity'];
	$cartId = $_POST['cartId'];
	$update_quantity = $ct->update_quantity($quantity, $cartId);
}

if(!isset($_GET['id'])){
	echo "<meta http-equiv='refresh' content='0;URL=?id=live'>";
}
?>

<div class="main">
	<div class="content">
		<div class="cartoption">
			<div class="cartpage">
				<h2>Giỏ hàng</h2>
				<?php
				if (isset($update_quantity)) {
					echo $update_quantity;
				}
				?>

				<?php
				if (isset($del_product_fr_cat)) {
					echo $del_product_fr_cat;
				}
				?>
				<table class="tblone">
					<tr>
						<th width="20%">Tên sản phẩm</th>
						<th width="10%">Hình ảnh</th>
						<th width="15%">Đơn giá</th>
						<th width="25%">Số lượng</th>
						<th width="20%">Tổng giá</th>
						<th width="10%">Hành động</th>
					</tr>
					<?php
					$get_product_cart = $ct->get_product_cart();
					if ($get_product_cart) {
						$sub_total = 0;
						while ($result = $get_product_cart->fetch_assoc()) {

					?>
							<tr>
								<td><?php echo $result['productName'] ?></td>
								<td><img src="admin/uploads/<?php echo $result['image'] ?>" alt="" /></td>
								<td><?php echo $result['price'] . " VNĐ" ?></td>
								<td>
									<form action="" method="post">
										<input type="hidden" name="cartId" value="<?php echo $result['cartId'] ?>" />
										<input type="number" name="quantity" min="1" value="<?php echo $result['quantity'] ?>" />
										<input type="submit" name="submit" value="Update" />
									</form>
								</td>
								<td><?php
									$total = $result['price'] * $result['quantity'];
									echo $total . " VNĐ";
									?></td>
								<td><a onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này không?')" href="?cartid=<?php echo $result['cartId'] ?>">Xóa</a></td>
							</tr>
					<?php
							$sub_total += $total;
						}
					}
					?>

				</table>
				<?php
				$check_cart = $ct->check_cart();
				if ($check_cart) {
					
				?>
				<table style="float:right;text-align:left;" width="40%">
					<tr>
						<th>Tổng giá </th>
						<td><?php echo $sub_total . " VNĐ";
							Session::set("sum", $sub_total);
							?></td>
					</tr>
					<tr>
						<th>VAT(1%) : </th>
						<td><?php $vat = $sub_total * 0.01;
							echo $vat . " VNĐ" ?></td>
					</tr>
					<tr>
						<th>Tổng cộng :</th>
						<td><?php $grand = $sub_total + $vat;
							echo $grand . " VNĐ" ?></td>
					</tr>
				</table>
				<?php
				}
				else {
					echo 'Giỏ hàng trống,vui lòng chọn sản phẩm';
				}
				?>
			</div>
			<div class="shopping">
				<div class="shopleft">
					<a href="index.php"> <img src="images/shop.png" alt="" /></a>
				</div>
				<div class="shopright">
					<a href="login.php"> <img src="images/check.png" alt="" /></a>
				</div>
			</div>
		</div>
		<div class="clear"></div>
	</div>
</div>
<?php
include 'inc/footer.php';
?>