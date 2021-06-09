<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php include '../classes/brand.php'; ?>
<?php include '../classes/category.php';
include '../classes/product.php';

$pd = new Product();

if (isset($_GET['delproduct'])) {
    $id = $_GET['delproduct'];
	$delete_product = $pd->del_product($id);
}
?>

?>
<div class="grid_10">
	<div class="box round first grid">
		<h2>Post List</h2>
		<div class="block">
		<?php 
		if(isset($delete_product)){
			echo $delete_product;
		}
		?>
			<table class="data display datatable" id="example">
				<thead>
					<tr>
						<th>ID sản phẩm</th>
						<th>Tên sản phẩm</th>
						<th>Ảnh</th>
						<th>Danh mục</th>
						<th>Thương hiệu</th>
						<th>Loại</th>
						<th>Giá</th>
						<th>Hành động</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$pdList = $pd->show_products();
					if ($pdList) {
						while ($result = $pdList->fetch_assoc()) {
					?>
							<tr class="odd gradeX">
								<td><?php echo $result['productId']; ?></td>
								<td><?php echo $result['productName']; ?></td>
								<td><img src="uploads/<?php echo $result['image']; ?>" width="50" height="50"></td>
								<td><?php echo $result['catId']; ?></td>
								<td><?php echo $result['brandId']; ?></td>
								<td><?php if($result['type'] == 0){echo 'Nổi bật';} else {echo 'Thường';}; ?></td>
								<td class="center"><?php echo $result['price']; ?></td>
								<td><a href="productedit.php?productid=<?php echo $result['productId'] ?>">Sửa</a> || <a onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?')" 
								href="?delproduct=<?php echo $result['productId']; ?>">Xóa</a></td>
							</tr>
					<?php
						}
					}
					?>
				</tbody>
			</table>

		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		setupLeftMenu();
		$('.datatable').dataTable();
		setSidebarHeight();
	});
</script>
<?php include 'inc/footer.php'; ?>