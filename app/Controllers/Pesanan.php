<?php

class Pesanan extends Controller
{
   public function index($parse = "paid")
   {
      if (!isset($_SESSION['log'])) {
         header("Location: " . $this->BASE_URL . "Home");
         exit();
      }

      $data = [
         'title' => "Pesanan",
         'content' => __CLASS__,
         'parse' => $parse
      ];

      $this->view_layout(__CLASS__, $data);
   }

   public function content($parse)
   {

      $log = $_SESSION['log'];
      $data = [];

      $order_status = 0;

      switch ($parse) {
         case 'paid':
            $order_status = 1;
            break;
         case 'sent':
            $order_status = 2;
            break;
         case 'done':
            $order_status = 3;
            break;
         case 'cancel':
            $order_status = 4;
            break;
         default:
            $order_status = 0;
            break;
      }


      $cust_id = $log['customer_id'];
      $where = "customer_id = '" . $cust_id . "' AND order_status = " . $order_status . " ORDER BY order_ref ASC";
      $step = $this->db(0)->get_where("order_step", $where);
      $data['order'] = [];
      foreach ($step as $s) {
         $where = "order_ref = '" . $s['order_ref'] . "'";
         $get = $this->db(0)->get_where("order_list", $where);
         $data['order'][$s['order_ref']] = $get;
      }

      $data['parse'] = $parse;
      $this->view(__CLASS__, __CLASS__ . "/content", $data);
   }
}
