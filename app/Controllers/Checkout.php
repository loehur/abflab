<?php

class Checkout extends Controller
{
   public function index()
   {
      if (!isset($_SESSION['cart'])) {
         header("Location: " . $this->BASE_URL . "Home");
         exit();
      }

      $data = [
         'title' => "Checkout",
         'content' => __CLASS__
      ];

      $this->view_layout(__CLASS__, $data);
   }

   public function content($parse)
   {

      if (!isset($_SESSION['cart_key'])) {
         $_SESSION['cart_key'] = rand(1000, 9999);
      }

      $data = [];
      $this->view(__CLASS__, __CLASS__ . "/content", $data);
   }

   public function kota($id)
   {
      $data = $this->model("Place")->kota($id);
      $this->view(__CLASS__, __CLASS__ . "/list_kota", $data);
   }

   public function kecamatan($id)
   {
      $data = $this->model("Place")->kecamatan($id);
      $_SESSION['tools']['kecamatan'] = $data;
      $this->view(__CLASS__, __CLASS__ . "/list_kecamatan", $data);
   }

   function kode_pos()
   {
      $input = $_POST['input'];
      $data = [];
      foreach ($_SESSION['tools']['kecamatan'] as $key => $kp) {
         if ($input == $key) {
            foreach ($kp as $k) {
               $g = $this->model("Biteship")->get_area($k);
               if (count($g) > 1) {
                  $find = 0;
                  foreach ($g as $kg => $g_) {
                     if (str_replace("+", " ", $key) == strtoupper($g_['administrative_division_level_3_name'])) {
                        $find += 1;
                        array_push($data, $g[$kg]);
                        break;
                     }
                  }
                  if ($find == 0) {
                     array_push($data, $g[0]);
                     $text = "ERROR. Kode Pos " . $k . " tidak valid dengan kecamatan " . str_replace("+", " ", $key);
                     $this->model('Log')->write($text);
                  }
               } elseif (count($g) == 1) {
                  array_push($data, $g[0]);
               }
            }
            break;
         }
      }
      $this->view(__CLASS__, __CLASS__ . "/list_kodepos", $data);
   }

   function daftar()
   {
      $hp =   $_POST['hp'];
      $nama = $_POST['nama'];
      $alamat = $_POST['alamat'];
      $area_id = $_POST['kodepos'];
      $lat = $_POST['lat'];
      $long = $_POST['long'];
      $email = $_POST['email'];

      $res = $this->model("Biteship")->get_area_id($area_id);
      if (isset($res[0]['id'])) {
         $area_id = $res[0]['id'];
         $area_name = $res[0]['name'];
         $postal_code = $res[0]['postal_code'];
      } else {
         $this->model('Log')->write("Daftar Error, Not Found res[0]['id']");
         header("Location: " . $this->BASE_URL . "Checkout");
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
               header("Location: " . $this->BASE_URL . "Checkout");
               exit();
            }
         } else {
            $this->model('Log')->write("Daftar Error, !isset area_name");
            header("Location: " . $this->BASE_URL . "Checkout");
            exit();
         }
      } else {
         if (isset($area_name)) {
            $cust_id = date("Ymdhis") . rand(0, 9) . rand(0, 9);
            $cols = "customer_id, name, hp, area_id, area_name, address, postal_code, latt, longt, email";
            $vals = "'" . $cust_id . "', '" . $nama . "', '" . $hp . "','" . $area_id . "','" . $area_name . "','" . $alamat . "','" . $postal_code . "','" . $lat . "','" . $long . "','" . $email . "'";
            $this->db(0)->insertCols("customer", $cols, $vals);
         } else {
            $this->model('Log')->write("Daftar Error, !isset area_name");
            header("Location: " . $this->BASE_URL . "Checkout");
            exit();
         }
      }

      $cust = $this->db(0)->get_where_row("customer", $where);
      if (isset($cust['customer_id'])) {
         $_SESSION['log'] = $cust;
         header("Location: " . $this->BASE_URL . "Checkout");
      } else {
         $this->model('Log')->write("Daftar Error, !cust['customer_id']");
         header("Location: " . $this->BASE_URL . "Checkout");
         exit();
      }
   }

   function ckout()
   {
      if (!isset($_SESSION['log']) || !isset($_SESSION['cart'])) {
         header("Location: " . $this->BASE_URL . "Home");
         exit();
      } else {
         $d = $_SESSION['log'];
         $str = $d['area_id'] . $d['latt'] . $d['longt'] . $_SESSION['cart_key'];
         if (!isset($_SESSION['ongkir'][$str]) || !isset($_POST['kurir'])) {
            $this->model('Log')->write("ERROR checkout, SESSION ONGKIR not found");
            header("Location: " . $this->BASE_URL . "Checkout");
            exit();
         } else {
            $ongkir_ar = $_SESSION['ongkir'][$str];
         }
      }

      $cust_id = $d['customer_id'];
      $hp = $d['hp'];
      $name = $d['name'];
      $address = $d['address'];
      $area_id = $d['area_id'];
      $area_name = $d['area_name'];
      $postal_code = $d['postal_code'];
      $latt = $d['latt'];
      $longt = $d['longt'];
      $email = $d['email'];

      $kurir_val = $_POST['kurir'];
      $kur = explode("|", $kurir_val);
      $kur_company = $kur[0];
      $kur_type = $kur[1];

      foreach ($ongkir_ar as $oa) {
         if ($oa['company'] == $kur_company && $oa['type'] == $kur_type) {
            $price = $oa['price'];
         }
      }

      if (!isset($price)) {
         $this->model('Log')->write("ERROR checkout, Price not found");
         header("Location: " . $this->BASE_URL . "Checkout");
         exit();
      }

      $ref = date("Ymdhis") . rand(0, 9) . rand(0, 9);

      $cols = "order_ref, customer_id";
      $vals = "'" . $ref . "','" . $cust_id . "'";
      $in = $this->db(0)->insertCols("order_step", $cols, $vals);
      if ($in['errno'] <> 0) {
         $this->model('Log')->write("Insert order_step Error, " . $in['error']);
         header("Location: " . $this->BASE_URL . "Home");
         exit();
      }

      $total = 0;
      foreach ($_SESSION['cart'] as $c) {
         $subTotal = $c['total'];
         $total += $subTotal;

         $cols = "order_ref, group_id, product_id, product, detail, price, qty, total, weight, length, width, height, note, file, metode_file, link_drive";
         $vals = "'" . $ref . "'," . $c['group_id'] . "," . $c['produk_id'] . ",'" . $c['produk'] . "','" . $c['detail'] . "'," . $c['harga'] . "," . $c['jumlah'] . "," . $subTotal . "," . $c['berat'] . "," . $c['panjang'] . "," . $c['lebar'] . "," . $c['tinggi'] . ",'" . $c['note'] . "','" . $c['file'] . "'," . $c['metode_file'] . ",'" . $c['link_drive'] . "'";
         $in = $this->db(0)->insertCols("order_list", $cols, $vals);
         if ($in['errno'] <> 0) {
            $where = "order_ref = '" . $ref . "'";
            $this->db(0)->delete_where("order_step", $where);
            $this->model('Log')->write("Insert order_list Error, " . $in['error']);
            header("Location: " . $this->BASE_URL . "Home");
            exit();
         }
      }

      //DELIVERY
      $cols = "order_ref, name, hp, address, area_id, area_name, postal_code, latt, longt, courier_company, courier_type, price_paid, price";
      $vals = "'" . $ref . "','" . $name . "','" . $hp . "','" . $address . "','" . $area_id . "','" . $area_name . "','" . $postal_code . "','" . $latt . "','" . $longt . "','" . $kur_company . "','" . $kur_type . "'," . $price . "," . $price;
      $in = $this->db(0)->insertCols("delivery", $cols, $vals);
      if ($in['errno'] <> 0) {
         $where = "order_ref = '" . $ref . "'";
         $this->db(0)->delete_where("order_step", $where);
         $this->db(0)->delete_where("order_list", $where);
         $this->model('Log')->write("Insert delivery Error, " . $in['error']);
         header("Location: " . $this->BASE_URL . "Home");
         exit();
      }

      //PAYMENT
      $total += $price;
      $cols = "order_ref, amount";
      $vals = "'" . $ref . "'," . $total;
      $in = $this->db(0)->insertCols("payment", $cols, $vals);
      if ($in['errno'] <> 0) {
         $where = "order_ref = '" . $ref . "'";
         $this->db(0)->delete_where("order_step", $where);
         $this->db(0)->delete_where("order_list", $where);
         $this->db(0)->delete_where("delivery", $where);
         $this->model('Log')->write("Insert payment Error, " . $in['error']);
         header("Location: " . $this->BASE_URL . "Home");
         exit();
      }

      unset($_SESSION['cart']);

      $token_midtrans = $this->model("Midtrans")->token($ref, $total, $name, $email, $hp);
      if (isset($token_midtrans['token'])) {
         $token = $token_midtrans['token'];
         $redirect_url = $token_midtrans['redirect_url'];
         $where = "order_ref = '" . $ref . "'";
         $set = "token = '" . $token . "', redirect_url = '" . $redirect_url . "'";
         $up = $this->db(0)->update("payment", $set, $where);
         if ($up['errno'] <> 0) {
            $this->model('Log')->write("Update payment Error, " . $up['error']);
         }
         header("Location: " . $redirect_url);
      } else {
         $this->model('Log')->write("Error get token payment midtrans");
         header("Location: " . $this->BASE_URL . "Pesanan");
      }
   }
}
