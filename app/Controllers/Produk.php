<?php

class Produk extends Controller
{
   public $access = false;
   public $valid_access = 1;
   public function __construct()
   {
      if (isset($_SESSION['log_admin'])) {
         if (in_array($this->valid_access, $_SESSION['log_admin']['access']) == true) {
            $this->access = true;
         }
      }
   }

   public function index($parse = null)
   {
      $data = [
         'title' => "Produk",
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

      if ($parse == null) {
         $parse = 0;
      }

      $data['produk'] = $this->db(0)->get_where("produk", "grup = " . $parse);
      $data['grup'] = $parse;
      $this->view(__CLASS__, __CLASS__ . "/content", $data);
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

   function login()
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
      unset($_SESSION['log_admin']);
      echo 1;
   }
}
