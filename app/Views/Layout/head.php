<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<title><?= $data['title'] ?> | <?= PC::APP_NAME ?></title>
	<link rel="icon" type="image/x-icon" href="<?= PC::ASSETS_URL ?>img/favicon.png" />

	<!-- Main -->
	<link rel="stylesheet" type="text/css" href="<?= PC::ASSETS_URL ?>css/styles.css" />
	<link rel="stylesheet" type="text/css" href="<?= PC::ASSETS_URL ?>plugins/bootstrap-5.1/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="<?= PC::ASSETS_URL ?>plugins/fontawesome-free-6.4.0-web/css/all.css">
	<link rel="stylesheet" type="text/css" href="<?= PC::ASSETS_URL ?>css/main.css">

	<!-- Icon -->
	<script src="<?= PC::ASSETS_URL ?>js/feather.min.js"></script>
	<link href="<?= PC::ASSETS_URL ?>css/bootstrap-icons.css" rel="stylesheet">
</head>

<style>
	input:focus,
	.form-select:focus,
	.btn:focus,
	select:focus,
	textarea,
	input.form-control:focus {
		outline: none !important;
		outline-width: 0 !important;
		box-shadow: none;
		-moz-box-shadow: none;
		-webkit-box-shadow: none;
	}
</style>