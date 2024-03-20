<?php
$t = $data['title'];
?>

<!-- Navbar start -->
<div class="fixed-top shadow-sm bg-white" style="max-height: 80px;">
	<div class="container px-0">
		<nav class="navbar navbar-light navbar-expand-xl">
			<div class="container-fluid">
				<a href="<?= PC::BASE_URL ?>Home" class="navbar-brand">
					<img src="<?= PC::ASSETS_URL ?>img/logo.png" class="img-logo-home px-2" alt="">
				</a>
				<div class="navbar-toggler border-0" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar2">
					<span class="fa fa-bars"></span>
				</div>
				<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar2" aria-labelledby="offcanvasNavbar2Label">
					<div class="offcanvas-header">
						<a href="<?= PC::BASE_URL ?>Home" class="navbar-brand">
							<img src="<?= PC::ASSETS_URL ?>img/logo.png" class="img-logo-home px-2" alt="">
						</a>
						<button type="button" class="btn-close text-reset me-2" data-bs-dismiss="offcanvas" aria-label="Close"></button>
					</div>
					<div class="offcanvas-body">
						<ul class="navbar-nav justify-content-end flex-grow-1 mb-2">
							<?php
							$menu = $this->model("D_Group")->main();
							$produk = $this->db(0)->get("produk");
							?>

							<?php foreach ($menu as $k => $m) { ?>
								<div class="nav-item dropdown">
									<a href="#" class="nav-link shadow-sm bg-white text-dark border-top px-2 mt-2 me-2 py-1 <?= (str_contains($t, $m['aktif'])) ? 'active' : '' ?>" data-bs-toggle="dropdown"><?= $m['name'] ?></a>
									<div class="dropdown-menu m-0 rounded-0">
										<?php foreach ($produk as $p) {
											if ($p['grup'] == $k) { ?>
												<a href="<?= ($p['link'] == 0) ? PC::BASE_URL . 'Detail/index/' . $p['produk_id'] : $p['link'] ?>" class="dropdown-item"><?= $p['produk'] ?></a>
										<?php }
										} ?>
									</div>
								</div>
							<?php } ?>
						</ul>
						<div class="mt-2">
							<?php if (isset($_SESSION['log'])) { ?>
								<a href=" <?= PC::BASE_URL ?>Pesanan" class="btn btn-sm border position-relative pt-2 me-1 bg-white">
									<i class="fa-regular fa-rectangle-list"></i> Pesanan
								</a>
							<?php } ?>
							<a href="#" class="btn btn-sm border position-relative pt-2 me-1 bg-white text-success fw-bold" data-bs-toggle="modal" data-bs-target="#exampleModal">
								<i class="fa-regular fa-circle-user"></i>
								<span id="user_name"></span>
							</a>
							<a href=" <?= PC::BASE_URL ?>Cart" class="btn btn-sm border bg-white position-relative pt-2">
								<i class="fa-solid fa-cart-shopping"></i> Cart
								<div id="cart_count"></div>
							</a>
						</div>
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
							<label for="floatingInput12">Password <small>(Kosongkan bila belum pernah setup)</small></label>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
						<a href="<?= PC::BASE_URL ?>Set_Password"><button type="button" class="btn btn-warning">Lupa Password</button></a>
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
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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