<?php

class Bayar extends Controller
{
   public function index($parse = "")
   {
      $data = [
         'title' => "Pesanan",
         'content' => __CLASS__,
         'parse' => $parse
      ];

      $this->view_layout(__CLASS__, $data);
   }

   public function content($parse = "")
   {
      if ($parse == "") {
         echo "Failed";
         exit();
      }
      $data = [];
      $where_d = "order_ref = '" . $parse . "'";
      $data = $this->db(0)->get_where_row("payment", $where_d);
      $this->view(__CLASS__, __CLASS__ . "/content", $data);
   }
}
