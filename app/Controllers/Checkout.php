<?php

class Checkout extends Controller
{
   private $target_notif = null;

   public function __construct()
   {
      $this->target_notif = PC::NOTIF[PC::SETTING['production']];
   }

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

   public function content($parse = "")
   {
      if (isset($_SESSION['diskon_new'])) {
         unset($_SESSION['diskon_new']);
      }

      if (!isset($_SESSION['cart_key'])) {
         $_SESSION['cart_key'] = rand(1000, 9999);
      }

      $data = [];
      $data['produk'] = $this->db(0)->get('produk', 'produk_id');

      $data['list'] = [];
      $data['step'] = [];

      if (count(PC::DISKON_NEW_USER) > 0 && isset($_SESSION['log'])) {
         $data['step'] = $this->db(0)->get_where('order_step', "customer_id = '" . $_SESSION['log']['customer_id'] . "' AND order_status <> 4 AND order_status <> 0", "order_ref");
         $refs = array_keys($data['step']);

         if (count($refs) > 0) {
            $ref_list = "";
            foreach ($refs as $r) {
               $ref_list .= $r . ",";
            }
            $ref_list = rtrim($ref_list, ',');
            $data['list'] = $this->db(0)->get_where('order_list', "order_ref IN (" . $ref_list . ")");
         }
      }

      $data[''] = $this->db(0)->get('produk', 'produk_id');
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
      $diskon_belanja = 0;
      $diskon_aff = 0;
      foreach ($_SESSION['cart'] as $key => $c) {
         $subTotal = $c['total'];
         $total += $subTotal;

         $cols = "order_ref, group_id, product_id, product, detail, price, qty, total, weight, length, width, height, note, file, metode_file, link_drive, diskon";

         $diskon = 0;
         if (isset($_SESSION['diskon_new'][$key])) {
            $diskon = $_SESSION['diskon_new'][$key];
         }
         $diskon_belanja += $diskon;

         $vals = "'" . $ref . "'," . $c['group_id'] . "," . $c['produk_id'] . ",'" . $c['produk'] . "','" . $c['detail'] . "'," . $c['harga'] . "," . $c['jumlah'] . "," . $subTotal . "," . $c['berat'] . "," . $c['panjang'] . "," . $c['lebar'] . "," . $c['tinggi'] . ",'" . $c['note'] . "','" . $c['file'] . "'," . $c['metode_file'] . ",'" . $c['link_drive'] . "'," . $diskon;
         $in = $this->db(0)->insertCols("order_list", $cols, $vals);
         if ($in['errno'] <> 0) {
            $where = "order_ref = '" . $ref . "'";
            $this->db(0)->delete_where("order_step", $where);
            $this->model('Log')->write("Insert order_list Error, " . $in['error']);
            header("Location: " . PC::BASE_URL . "Home");
            exit();
         } else {
            if (isset($_SESSION['diskon_aff'][$key])) {
               $dDiskon = $_SESSION['diskon_aff'][$key];
               $diskon_aff += $dDiskon['diskon_buyer'];
               $cols = "order_ref, produk, code, jumlah, fee_aff, diskon_buyer";
               $vals = "'" . $ref . "'," . $dDiskon['produk'] . ",'" . $dDiskon['code'] . "'," . $dDiskon['jumlah'] . "," . $dDiskon['fee_aff'] . "," . $dDiskon['diskon_buyer'];
               $in = $this->db(0)->insertCols("diskon_aff", $cols, $vals);
               if ($in['errno'] <> 0) {
                  $where = "order_ref = '" . $ref . "'";
                  $this->db(0)->delete_where("order_step", $where);
                  $this->db(0)->delete_where("order_list", $where);
                  $this->model('Log')->write("Insert diskon_aff Error, " . $in['error']);
                  header("Location: " . PC::BASE_URL . "Home");
                  exit();
               }
            }
         }
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

      if ($diskon_ongkir > $price) {
         $diskon_ongkir = $price;
      }

      //DISKON BELANJA
      $diskon_belanja_total = $_SESSION['diskon_belanja'];
      $diskon_belanja += $diskon_belanja_total;

      //INSERT DISCOUNT
      $cols = "order_ref, discount";
      $vals = "'" . $ref . "'," . $diskon_belanja;
      $in = $this->db(0)->insertCols("order_discount", $cols, $vals);
      if ($in['errno'] <> 0) {
         $where = "order_ref = '" . $ref . "'";
         $this->db(0)->delete_where("order_step", $where);
         $this->db(0)->delete_where("order_list", $where);
         $this->db(0)->delete_where("diskon_aff", $where);
         $this->model('Log')->write("Insert discount Error, " . $in['error']);
         header("Location: " . PC::BASE_URL . "Home");
         exit();
      }

      //DELIVERY
      $cols = "order_ref, name, hp, address, area_id, area_name, postal_code, latt, longt, courier_company, courier_type, price_paid, price, discount";
      $vals = "'" . $ref . "','" . $name . "','" . $hp . "','" . $address . "','" . $area_id . "','" . $area_name . "','" . $postal_code . "','" . $latt . "','" . $longt . "','" . $kur_company . "','" . $kur_type . "'," . $price . "," . $price . "," . $diskon_ongkir;
      $in = $this->db(0)->insertCols("delivery", $cols, $vals);
      if ($in['errno'] <> 0) {
         $where = "order_ref = '" . $ref . "'";
         $this->db(0)->delete_where("order_discount", $where);
         $this->db(0)->delete_where("order_step", $where);
         $this->db(0)->delete_where("order_list", $where);
         $this->db(0)->delete_where("diskon_aff", $where);
         $this->model('Log')->write("Insert delivery Error, " . $in['error']);
         header("Location: " . PC::BASE_URL . "Home");
         exit();
      }

      //PAYMENT
      $price -= $diskon_ongkir;
      $total -= $diskon_belanja;
      $total -= $diskon_aff;
      $total += $price;

      if ($total <= PC::BY_PASS_PAYMENT) {
         $where = "order_ref = '" . $ref . "'";
         $set = "order_status = 1";
         $up2 = $this->db(0)->update("order_step", $set, $where);
         if ($up2['errno'] <> 0) {
            $text = "ERROR UPDATE *BY_PASS_PAYMENT* ORDER STEP. update DB when trigger New Status, Order Ref: " . $ref . ", New Status ORDER STEP: BY PASS PAYMENT " . $up2['error'];
            $this->model('Log')->write($text);
            $this->model('WA')->send($this->target_notif, $text);

            $where = "order_ref = '" . $ref . "'";
            $this->db(0)->delete_where("order_step", $where);
            $this->db(0)->delete_where("order_list", $where);
            $this->db(0)->delete_where("diskon_aff", $where);
            $this->db(0)->delete_where("delivery", $where);
            $this->model('Log')->write("Insert payment Error, " . $in['error']);
            header("Location: " . PC::BASE_URL . "Home");
            exit();
         } else {
            $cols = "order_ref, amount, expiry_time, transaction_status, fraud_status";
            $vals = "'" . $ref . "'," . $total . ",'" . date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . " +1 day")) . "','settlement','accept'";
            $in = $this->db(0)->insertCols("payment", $cols, $vals);
            if ($in['errno'] <> 0) {
               $where = "order_ref = '" . $ref . "'";
               $this->db(0)->delete_where("order_step", $where);
               $this->db(0)->delete_where("order_list", $where);
               $this->db(0)->delete_where("diskon_aff", $where);
               $this->db(0)->delete_where("delivery", $where);
               $this->model('Log')->write("Insert payment Error, " . $in['error']);
               header("Location: " . PC::BASE_URL . "Home");
               exit();
            }

            $text_o = "VitaPictura, order baru *DITERIMA*. REF#" . $ref . ". " . PC::HOST . "/CS";
            $this->model('WA')->send($this->target_notif, $text_o);

            unset($_SESSION['cart']);
            unset($_SESSION['diskon_new']);

            header("Location: " . PC::BASE_URL . "Pesanan");
         }
      } else {
         $cols = "order_ref, amount, expiry_time";
         $vals = "'" . $ref . "'," . $total . ",'" . date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . " +1 day")) . "'";
         $in = $this->db(0)->insertCols("payment", $cols, $vals);
         if ($in['errno'] <> 0) {
            $where = "order_ref = '" . $ref . "'";
            $this->db(0)->delete_where("order_step", $where);
            $this->db(0)->delete_where("order_list", $where);
            $this->db(0)->delete_where("diskon_aff", $where);
            $this->db(0)->delete_where("delivery", $where);
            $this->model('Log')->write("Insert payment Error, " . $in['error']);
            header("Location: " . PC::BASE_URL . "Home");
            exit();
         }

         unset($_SESSION['cart']);
         unset($_SESSION['diskon_new']);
         unset($_SESSION['diskon_aff']);
         unset($_SESSION['diskon_belanja']);

         $_SESSION['new_user'] == false;

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
}
