<?php

class CS extends Controller
{
   public function index()
   {
      $data = [
         'title' => "Order",
         'content' => __CLASS__,
         'parse' => "bb"
      ];

      $this->view_layout_cs(__CLASS__, $data);
   }

   function content($tab = 'bb')
   {
      if (!isset($_SESSION['cs'])) {
         $this->view(__CLASS__, __CLASS__ . "/login");
         exit();
      }

      $data['bb'] = [];
      $data['p'] = [];
      $data['s'] = [];
      $data['b'] = [];
      $data['tab'] = $tab;

      $where = "processing_step = 0 ORDER BY order_ref ASC";
      $data['bb'] = $this->db(0)->get_where("order_list", $where);

      $where_p = "processing_step = 1 ORDER BY order_ref ASC";
      $data['p'] = $this->db(0)->get_where("order_list", $where_p);

      $where_b = "processing_step = 3 ORDER BY order_ref ASC";
      $data['b'] = $this->db(0)->get_where("order_list", $where_b);

      $where_S = "processing_step = 2 ORDER BY order_ref ASC";
      $data['s'] = $this->db(0)->get_where("order_list", $where_S);

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
      $cs_number = $_POST['cs_number'];
      foreach ($this->CS as $c) {
         if ($c['no'] == $cs_number) {
            $there = true;
            if (isset($_COOKIE[$cs_number])) {
               echo "OTP sudah di kirimkan, timeout 5 menit";
            } else {
               $otp = rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
               $otp_en = $this->model("Encrypt")->enc($otp);
               setcookie($cs_number, $otp_en, time() + (300), "/");
               $this->model('WA')->send($cs_number, $otp);
               echo "OTP berhasil dikirimkan!";
            }
         }
      }
      if ($there == false) {
         echo "Maaf nomor tidak terdaftar";
      }
   }

   function cs_login()
   {
      $cs_number = $_POST['cs_number'];
      if (isset($_COOKIE[$cs_number])) {
         $otp = $this->model("Encrypt")->enc($_POST['otp']);
         if ($otp == $_COOKIE[$cs_number]) {
            $ada = false;
            foreach ($this->CS as $c) {
               if ($c['no'] == $cs_number) {
                  $ada = true;
                  $_SESSION['cs'] = [
                     "no" => $cs_number,
                     "name" => $c['nama']
                  ];
                  echo 1;
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
