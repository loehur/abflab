 <!-- Spinner Start -->
 <div id="spinner" class="show w-100 vh-100 position-fixed translate-middle top-50 start-50  d-flex align-items-center justify-content-center">
 	<div class="spinner-grow text-primary" role="status"></div>
 </div>
 <!-- Spinner End -->

 <a href="https://api.whatsapp.com/send?phone=<?= PC::SETTING['wa_float'] ?>&text=Halo <?= PC::APP_NAME ?>, " class="float-green desktop" target="_blank">
 	<i class="fa-brands fa-whatsapp float-center"></i>
 </a>

 <div class="fix_menu mobile bg-white py-2" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;">
 	<div class="row px-2">
 		<div class="col px-0">
 			<a href="<?= PC::BASE_URL ?>Home">
 				<span class="btn btn-sm shadow-none">
 					<i class="fa-solid fa-house"></i><br>
 					Home
 				</span>
 			</a>
 		</div>
 		<div class="col px-0">
 			<div data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar2">
 				<span class="btn btn-sm shadow-none">
 					<i class="fa-solid fa-boxes-packing"></i><br>
 					Produk
 				</span>
 			</div>
 		</div>
 		<?php if (isset($_SESSION['log'])) { ?>
 			<div class="col px-0">
 				<a href=" <?= PC::BASE_URL ?>Pesanan" class="btn btn-sm shadow-none">
 					<i class="fa-solid fa-folder-closed"></i><br>
 					Pesanan
 				</a>
 			</div>
 		<?php } ?>
 		<div class="col px-0">
 			<span class="btn btn-sm shadow-none">
 				<a href="https://api.whatsapp.com/send?phone=<?= PC::SETTING['wa_float'] ?>&text=Halo <?= PC::APP_NAME ?>, " class="text-success" target="_blank">
 					<i class="fa-brands fa-whatsapp"></i><br>
 					Bantuan
 				</a>
 			</span>
 		</div>
 	</div>
 </div>