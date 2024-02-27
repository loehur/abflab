<?php
$t = $data['title'];
?>

<!-- Navbar start -->
<div class="fixed-top bg-white shadow-sm" style="max-height: 80px;">
	<div class="container px-0">
		<nav class="navbar navbar-light navbar-expand-xl">
			<a href="<?= $this->BASE_URL ?>Home" class="navbar-brand">
				<img src="<?= $this->ASSETS_URL ?>img/logo.png" class="img-logo-home px-2" alt="">
			</a>
			<button class="navbar-toggler py-2 px-3 me-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
				<span class="fa fa-bars"></span>
			</button>
			<div class="collapse navbar-collapse bg-white" id="navbarCollapse">
				<div class="navbar-nav mx-auto px-3">
					<?php
					$menu = $this->model("D_Group")->main();
					$produk = $this->model("D_Produk")->main();
					?>

					<?php foreach ($menu as $k => $m) { ?>
						<div class="nav-item dropdown">
							<a href="#" class="nav-link dropdown-toggle <?= (str_contains($t, $m['aktif'])) ? 'active' : '' ?>" data-bs-toggle="dropdown"><?= $m['name'] ?></a>
							<div class="dropdown-menu m-0 rounded-0">
								<?php foreach ($produk as $pk => $p) {
									if ($p['group'] == $k) { ?>
										<a href="<?= ($p['link'] == 0) ? $this->BASE_URL . 'Detail/index/' . $pk : $p['link'] ?>" class="dropdown-item"><?= $p['produk'] ?></a>
								<?php }
								} ?>
							</div>
						</div>
					<?php } ?>

					<a href="<?= $this->BASE_URL ?>About" class="nav-item nav-link">About</a>
				</div>
				<div class="d-flex m-3 me-0">
					<button type="button" class="btn btn-sm btn-light position-relative pt-2 me-1" data-bs-toggle="modal" data-bs-target="#exampleModal">
						<i class="fa-regular fa-circle-user"></i>
						<span id="user_name"></span>
					</button>
					<a href=" <?= $this->BASE_URL ?>Pesanan" class="btn btn-sm btn-light position-relative pt-2 me-1">
						<i class="fa-regular fa-rectangle-list"></i> Pesanan
					</a>
					<a href=" <?= $this->BASE_URL ?>Cart" class="btn btn-sm btn-light position-relative pt-2">
						<i class="fa-solid fa-cart-shopping"></i> Cart
						<div id="cart_count"></div>
					</a>
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