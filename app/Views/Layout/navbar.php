<?php
$t = $data['title'];
?>

<!-- Navbar start -->
<div class="fixed-top bg-white shadow-sm" style="max-height: 80px;">
	<div class="container px-0">
		<nav class="navbar navbar-light navbar-expand-xl">
			<div class="container-fluid">
				<a href="<?= $this->BASE_URL ?>Home" class="navbar-brand">
					<img src="<?= $this->ASSETS_URL ?>img/logo.png" class="img-logo-home px-2" alt="">
				</a>
				<div class="navbar-toggler border-0" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar2">
					<span class="fa fa-bars"></span>
				</div>
				<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar2" aria-labelledby="offcanvasNavbar2Label">
					<div class="offcanvas-header">
						<a href="<?= $this->BASE_URL ?>Home" class="navbar-brand">
							<img src="<?= $this->ASSETS_URL ?>img/logo.png" class="img-logo-home px-2" alt="">
						</a>
						<button type="button" class="btn-close text-reset me-2" data-bs-dismiss="offcanvas" aria-label="Close"></button>
					</div>
					<div class="offcanvas-body">
						<ul class="navbar-nav justify-content-end flex-grow-1 mb-2">
							<?php
							$menu = $this->model("D_Group")->main();
							$produk = $this->model("D_Produk")->main();
							?>

							<?php foreach ($menu as $k => $m) { ?>
								<div class="nav-item dropdown">
									<a href="#" class="nav-link shadow-sm border-top px-2 mt-2 me-2 py-1 <?= (str_contains($t, $m['aktif'])) ? 'active' : '' ?>" data-bs-toggle="dropdown"><?= $m['name'] ?></a>
									<div class="dropdown-menu m-0 rounded-0">
										<?php foreach ($produk as $pk => $p) {
											if ($p['group'] == $k) { ?>
												<a href="<?= ($p['link'] == 0) ? $this->BASE_URL . 'Detail/index/' . $pk : $p['link'] ?>" class="dropdown-item"><?= $p['produk'] ?></a>
										<?php }
										} ?>
									</div>
								</div>
							<?php } ?>
						</ul>
						<div class="mt-2">
							<button type="button" class="btn btn-sm border position-relative py-2 me-1 text-secondary" data-bs-toggle="modal" data-bs-target="#exampleModal">
								<i class="fa-regular fa-circle-user"></i>
								<span id="user_name"></span>
							</button>
							<a href=" <?= $this->BASE_URL ?>Pesanan" class="btn btn-sm border position-relative pt-2 me-1 text-secondary">
								<i class="fa-regular fa-rectangle-list"></i> Pesanan
							</a>
							<a href=" <?= $this->BASE_URL ?>Cart" class="btn btn-sm border position-relative pt-2 text-secondary">
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
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Login</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form action="<?= $this->BASE_URL ?>Session/login" method="POST">
				<div class="modal-body">
					<div class="form-floating mb-2">
						<input type="text" class="form-control" name="hp" required id="floatingInput">
						<label for="floatingInput">Nomor HP (08..)</label>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Login</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- JavaScript Libraries -->
<script src="<?= $this->ASSETS_URL ?>js/jquery-3.7.0.min.js"></script>

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
				} else {
					alert(res)
				}
			},
		});
	});
</script>