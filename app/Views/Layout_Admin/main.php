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
	<input id="parse_1" type="hidden" />
	<input id="parse_2" type="hidden" />
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
	});

	function content(parse = "", parse2 = "") {
		if (parse2 == "") {
			$("div#content").load('<?= PC::BASE_URL ?><?= $con ?>/content/' + parse);
		} else {
			$("div#content").load('<?= PC::BASE_URL ?><?= $con ?>/content/' + parse + '/' + parse2);
		}

		$("input#parse_1").val(parse);
		$("input#parse_2").val(parse2);
	}

	function reload_content() {
		let parse_1 = $("input#parse_1").val();
		let parse_2 = $("input#parse_2").val();
		content(parse_1, parse_2)
	}

	function cart_count() {
		$("div#cart_count").load('<?= PC::BASE_URL ?>Load/cart');
	}

	function user_name() {
		$("span#user_name").load('<?= PC::BASE_URL ?>Load/account_admin');
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
</script>