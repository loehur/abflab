<?php
if (isset($data['parse'])) {
	$parse = $data['parse'];
} else {
	$parse = null;
}
?>
<?php include_once("head.php"); ?>

<?php
//SESSION DATA
if (isset($_SESSION['log'])) {
	if (isset($_SESSION['new_user'])) {
		if ($_SESSION['new_user'] == true) {
			$count = $this->db(0)->count_where("order_step", "customer_id = '" . $_SESSION['log']['customer_id'] . "' AND order_status <> 0 AND order_status <> 4");
			if ($count > 0) {
				$_SESSION['new_user'] = false;
			} else {
				$_SESSION['new_user'] = true;
			}
		}
	} else {
		$count = $this->db(0)->count_where("order_step", "customer_id = '" . $_SESSION['log']['customer_id'] . "' AND order_status <> 0 AND order_status <> 4");
		if ($count > 0) {
			$_SESSION['new_user'] = false;
		} else {
			$_SESSION['new_user'] = true;
		}
	}
} else {
	$_SESSION['new_user'] = true;
}

?>

<body>
	<?php include_once("fix.php"); ?>
	<?php include_once("navbar.php"); ?>
	<div class="desktop" style="margin-top: 10px;padding-bottom:10px;"></div>
	<div style="margin-top: 70px;padding-bottom:40px" id="content"></div>
	<?php include_once("footer.php"); ?>
</body>

<!-- JavaScript Libraries -->
<script src="<?= PC::ASSETS_URL ?>js/jquery-3.7.0.min.js"></script>
<script src="<?= PC::ASSETS_URL ?>plugins/bootstrap-5.1/bootstrap.bundle.min.js"></script>

<script>
	$(document).ready(function() {
		content("<?= $parse ?>");
		cart_count();
		user_name();
		device();

		<?php if (!isset($_SESSION['log']) && !isset($_SESSION['tools']['location'])) { ?>
			getLocation();
		<?php } ?>

	});

	function content(parse = "") {
		$("div#content").load('<?= PC::BASE_URL ?><?= $con ?>/content/' + parse);
	}

	function cart_count() {
		$("div#cart_count").load('<?= PC::BASE_URL ?>Load/cart');
	}

	function user_name() {
		$("span#user_name").load('<?= PC::BASE_URL ?>Load/account');
	}

	function spinner(mode) {
		if (mode == 0) {
			$("div#spinner").addClass("d-none");
		} else {
			$("div#spinner").removeClass("d-none");
		}
	}

	function device() {
		let mobile = false;

		if (window.screen.width < 500) {
			mobile = true;
		}

		if (mobile == true) {
			$(".desktop").addClass("d-none");
		} else {
			$(".mobile").addClass("d-none");
		}
	}

	function getLocation() {
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(showPosition);
		}
	}

	function showPosition(position) {
		var glat = position.coords.latitude;
		var glong = position.coords.longitude;

		$.post("<?= PC::BASE_URL ?>Session/set_loc", {
			lat: glat,
			long: glong
		});
	}
</script>