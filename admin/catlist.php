<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php';
include '../classes/category.php';

$cat = new Category();
if (isset($_GET['delid'])) {
    $id = $_GET['delid'];
	$delete_cat = $cat->del_category($id);
}
?>
<div class="grid_10">
	<div class="box round first grid">
		<h2>Category List</h2>
		<div class="block">
		<?php
            if (isset($delete_cat)) {
                echo $delete_cat;
            }
            ?>
			<table class="data display datatable" id="example">
				<thead>
					<tr>
						<th>Serial No.</th>
						<th>Category Name</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$show_cate = $cat->showCategories();
					if ($show_cate) {
						$i = 0;
						while ($result =$show_cate->fetch_assoc()) {
							$i++;

					?>	
							<tr class="odd gradeX">
								<td><?php echo $i; ?></td>
								<td><?php echo $result['catName']; ?></td>
								<td><a href="catedit.php?catid=<?php echo $result['catId']; ?>">Sửa</a> || <a onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này không?')" 
								href="?delid=<?php echo $result['catId']; ?>">Xóa</a></td>
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