<?php

class Afiliator extends Controller
{
   public function __construct() {}

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
      $d = $_SESSION['log'];
      $cust_id = $d['customer_id'];
      $data['aff'] = $this->db(0)->get_where_row("afiliasi_code", "id = '" . $cust_id . "'");
      if (isset($data['aff']['code'])) {
         $col = "fee_aff";
         $data['fee'] = $this->db(0)->sum_col_where("diskon_aff", $col, "code = '" . $data['aff']['code'] . "' AND stat = 1");
      } else {
         $data['fee'] = 0;
      }

      $data['produk'] = $this->db(0)->get("produk", 'produk_id');
      $this->view(__CLASS__, __CLASS__ . "/content", $data);
   }

   function get_code()
   {
      $rand = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
      $arr_code = array_rand($rand, 5);
      $code = "";
      foreach ($arr_code as $c) {
         $code .= $rand[$c];
      }

      $d = $_SESSION['log'];
      $cust_id = $d['customer_id'];

      $cols = "id, code";
      $vals = "'" . $cust_id . "','" . $code . "'";
      $in = $this->db(0)->insertCols("afiliasi_code", $cols, $vals);
      if ($in['errno'] <> 0) {
         echo $in['error'];
      } else {
         echo 0;
      }
   }

   function cek_promo()
   {
      $code = strtoupper($_POST['code']);
      $cek = $this->db(0)->get_where_row("afiliasi_code", "code = '" . $code . "' AND id <> '" . $_SESSION['log']['customer_id'] . "'");
      if (isset($cek['code'])) {
         foreach ($_SESSION['cart'] as $key => $c) {
            if (isset(PC::DISKON_AFILIATOR_ITEM[$c['produk_id']])) {
               $dDiskon = PC::DISKON_AFILIATOR_ITEM[$c['produk_id']];
               if ($dDiskon['EX'] > date("Ymd")) {
                  $_SESSION['diskon_aff'][$key]  = [
                     "code" => $code,
                     "produk" => $c['produk_id'],
                     "jumlah" => $c['total'],
                     "fee_aff" => round(($c['total'] * $dDiskon['FA']) / 100),
                     "diskon_buyer" => round(($c['total'] * $dDiskon['FB']) / 100),
                  ];
               }
            }
         }
         if (!isset($_SESSION['diskon_aff'])) {
            echo "Maaf, sedang tidak ada promo";
            exit();
         } else {
            echo 0;
         }
      } else {
         echo "Code Promo tidak ditemukan";
         exit();
      }
   }
}
