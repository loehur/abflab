<?php

class Pesanan extends Controller
{
   public function __construct()
   {
   }

   public function index()
   {
      $data = [
         'title' => "Pesanan",
         'content' => __CLASS__
      ];

      $this->view_layout(__CLASS__, $data);
   }

   public function content()
   {
      $data = [];
      $data['bb'] = [];
      $data['p'] = [];
      $data['b'] = [];
      $data['s'] = [];

      if (isset($_SESSION['customer_id'])) {
         $cust_id = $_SESSION['customer_id'];
         $where = "customer_id = '" . $cust_id . "' AND processing_step = 0 ORDER BY order_ref ASC";
         $data['bb'] = $this->db(0)->get_where("order_list", $where);

         $where_p = "customer_id = '" . $cust_id . "' AND processing_step = 1 ORDER BY order_ref ASC";
         $data['p'] = $this->db(0)->get_where("order_list", $where_p);

         $where_b = "customer_id = '" . $cust_id . "' AND processing_step = 3 ORDER BY order_ref ASC";
         $data['b'] = $this->db(0)->get_where("order_list", $where_b);

         $where_S = "customer_id = '" . $cust_id . "' AND processing_step = 2 ORDER BY order_ref ASC";
         $data['s'] = $this->db(0)->get_where("order_list", $where_S);
      }
      $this->view(__CLASS__, __CLASS__ . "/content", $data);
   }

   function bayar()
   {
      if (!isset($_SESSION['cart'])) {
         echo "Cart Kosong";
         exit();
      }

      $mode = $_POST['radio_kirim'];
      $hp = $_POST['hp'];
      $nama = $_POST['nama'];
      $alamat = $_POST['alamat'];

      switch ($mode) {
         case 1:
            $provinsi = 26;
            $kota = 350;
            $kecamatan = 0;
            $kurir = "Jemput Toko";
            $service = "";
            $ongkir = 0;
            break;
         case 2:
            $provinsi = 26;
            $kota = 350;
            $kecamatan = 0;
            $kurir = "Kurir Toko";
            $service = "Instan";
            $ongkir = $this->SETTING['ongkir_toko'];
            break;
         case 3:
            if (!isset($_POST['service'])) {
               echo "Lengkapi alamat/kurir terlebih dahulu!";
               exit();
            }
            $provinsi = $_POST['provinsi'];;
            $kota = $_POST['kota'];
            $kecamatan = $_POST['kecamatan'];
            $kurir = $_POST['via'];

            foreach ($_SESSION['ongkir'] as $k => $o) {
               if ($k == $_POST['service']) {
                  $service = $o['service'];
                  $ongkir = $o['cost'][0]['value'];
               }
            }
            break;
      }

      if (!isset($ongkir)) {
         echo "ERROR ONGKIR!";
         exit();
      }

      $where = "hp = '" . $hp . "'";
      $cust = $this->db(0)->get_where_row("customer", $where);
      if (isset($cust['hp'])) {
         $cust_id = $cust['customer_id'];
         $set = "name = '" . $nama . "', province = " . $provinsi . ", city = " . $kota . ", subdistrict = " . $kecamatan . ", address = '" . $alamat . "'";
         $where = "customer_id = '" . $cust_id . "'";
         $sql_c = $this->db(0)->update("customer", $set, $where);
      } else {
         $cust_id = date("Ymdhis") . rand(0, 9) . rand(0, 9);
         $cols = "customer_id, name, hp, province, city, subdistrict, address";
         $vals = "'" . $cust_id . "', '$nama', '$hp', $provinsi, $kota, $kecamatan, '$alamat'";
         $sql_c = $this->db(0)->insertCols("customer", $cols, $vals);
      }

      $subdistrict_ = $this->db(0)->get_where_row("_subdistrict", "subdistrict_id = " . $kecamatan)['subdistrict_name'];
      $city_ = $this->db(0)->get_where_row("_city", "city_id = " . $kota)['city_name'];
      $province_ = $this->db(0)->get_where_row("_province", "province_id = " . $provinsi)['province'];

      $full_address = $alamat . " [Kec. " . $subdistrict_ . " ] [Kota/Kab. " . $city_ . "] [Provinsi. " . $province_ . "]";

      if (!isset($_SESSION['customer_id'])) {
         $_SESSION['customer_id'] = $cust_id;
      }

      $ref = date("Ymdhis") . rand(0, 9) . rand(0, 9);
      $pay_code = rand(0, 9) . rand(0, 9);

      $total = 0;
      foreach ($_SESSION['cart'] as $c) {
         $subTotal = $c['total'];
         $total += $subTotal;

         $cols = "order_ref, group_id, product_id, product, detail, price, qty, total, weight, length, width, height, note, file, customer_id, metode_file, link_drive";
         $vals = "'" . $ref . "'," . $c['group_id'] . "," . $c['produk_id'] . ",'" . $c['produk'] . "','" . $c['detail'] . "'," . $c['harga'] . "," . $c['jumlah'] . "," . $subTotal . "," . $c['berat'] . "," . $c['panjang'] . "," . $c['lebar'] . "," . $c['tinggi'] . ",'" . $c['note'] . "','" . $c['file'] . "','" . $cust_id . "'," . $c['metode_file'] . ",'" . $c['link_drive'] . "'";
         $sql_o = $this->db(0)->insertCols("order_list", $cols, $vals);
      }

      $cols = "order_ref, courier, service, total, delivery, name, address, hp";
      $vals = "'$ref', '$kurir', '$service', $ongkir, $mode, '$nama', '$full_address', '$hp'";
      $sql_d = $this->db(0)->insertCols("delivery", $cols, $vals);

      $total += $ongkir;
      $payment = substr($total, 0, -2) . $pay_code;
      $cols = "order_ref, total, payment";
      $vals = "'" . $ref . "', $total, $payment";
      $sql_p = $this->db(0)->insertCols("payment", $cols, $vals);

      unset($_SESSION['cart']);
      unset($_SESSION['ongkir']);

      $produk = $c['produk'] . " - " . $c['detail'];
      $text = "*" . $this->WEB . "*\nOrderan masuk\nAn. " . $_SESSION['nama'] . "\n" . $produk . "\n" . $this->HOST . "/CS";
      $this->model('WA')->send($this->SETTING['notif_group'], $text);
      header("Location: " . $this->BASE_URL . "Bayar/index/" . $ref);
   }

   function konfirmasi_bayar($ref)
   {
      $where = "order_ref = '" . $ref . "'";
      $set = "payment_status = 1";
      $this->db(0)->update("payment", $set, $where);
      $text = "*" . $this->WEB . "*\n" . $_SESSION['nama'] . " meminta konfirmasi pembayaran\n" . $this->HOST . "/CS";
      $this->model('WA')->send($this->SETTING['notif_group'], $text);

      header("Location: " . $this->BASE_URL . "Pesanan");
   }
}
