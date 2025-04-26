<?php
$t = $data['title'];
?>

<style>
	.fix_menu {
		position: fixed;
		left: 0;
		bottom: 0;
		width: 100%;
		text-align: center;
		background-color: white;
		z-index: 9999;
	}
</style>

<!-- Navbar start -->
<div class="fixed-top border-bottom shadow-sm bg-light" style="max-height: 80px;">
	<div class="container px-0 pt-2">
		<nav class="navbar navbar-light navbar-expand-sm">
			<div class="container-fluid">
				<div class="row mx-0">
					<div class="col p-0">
						<a href="<?= PC::BASE_URL ?>Home">
							<img style="height: 35px;" src="<?= PC::ASSETS_URL ?>img/logo.png" alt="">
						</a>
					</div>
				</div>
				<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar2" style="width: 270px;">
					<div class="offcanvas-header">
						<h1 class="p-0">Products</h1>
						<button type="button" class="btn-close text-reset me-2" data-bs-dismiss="offcanvas" aria-label="Close"></button>
					</div>
					<div class="offcanvas-body pe-2">
						<ul class="navbar-nav justify-content-end flex-grow-1 mb-2">
							<?php
							$menu = PC::Group;
							$produk = $this->db(0)->get_where("produk", "en = 0 ORDER BY freq DESC");
							?>

							<?php foreach ($menu as $k => $m) { ?>
								<div class="nav-item dropdown">
									<a href="#" class="nav-link shadow-sm text-success bg-light rounded px-2 mt-2 me-2 py-1 <?= (str_contains($t, $m['aktif'])) ? 'active' : '' ?>" data-bs-toggle="dropdown"><?= $m['name'] ?></a>
									<div class="dropdown-menu m-0 rounded-0 bg-light me-2">
										<?php foreach ($produk as $p) {
											if ($p['grup'] == $k) { ?>
												<a href="<?= ($p['link'] == 0) ? PC::BASE_URL . 'Detail/index/' . $p['produk_id'] : $p['link'] ?>" class="dropdown-item"><?= $p['produk'] ?></a>
										<?php }
										} ?>
									</div>
								</div>
							<?php } ?>
						</ul>
					</div>
				</div>
				<div class="row pe-2">
					<?php if (isset($_SESSION['log'])) { ?>
						<div class="col-auto px-1 desktop">
							<a href=" <?= PC::BASE_URL ?>Pesanan" class="btn btn-sm pt-2 me-1 bg-white shadow-sm">
								<i class="fa-regular fa-rectangle-list"></i> Pesanan
							</a>
						</div>
					<?php } ?>
					<div class="col-auto px-1">
						<a href=" <?= PC::BASE_URL ?>Cart" class="btn btn-sm bg-white pt-2 shadow-sm border-bottom position-relative">
							<i class="fa-solid fa-cart-shopping"></i> Cart
							<div id="cart_count"></div>
						</a>
					</div>
					<div class="col-auto px-1">
						<a href="#" class="btn btn-sm pt-2 text-primary bg-white shadow-sm border-bottom fw-bold" data-bs-toggle="modal" data-bs-target="#exampleModal">
							<span id="user_name"></span>
						</a>
					</div>
				</div>
			</div>
		</nav>
	</div>
</div>
<!-- Navbar End -->

<!-- Modal -->
<div class="modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="<?= PC::BASE_URL ?>Session/login" class="login" method="POST">
				<?php if (!isset($_SESSION['log'])) { ?>
					<div class="modal-body">
						<div class="col px-1 mb-3" style="min-width: 200px;">
							<label class="mb-1 ms-1"><small>Nomor HP (08..)</small></label>
							<input type="text" class="form-control py-2 shadow-none rounded-3" name="hp" required>
						</div>
						<div class="col px-1 mb-1" style="min-width: 200px;">
							<label class="mb-1 ms-1"><small>Password</small></label>
							<div class="input-group">
								<input id="pwd" type="password" class="form-control py-2 shadow-none rounded-start-3" name="pass" required>
								<span class="input-group-text bg-white" style="cursor: pointer;" id="eye"><i class="fa-solid fa-eye float-end" id="togglePassword"></i></span>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<a href="<?= PC::BASE_URL ?>Daftar" class="me-auto"><button type="button" class="btn btn-outline-success border-0">Register</button></a>
						<a href="<?= PC::BASE_URL ?>Set_Password"><button type="button" class="btn btn-sm">Lupa Password</button></a>
						<button type="submit" class="btn btn-primary">Login</button>
					</div>
				<?php } else { ?>
					<div class="modal-body">
						<div class="form-floating mb-3">
							Login sebagai <span class="text-success fw-bold"><?= $_SESSION['log']['name'] ?></span>.
						</div>

						<a href="<?= PC::BASE_URL ?>Afiliator"><button type="button" class="btn btn-sm btn-primary me-1">Afiliator</button></a>
						<div class="float-end">
							<a href="<?= PC::BASE_URL ?>Set_Password"><button type="button" class="btn btn-sm btn-warning me-1">Atur Password</button></a>
							<button type="submit" class="btn btn-sm btn-danger">Logout</button>
						</div>
					</div>
				<?php } ?>
			</form>
		</div>
	</div>
</div>

<!-- JavaScript Libraries -->
<script src="<?= PC::ASSETS_URL ?>js/jquery-3.7.0.min.js"></script>

<script>
	$("form.login").on("submit", function(e) {
		e.preventDefault();
		$.ajax({
			url: $(this).attr('action'),
			data: $(this).serialize(),
			type: $(this).attr("method"),
			success: function(res) {
				if (res == 1) {
					alert("Login Success!");
					location.reload(true);
				} else if (res == 2) {
					alert("Logout Success!");
					location.href = "<?= PC::BASE_URL ?>Home";
				} else {
					alert(res)
				}
			},
		});
	});

	function show() {
		var p = document.getElementById('pwd');
		p.setAttribute('type', 'text');
	}

	function hide() {
		var p = document.getElementById('pwd');
		p.setAttribute('type', 'password');
	}

	var pwShown = 0;

	document.getElementById("eye").addEventListener("click", function() {
		if (pwShown == 0) {
			pwShown = 1;
			show();
		} else {
			pwShown = 0;
			hide();
		}
	}, false);
</script>