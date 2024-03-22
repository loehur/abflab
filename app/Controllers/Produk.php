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

   function tambah()
   {
      $des_ok = [];
      $deskripsi = $_POST['deskripsi'];
      $des = explode(",", $deskripsi);
      foreach ($des as $key => $d) {
         $des2 = explode("|", $d);
         if (isset($des2[0]) && isset($des2[1])) {
            $des_ok[$key] = [
               "judul" => $des2[0],
               "konten" => $des2[1],
            ];
         } else {
            continue;
         }
      }
      $deskripsi = serialize($des_ok);
      $mal = $_POST['mal'];
      if (strlen($mal) > 0) {
         $mal = serialize(explode(",", $mal));
      }

      $produk = $_POST['produk'];
      $grup = $_POST['grup'];
      $harga = $_POST['harga'];
      $img_utama = $_POST['img_utama'];
      $img_detail = $_POST['img_detail'];
      $link = $_POST['link'];
      $target = $_POST['target'];
      $perlu_file = $_POST['perlu_file'];
      $berat = $_POST['berat'];
      $p = $_POST['p'];
      $l = $_POST['l'];
      $t = $_POST['t'];

      $cols = "produk, grup, img, img_detail, mal, link, target, detail, perlu_file, harga, berat, p, l, t";
      $vals = "'" . $produk . "'," . $grup . ",'" . $img_utama . "','" . $img_detail . "','" . $mal . "','" . $link . "','" . $target . "','" . $deskripsi . "'," . $perlu_file . "," . $harga . "," . $berat . "," . $p . "," . $l . "," . $t . "";
      $in = $this->db(0)->insertCols("produk", $cols, $vals);
      if ($in['errno'] <> 0) {
         print_r($in['error']);
      } else {
         echo 1;
      }
   }
}
