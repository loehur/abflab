<?php

class Set_Password extends Controller
{
   public function __construct()
   {
   }

   public function index()
   {
      $data = [
         'title' => __CLASS__,
         'content' => __CLASS__
      ];

      $this->view_layout(__CLASS__, $data);
   }

   public function content()
   {
      $this->view(__CLASS__, __CLASS__ . "/content");
   }

   function req_otp()
   {
      $number = $_POST['number'];

      $where = "hp = '" . $_POST['number'] . "'";
      $cust = $this->db(0)->get_where_row("customer", $where);
      if (isset($cust['customer_id'])) {
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
      } else {
         echo "Maaf. Nomor HP belum pernah melakukan order!";
      }
   }

   function update_pass()
   {
      $number = $_POST['number'];
      $pass1 = $_POST['pass1'];
      $pass2 = $_POST['pass2'];
      if ($pass1 <> $pass2) {
         echo "Password tidak cocok";
      } else {
         if (isset($_COOKIE[$number])) {
            $otp = $this->model("Encrypt")->enc($_POST['otp']);
            if ($otp == $_COOKIE[$number]) {
               $where = "hp = '" . $_POST['number'] . "'";
               $cust = $this->db(0)->get_where_row("customer", $where);
               if (isset($cust['customer_id'])) {
                  $pass = $this->model("Encrypt")->enc($_POST['pass1']);
                  $set = "password = '" . $pass . "'";
                  $update = $this->db(0)->update("customer", $set, $where);
                  if ($update['errno'] == 0) {
                     echo 1;
                  }
               } else {
                  echo "Maaf. nomor HP salah!";
               }
            } else {
               echo "OTP salah";
            }
         } else {
            echo "OTP salah";
         }
      }
   }
}
