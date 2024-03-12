<?php
$t = $data['title'];
?>

<!-- Navbar start -->
<div class="fixed-top shadow-sm" style="max-height: 80px; background-color:aliceblue">
	<div class="container px-0">
		<nav class="navbar navbar-light navbar-expand-xl">
			<div class="container-fluid">
				<a href="<?= $this->BASE_URL ?>Produk" class="navbar-brand">
					<img src="<?= $this->ASSETS_URL ?>img/logo.png" class="img-logo-home px-2" alt="">
				</a>
				<div class="navbar-toggler border-0" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar2">
					<span class="fa fa-bars"></span>
				</div>
				<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar2" aria-labelledby="offcanvasNavbar2Label">
					<div class="offcanvas-header">
						<a href="<?= $this->BASE_URL ?>CS" class="navbar-brand">
							<img src="<?= $this->ASSETS_URL ?>img/logo.png" class="img-logo-home px-2" alt="">
						</a>
						<button type="button" class="btn-close text-reset me-2" data-bs-dismiss="offcanvas" aria-label="Close"></button>
					</div>
					<div class="offcanvas-body">
						<?php if (isset($_SESSION['admin_produk'])) { ?>
							<a href="#" class="ms-auto btn btn-sm border position-relative pt-2 me-1 bg-white text-success fw-bold shadow-none">
								Admin Produk: <i class="fa-regular fa-circle-user"></i>
								<span id="user_name"></span>
							</a>
						<?php  } ?>
					</div>
				</div>
			</div>
		</nav>
	</div>
</div>
<!-- Navbar End -->