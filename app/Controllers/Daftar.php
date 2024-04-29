<?php

class Daftar extends Controller
{

   public function index()
   {
      $data = [
         'title' => "Daftar",
         'content' => __CLASS__
      ];

      $this->view_layout(__CLASS__, $data);
   }

   public function content()
   {
      $data = [];
      if (isset($_SESSION['tools']['provinsi'])) {
         $data['provinsi'] = $_SESSION['tools']['provinsi'];
      } else {
         $cek = $this->model("Place")->provinsi();
         $_SESSION['tools']['provinsi'] = $cek;
         $data['provinsi'] = $_SESSION['tools']['provinsi'];
      }

      if (isset($_SESSION['log'])) {
         $get = $_SESSION['log'];
         $_SESSION['tools']['location']['lat'] =  $get['latt'];
         $_SESSION['tools']['location']['long'] = $get['longt'];
      }

      if (isset($_SESSION['tools']['location'])) {
         $data['geo'] =  $_SESSION['tools']['location'];
      } else {
         $ip = $this->model("GeoIP")->getUserIP();
         if ($ip == "127.0.0.1") {
            $ip = $this->model("GeoIP")->getPublicIP();
         }
         $data['geo'] = $this->model("GeoIP")->longlat($ip);
         $_SESSION['tools']['location'] =  $data['geo'];
      }
      $this->view(__CLASS__, __CLASS__ . "/content", $data);
   }

   function daftar()
   {
      $hp = $_POST['number'];
      $hp = preg_replace('/[^0-9]/', '', $hp);
      if (substr($hp, 0, 2) == "62") {
         $hp = "0" . substr($hp, 2);
      }

      $nama = $_POST['nama'];
      $alamat = $_POST['alamat'];
      $area_id = $_POST['kodepos'];
      $lat = $_POST['lat'];
      $long = $_POST['long'];
      $email = $_POST['email'];

      if (isset($_POST['pw1'])) {
         $pass1 = $_POST['pw1'];
         $pass2 = $_POST['pw2'];

         if ($pass1 <> $pass2) {
            echo "Password tidak cocok";
            exit();
         } else {
            if (isset($_COOKIE[$hp])) {
               $otp = $this->model("Encrypt")->enc($_POST['otp']);
               if ($otp == $_COOKIE[$hp]) {
                  $pass = $this->model("Encrypt")->enc($pass1);
               } else {
                  echo "OTP salah";
                  exit();
               }
            } else {
               echo "OTP salah";
               exit();
            }
         }
      }

      $res = $this->model("Biteship")->get_area_id($area_id);
      if (isset($res[0]['id'])) {
         $area_id = $res[0]['id'];
         $area_name = $res[0]['name'];
         $postal_code = $res[0]['postal_code'];
      } else {
         $this->model('Log')->write("Daftar Error, Not Found res[0]['id']");
         header("Location: " . PC::BASE_URL . "Checkout");
         exit();
      }

      $where = "hp = '" . $hp . "'";
      $cek = $this->db(0)->get_where_row("customer", $where);
      if (isset($cek['customer_id'])) {
         if (isset($area_name)) {
            $set = "name = '" . $nama . "', address = '" . $alamat . "', area_name = '" . $area_name . "', area_id = '" . $area_id . "', postal_code = '" . $postal_code . "', latt = '" . $lat . "', longt = '" . $long . "', email = '" . $email . "'";
            $update = $this->db(0)->update("customer", $set, $where);
            if ($update['errno'] <> 0) {
               $this->model('Log')->write("Daftar Error, " . $update['error']);
               header("Location: " . PC::BASE_URL . "Checkout");
               exit();
            }
         } else {
            $this->model('Log')->write("Daftar Error, !isset area_name");
            header("Location: " . PC::BASE_URL . "Checkout");
            exit();
         }
      } else {
         if (isset($area_name)) {
            $cust_id = date("Ymdhis") . rand(0, 9) . rand(0, 9);
            $cols = "customer_id, name, hp, area_id, area_name, address, postal_code, latt, longt, email, password";
            $vals = "'" . $cust_id . "', '" . $nama . "', '" . $hp . "','" . $area_id . "','" . $area_name . "','" . $alamat . "','" . $postal_code . "','" . $lat . "','" . $long . "','" . $email . "','" . $pass . "'";
            $this->db(0)->insertCols("customer", $cols, $vals);
         } else {
            $this->model('Log')->write("Daftar Error, !isset area_name");
            header("Location: " . PC::BASE_URL . "Checkout");
            exit();
         }
      }

      $cust = $this->db(0)->get_where_row("customer", $where);
      if (isset($cust['customer_id'])) {
         $_SESSION['log'] = $cust;
         if (isset($_SESSION['cart'])) {
            echo 0;
         } else {
            echo 1;
         }
      } else {
         $this->model('Log')->write("Daftar Error, !cust['customer_id']");
         header("Location: " . PC::BASE_URL . "Home");
         exit();
      }
   }

   function req_otp()
   {
      $number = $_POST['number'];
      if (isset($_COOKIE[$number])) {
         echo "OTP sudah di kirimkan, timeout 5 menit";
      } else {
         $otp = rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
         $otp_en = $this->model("Encrypt")->enc($otp);
         setcookie($number, $otp_en, time() + (300), "/");
         $this->model('WA')->send($number, $otp);
         echo "OTP berhasil dikirimkan!";
      }
   }
}
