<?php

class Checkout extends Controller
{
   public function index()
   {
      if (!isset($_SESSION['cart'])) {
         header("Location: " . PC::BASE_URL . "Home");
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
      $data = $this->model("Place")->kota(base64_decode($id));
      $this->view(__CLASS__, __CLASS__ . "/list_kota", $data);
   }

   public function kecamatan($id)
   {
      $data['kec'] = $this->model("Place")->kecamatan(base64_decode($id));
      $data['kota'] = $id;
      $_SESSION['tools']['kecamatan'] = $data['kec'];
      $this->view(__CLASS__, __CLASS__ . "/list_kecamatan", $data);
   }

   function kode_pos()
   {
      $input = $_POST['input'];
      $kota = str_replace("+", " ", base64_decode($_POST['kota']));
      $data = [];
      foreach ($_SESSION['tools']['kecamatan'] as $key => $kp) {
         if ($input == $key) {
            $g1 = $this->model("Biteship")->get_area($key);
            if (count($g1) > 0) {
               $find1 = 0;
               foreach ($g1 as $kg1 => $g_1) {
                  if (str_replace("+", " ", $kota) == strtoupper($g_1['administrative_division_level_2_name'])) {
                     $find1 += 1;
                     array_push($data, $g1[$kg1]);
                  }
               }
               if ($find1 > 0) {
                  break;
               }
            }

            foreach ($kp as $k) {
               $g = $this->model("Biteship")->get_area($k);
               if (count($g) > 1) {
                  $find = 0;
                  foreach ($g as $kg => $g_) {
                     if (str_replace("+", " ", $kota) == strtoupper($g_['administrative_division_level_2_name'])) {
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
               sleep(1);
            }
            break;
         }
      }
      $this->view(__CLASS__, __CLASS__ . "/list_kodepos", $data);
   }

   function ckout()
   {
      if (!isset($_SESSION['log']) || !isset($_SESSION['cart'])) {
         header("Location: " . PC::BASE_URL . "Home");
         exit();
      } else {
         $d = $_SESSION['log'];
         $str = $d['area_id'] . $d['latt'] . $d['longt'] . $_SESSION['cart_key'];
         if (!isset($_SESSION['ongkir'][$str]) || !isset($_POST['kurir'])) {
            $this->model('Log')->write("ERROR checkout, SESSION ONGKIR not found");
            header("Location: " . PC::BASE_URL . "Checkout");
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
         if ($kur_company == "abf") {
            $price = 0;
         } else {
            $this->model('Log')->write("ERROR checkout, Price not found");
            header("Location: " . PC::BASE_URL . "Checkout");
            exit();
         }
      }

      $ref = date("Ymdhis") . rand(0, 9) . rand(0, 9);

      $cols = "order_ref, customer_id";
      $vals = "'" . $ref . "','" . $cust_id . "'";
      $in = $this->db(0)->insertCols("order_step", $cols, $vals);
      if ($in['errno'] <> 0) {
         $this->model('Log')->write("Insert order_step Error, " . $in['error']);
         header("Location: " . PC::BASE_URL . "Home");
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
            header("Location: " . PC::BASE_URL . "Home");
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
         header("Location: " . PC::BASE_URL . "Home");
         exit();
      }

      //DISKON ONGKIR
      $lj = 0;
      $diskon_ongkir = 0;
      foreach (PC::DISKON_ONGKIR as $key => $jumlah) {
         if ($total >= $jumlah) {
            if ($jumlah > $lj) {
               $diskon_ongkir = ($key / 100) * $total;
            }
         }
         $lj = $jumlah;
      }

      //PAYMENT
      $total += $price;
      $total -= $diskon_ongkir;

      $cols = "order_ref, amount";
      $vals = "'" . $ref . "'," . $total;
      $in = $this->db(0)->insertCols("payment", $cols, $vals);
      if ($in['errno'] <> 0) {
         $where = "order_ref = '" . $ref . "'";
         $this->db(0)->delete_where("order_step", $where);
         $this->db(0)->delete_where("order_list", $where);
         $this->db(0)->delete_where("delivery", $where);
         $this->model('Log')->write("Insert payment Error, " . $in['error']);
         header("Location: " . PC::BASE_URL . "Home");
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
         header("Location: " . PC::BASE_URL . "Pesanan");
      }
   }
}
