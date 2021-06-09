<?php
include_once 'lib/session.php';
Session::init();

include_once 'lib/database.php';
include_once 'helpers/format.php';

spl_autoload_register(function ($className) {
	include_once 'classes/' . $className . '.php';
});

$db = new Database();
$fm = new Format();
$ct = new Cart();
$us = new User();
$cat = new Category();
$product = new Product();
?>

<?php
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: max-age=2592000");
?>

<!DOCTYPE HTML>

<head>
	<title>Store Website</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
	<link href="css/menu.css" rel="stylesheet" type="text/css" media="all" />
	<script src="js/jquerymain.js"></script>
	<script src="js/script.js" type="text/javascript"></script>
	<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="js/nav.js"></script>
	<script type="text/javascript" src="js/move-top.js"></script>
	<script type="text/javascript" src="js/easing.js"></script>
	<script type="text/javascript" src="js/nav-hover.js"></script>
	<link href='http://fonts.googleapis.com/css?family=Monda' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Doppio+One' rel='stylesheet' type='text/css'>
	<script type="text/javascript">
		$(document).ready(function($) {
			$('#dc_mega-menu-orange').dcMegaMenu({
				rowItems: '4',
				speed: 'fast',
				effect: 'fade'
			});
		});
	</script>
	<style>
		.addsuccess {
			font-size: 18px;
			color: green;
		}

		.adderror {
			font-size: 18px;
			color: red;
		}
	</style>
</head>

<body>
	<div class="wrap">
		<div class="header_top">
			<div class="logo">
				<a href="index.php"><img src="images/logo.png" alt="" /></a>
			</div>
			<div class="header_top_right">
				<div class="search_box">
					<form>
						<input type="text" value="Tìm kiếm sản phẩm" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Tìm kiếm sản phẩm';}"><input type="submit" value="Tìm kiếm">
					</form>
				</div>
				<div class="shopping_cart">
					<div class="cart">
						<a href="./cart.php" title="View my shopping cart" rel="nofollow">
							<span class="cart_title">Giỏ hàng</span>
							<span class="no_product">
								<?php
								$check_cart = $ct->check_cart();
								if($check_cart){
									$sum = Session::get("sum");
									echo $sum.' đ';
								}
								else{
									echo '(empty)';
								}
								?>
							</span>
						</a>
					</div>
				</div>
				<div class="login"><a href="login.php">Đăng nhập</a></div>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="menu">
			<ul id="dc_mega-menu-orange" class="dc_mm-orange">
				<li><a href="index.php">Trang chủ</a></li>
				<li><a href="products.php">Sản phẩm</a> </li>
				<li><a href="topbrands.php">Thương hiệu nổi bật</a></li>
				<li><a href="cart.php">Giỏ hàng</a></li>
				<li><a href="contact.php">Liên hệ</a> </li>
				<div class="clear"></div>
			</ul>
		</div>