<?php

class Pesanan extends Controller
{
   public function index($parse = "paid")
   {
      if (!isset($_SESSION['log'])) {
         header("Location: " . PC::BASE_URL . "Home");
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
      $cust_id = $log['customer_id'];

      switch ($parse) {
         case 'paid':
            $order_status = 1;
            $where = "customer_id = '" . $cust_id . "' AND order_status = " . $order_status . " ORDER BY order_ref DESC";
            break;
         case 'sent':
            $order_status = 2;
            $where = "customer_id = '" . $cust_id . "' AND order_status = " . $order_status . " ORDER BY order_ref DESC";
            break;
         case 'done':
            $order_status = 3;
            $where = "customer_id = '" . $cust_id . "' AND order_status = " . $order_status . " ORDER BY order_ref DESC LIMIT 10";
            break;
         case 'cancel':
            $order_status = 4;
            $where = "customer_id = '" . $cust_id . "' AND order_status = " . $order_status . " ORDER BY order_ref DESC LIMIT 10";
            break;
         default:
            $parse = 'bb';
            $order_status = 0;
            $where = "customer_id = '" . $cust_id . "' AND order_status = " . $order_status . " ORDER BY order_ref DESC";
            break;
      }

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
