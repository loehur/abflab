<?php

class Home extends Controller
{
   public function __construct() {}

   public function index()
   {
      $data = [
         'title' => __CLASS__,
         'content' => __CLASS__
      ];

      //SESSION DATA
      if (isset($_SESSION['log'])) {
         $count = $this->db(0)->count_where("order_step", "customer_id = '" . $_SESSION['log']['customer_id'] . "' AND order_status <> 0 AND order_status <> 4");
         if ($count > 0) {
            $_SESSION['new_user'] = false;
         } else {
            $_SESSION['new_user'] = true;
         }
      } else {
         $_SESSION['new_user'] = true;
      }

      $data['product'] = $this->db(0)->get_where("produk", "en = 0 ORDER BY freq DESC");
      $this->view_layout(__CLASS__, $data);
   }

   public function content($parse)
   {
      $data = [];
      $data['banner'] = 3; // File di asset, img/banner
      $data['product'] = $this->db(0)->get_where("produk", "en = 0 ORDER BY freq DESC");
      $this->view(__CLASS__, __CLASS__ . "/content", $data);
   }
}
