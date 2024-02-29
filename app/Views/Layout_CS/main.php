<?php
if (isset($data['parse'])) {
	$parse = $data['parse'];
} else {
	$parse = "";
}
?>
<?php include_once("head.php"); ?>

<body>
	<?php include_once("fix.php"); ?>
	<?php include_once("navbar.php"); ?>
	<div style="margin-top: 80px;" id="content"></div>
	<?php include_once("footer.php"); ?>
</body>

<!-- JavaScript Libraries -->
<script src="<?= $this->ASSETS_URL ?>js/jquery-3.7.0.min.js"></script>
<script src="<?= $this->ASSETS_URL ?>plugins/bootstrap-5.1/bootstrap.bundle.min.js"></script>

<script>
	$(document).ready(function() {
		content("<?= $parse ?>");
		cart_count();
		user_name();
		device();
	});

	function content(parse = "") {
		$("div#content").load('<?= $this->BASE_URL ?><?= $con ?>/content/' + parse);
	}

	function cart_count() {
		$("div#cart_count").load('<?= $this->BASE_URL ?>Load/cart');
	}

	function user_name() {
		$("span#user_name").load('<?= $this->BASE_URL ?>Load/account_cs');
	}

	function spinner(mode) {
		if (mode == 0) {
			$("div#spinner").addClass("d-none");
		} else {
			$("div#spinner").removeClass("d-none");
		}
	}

	function device() {
		if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
			$(".desktop").addClass("d-none");
		} else {
			$(".mobile").addClass("d-none");
		}
	}
</script>