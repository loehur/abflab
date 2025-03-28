<?php

class CS extends Controller
{
   public $access = false;
   public $valid_access = 0;
   public function __construct()
   {
      if (isset($_SESSION['log_admin'])) {
         if (in_array($this->valid_access, $_SESSION['log_admin']['access']) == true) {
            $this->access = true;
         }
      }
   }

   public function index($parse = "paid")
   {
      $data = [
         'title' => "Order",
         'content' => __CLASS__,
         'parse' => $parse
      ];

      $this->view_layout_admin(__CLASS__, $data);
   }

   function content($parse)
   {
      if ($this->access == false) {
         $this->view(__CLASS__, __CLASS__ . "/login");
         exit();
      }

      $data = [];

      switch ($parse) {
         case 'paid':
            $order_status = 1;
            $where = "order_status = " . $order_status . " ORDER BY order_ref DESC";
            break;
         case 'sent':
            $order_status = 2;
            $where = "order_status = " . $order_status . " ORDER BY order_ref DESC";
            break;
         case 'done':
            $order_status = 3;
            $where = "order_status = " . $order_status . " ORDER BY order_ref DESC LIMIT 10";
            break;
         case 'cancel':
            $order_status = 4;
            $where = "order_status = " . $order_status . " ORDER BY order_ref DESC LIMIT 10";
            break;
         default:
            $parse = 'bb';
            $order_status = 0;
            $where = "order_status = " . $order_status . " ORDER BY order_ref DESC";
            break;
      }


      $data['order'] = [];
      $step = $this->db(0)->get_where("order_step", $where, 'order_ref');
      ksort($step);
      $refs = array_keys($step);
      $ref_list = "0";
      if (count($refs) > 0) {
         foreach ($refs as $r) {
            $ref_list .= $r . ",";
         }
         $ref_list = rtrim($ref_list, ',');
      }

      $where = "order_ref IN (" . $ref_list . ") ORDER BY order_ref DESC";
      $data['order'] = $this->db(0)->get_where("order_list", $where, 'order_ref', 1);
      $data['diskon_aff'] = $this->db(0)->get_where("diskon_aff", $where, 'order_ref', 1);

      foreach ($step as $s) {
         $data['step'][$s['order_ref']]['customer'] = $s['customer_id'];
         $data['step'][$s['order_ref']]['time'] = $s['insertTime'];
      }

      $data['diskon_belanja'] = [];
      foreach ($step as $s) {
         $where = "order_ref = '" . $s['order_ref'] . "'";
         $get = $this->db(0)->get_where_row("order_discount", $where);
         $data['discount'][$s['order_ref']] = isset($get['discount']) ? $get['discount'] : 0;
      }

      $data['parse'] = $parse;
      $this->view(__CLASS__, __CLASS__ . "/content", $data);
   }

   function cek_kirim($ref)
   {
      $where = "order_ref = '" . $ref . "'";
      $_SESSION['cart_cs'] = $this->db(0)->get_where("order_list", $where);
      $d = $this->db(0)->get_where_row("delivery", $where);
      $type = $d['courier_type'];
      $ongkir = $this->model("Biteship")->cek_ongkir_cs($d['area_id'], $d['latt'], $d['longt'], $d['courier_company']);

      foreach ($ongkir as $o) {
         if ($o['type'] == $type) {
            $acm = serialize($o['available_collection_method']);
            $set = "available_collection_method = '" . $acm . "'";
            $this->db(0)->update("delivery", $set, $where);
         }
      }
   }

   function kirim($ref, $acm)
   {
      $where = "order_ref = '" . $ref . "'";
      $_SESSION['cart_cs'] = $this->db(0)->get_where("order_list", $where);
      $d = $this->db(0)->get_where_row("delivery", $where);
      $order = $this->model("Biteship")->order($d, $acm);
      $o = $order;
      if (isset($o['success']) && $o['success'] == 1) {
         $set = "order_id = '" . $o['id'] . "', tracking_id = '" . $o['courier']['tracking_id'] . "', waybill_id = '" . $o['courier']['waybill_id'] . "', price = '" . $o['price'] . "', delivery_status = '" . $o['status'] . "'";
         $this->db(0)->update("delivery", $set, $where);

         $set = "order_status = 2, delivery_id = '" . $o['id'] . "'";
         $this->db(0)->update("order_step", $set, $where);
      }
   }


   function selesai($ref)
   {
      $cs = $_SESSION['log_admin']['no'];

      $date = date("Y-m-d H:i:s");
      $where_o = "order_ref = '" . $ref . "'";
      $set_o = "order_status = 3, done_date = '" . $date . "', cs_done = '" . $cs . "'";
      $this->db(0)->update("order_step", $set_o, $where_o);

      $where = "order_ref = '" . $ref . "'";
      $cust = $this->db(0)->get_where_row("delivery", $where);
      $text = "*" . PC::APP_NAME . "*\nREF#" . $ref . "\nOrderan telah selesai dan siap dijemput";
      $this->model('WA')->send($cust['hp'], $text);
   }

   function batalkan()
   {
      // pembatalan harus call api refund
      $cs = $_SESSION['cs']['no'];
      $ref = $_POST['ref'];
      $where = "order_ref = '" . $ref . "'";
      $set = "payment_status = 3";
      $this->db(0)->update("payment", $set, $where);

      $date = date("Y-m-d H:i:s");
      $cs_note = $_POST['cs_note'];
      $where_o = "order_ref = '" . $ref . "'";
      $set_o = "processing_step = 3, cs_note = '" . $cs_note . "', cancel_date = '" . $date . "', cancel_cs = '" . $cs . "'";
      $this->db(0)->update("order_list", $set_o, $where_o);

      $cust_id = $_POST['cust'];
      $where = "customer_id = '" . $cust_id . "'";
      $cust = $this->db(0)->get_where_row("customer", $where);
      $text = "*" . PC::APP_NAME . "*\nREF#" . $ref . "\nTransaksi dibatalkan\nNote: " . $cs_note;
      $this->model('WA')->send($cust['hp'], $text);
   }

   function req_otp()
   {
      $there = false;
      $number = $_POST['number'];
      foreach (PC::USER_ADMIN as $c) {
         if ($c['no'] == $number && in_array($this->valid_access, $c['access'])) {
            $there = true;
            if (isset($_COOKIE[$number])) {
               echo "OTP sudah di kirimkan, timeout 5 menit";
            } else {
               $otp = rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
               $otp_en = $this->model("Encrypt")->enc($otp);
               setcookie($number, $otp_en, time() + (300), "/");
               $this->model('WA')->send($number, $otp);
               echo "OTP berhasil dikirimkan!";
            }
            exit();
         }
      }
      if ($there == false) {
         echo "Maaf nomor tidak terdaftar";
      }
   }

   function cs_login()
   {
      $number = $_POST['number'];
      if (isset($_COOKIE[$number])) {
         $otp = $this->model("Encrypt")->enc($_POST['otp']);
         if ($otp == $_COOKIE[$number]) {
            $ada = false;
            foreach (PC::USER_ADMIN as $c) {
               if ($c['no'] == $number && in_array($this->valid_access, $c['access'])) {
                  $ada = true;
                  $_SESSION['log_admin'] = $c;
                  echo 1;
                  exit();
               }
            }
            if ($ada == false) {
               echo "Nomor tidak terdaftar";
            }
         } else {
            echo "OTP salah";
         }
      } else {
         echo "OTP salah";
      }
   }
   function logout()
   {
      unset($_SESSION['cs']);
      echo 1;
   }

   function load_cs_detail($id)
   {
      $where = "order_ref = '" . $id . "'";
      $cust = $this->db(0)->get_where_row("delivery", $where);
      echo "<pre>";
      print_r($cust);
      echo "</pre>";
   }
}
