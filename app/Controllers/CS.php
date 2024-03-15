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

      $where = "order_status = " . $order_status . " ORDER BY order_ref ASC";
      $step = $this->db(0)->get_where("order_step", $where);
      $data['order'] = [];
      foreach ($step as $s) {
         $where = "order_ref = '" . $s['order_ref'] . "'";
         $get = $this->db(0)->get_where("order_list", $where);
         $data['order'][$s['order_ref']] = $get;
         $data['step'][$s['order_ref']]['customer'] = $s['customer_id'];
         $data['step'][$s['order_ref']]['time'] = $s['insertTime'];
      }

      $data['parse'] = $parse;
      $this->view(__CLASS__, __CLASS__ . "/content", $data);
   }

   function terima()
   {
      $cs = $_SESSION['cs']['no'];
      $ref = $_POST['ref'];
      $where = "order_ref = '" . $ref . "'";
      $set = "payment_status = 2";
      $this->db(0)->update("payment", $set, $where);

      $date = date("Y-m-d H:i:s");
      $where_o = "order_ref = '" . $ref . "'";
      $set_o = "processing_step = 1, confirm_date = '" . $date . "', confirm_cs = '" . $cs . "'";
      $this->db(0)->update("order_list", $set_o, $where_o);

      $cust_id = $_POST['cust'];
      $where = "customer_id = '" . $cust_id . "'";
      $cust = $this->db(0)->get_where_row("customer", $where);
      $text = "*" . $this->WEB . "*\nREF#" . $ref . "\nPembayaran diterima, orderan Anda sedang dalam proses. Terimakasih";
      $this->model('WA')->send($cust['hp'], $text);
   }

   function selesai()
   {
      $cs = $_SESSION['cs']['no'];
      $ref = $_POST['ref'];
      $resi = $_POST['resi'];

      $date = date("Y-m-d H:i:s");
      $where_o = "order_ref = '" . $ref . "'";
      $set_o = "processing_step = 2, done_date = '" . $date . "', done_cs = '" . $cs . "'";
      $this->db(0)->update("order_list", $set_o, $where_o);

      $where_d = "order_ref = '" . $ref . "'";
      $set_d = "resi = '" . $resi . "'";
      $this->db(0)->update("order_list", $set_d, $where_d);

      $deliv = $_POST['deliv'];
      $cust_id = $_POST['cust'];
      $where = "customer_id = '" . $cust_id . "'";
      $cust = $this->db(0)->get_where_row("customer", $where);
      if ($deliv == 1) {
         $text = "*" . $this->WEB . "*\nREF#" . $ref . "\nOrderan telah selesai dan siap dijemput";
      } else {
         $text = "*" . $this->WEB . "*\nREF#" . $ref . "\nOrderan telah selesai dan sedang dalam proses pengiriman.\nResi: " . $resi;
      }
      $this->model('WA')->send($cust['hp'], $text);
   }

   function batalkan()
   {
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
      $text = "*" . $this->WEB . "*\nREF#" . $ref . "\nTransaksi dibatalkan\nNote: " . $cs_note;
      $this->model('WA')->send($cust['hp'], $text);
   }

   function req_otp()
   {
      $there = false;
      $number = $_POST['number'];
      foreach ($this->user_admin as $c) {
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
            foreach ($this->user_admin as $c) {
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
