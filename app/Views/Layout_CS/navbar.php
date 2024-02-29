<?php
$t = $data['title'];
?>

<!-- Navbar start -->
<div class="fixed-top shadow-sm" style="max-height: 80px; background-color:aliceblue">
	<div class="container px-0">
		<nav class="navbar navbar-light navbar-expand-xl">
			<div class="container-fluid">
				<a href="<?= $this->BASE_URL ?>CS" class="navbar-brand">
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
						<?php if (isset($_SESSION['cs'])) { ?>
							<a href="#" class="ms-auto btn btn-sm border position-relative pt-2 me-1 bg-white text-success fw-bold" data-bs-toggle="modal" data-bs-target="#exampleModal">
								CS Login: <i class="fa-regular fa-circle-user"></i>
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


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Login</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form action="<?= $this->BASE_URL ?>CS/logout" method="POST">

				<div class="modal-body">
					<div class="form-floating mb-2">
						Anda sedang Login sebagai CS : <span class="text-success fw-bold"><?= $_SESSION['cs']['name'] ?></span>.
						Apakah ingin Logout?
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Logout</button>
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
					alert("Logout Success!");
					location.reload(true);
				} else {
					alert(res)
				}
			},
		});
	});
</script>