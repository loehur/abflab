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
<div class="fixed-top shadow-sm bg-light" style="max-height: 80px;">
	<div class="container px-0">
		<nav class="navbar navbar-light navbar-expand-sm">
			<div class="container-fluid">
				<a href="<?= PC::BASE_URL ?>Home">
					<img style="height: 40px;" src="<?= PC::ASSETS_URL ?>img/logo.png" alt="">
				</a>
				<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar2" style="width: 270px;">
					<div class="offcanvas-header">
						<h1 class="p-0">Products</h1>
						<button type="button" class="btn-close text-reset me-2" data-bs-dismiss="offcanvas" aria-label="Close"></button>
					</div>
					<div class="offcanvas-body pe-2">
						<ul class="navbar-nav justify-content-end flex-grow-1 mb-2">
							<?php
							$menu = $this->model("D_Group")->main();
							$produk = $this->db(0)->get_where("produk", "en = 0 ORDER BY freq DESC");
							?>

							<?php foreach ($menu as $k => $m) { ?>
								<div class="nav-item dropdown">
									<a href="#" class="nav-link bg-light rounded text-dark px-2 mt-2 me-2 py-1 <?= (str_contains($t, $m['aktif'])) ? 'active' : '' ?>" data-bs-toggle="dropdown"><?= $m['name'] ?></a>
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
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">User Account</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form action="<?= PC::BASE_URL ?>Session/login" method="POST">
				<?php if (!isset($_SESSION['log'])) { ?>
					<div class="modal-body">
						<div class="form-floating mb-2">
							<input type="text" class="form-control" name="hp" required id="floatingInput11">
							<label for="floatingInput11">Nomor HP (08..)</label>
						</div>
						<div class="form-floating mb-2">
							<input type="password" class="form-control" name="pass" id="floatingInput12">
							<label for="floatingInput12">Password</label>
						</div>
					</div>
					<div class="modal-footer">
						<a href="<?= PC::BASE_URL ?>Daftar" class="me-auto"><button type="button" class="btn btn-outline-success">Register</button></a>
						<a href="<?= PC::BASE_URL ?>Set_Password"><button type="button" class="btn btn-sm">Lupa Password</button></a>
						<button type="submit" class="btn btn-primary">Login</button>
					</div>
				<?php } else { ?>
					<div class="modal-body">
						<div class="form-floating mb-2">
							Anda sedang Login sebagai <span class="text-success fw-bold"><?= $_SESSION['log']['name'] ?></span>.
						</div>
					</div>
					<div class="modal-footer">
						<a href="<?= PC::BASE_URL ?>Set_Password"><button type="button" class="btn btn-warning">Atur Password</button></a>
						<button type="submit" class="btn btn-danger">Logout</button>
					</div>
				<?php } ?>
			</form>
		</div>
	</div>
</div>

<!-- JavaScript Libraries -->
<script src="<?= PC::ASSETS_URL ?>js/jquery-3.7.0.min.js"></script>

<script>
	$("form").on("submit", function(e) {
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
					location.reload(true);
				} else {
					alert(res)
				}
			},
		});
	});
</script>