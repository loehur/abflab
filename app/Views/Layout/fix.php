 <!-- Spinner Start -->
 <div id="spinner" class="show w-100 vh-100 position-fixed translate-middle top-50 start-50  d-flex align-items-center justify-content-center">
 	<div class="spinner-grow text-primary" role="status"></div>
 </div>
 <!-- Spinner End -->

 <a href="https://api.whatsapp.com/send?phone=<?= PC::SETTING['wa_float'] ?>&text=Halo <?= PC::APP_NAME ?>, " class="float-green" target="_blank">
 	<i class="fa-brands fa-whatsapp float-center"></i>
 </a>