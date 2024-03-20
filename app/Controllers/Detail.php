<?php

class Detail extends Controller
{
   private $target_notif = null;

   public function __construct()
   {
      $this->target_notif = PC::NOTIF[PC::SETTING['production']];
   }

   public function index($id_produk)
   {
      $title = "Undefined";
      $produk = $this->db(0)->get_where_row("produk", "produk_id = " . $id_produk);
      $title = $produk['produk'];
      $data = [
         'title' => $title,
         'content' => __CLASS__,
         'parse' => $id_produk
      ];

      $this->view_layout(__CLASS__, $data);
   }

   public function content($parse)
   {
      $data = [];
      $data['v2_h'] =
         $data['produk'] = $parse;
      $data['data'] = $this->db(0)->get_where_row("produk", "produk_id = " . $parse);
      $this->view(__CLASS__, __CLASS__ . "/content", $data);
   }

   public function upload()
   {
      if (isset($_SESSION['cart_key'])) {
         unset($_SESSION['cart_key']);
      }

      $produk_id = $_POST['produk'];

      $cek = $this->db(0)->get_where_row("produk", "produk_id = " . $produk_id);
      $group_id = $cek['grup'];
      $produk_name = $cek['produk'];
      $metode_file = $_POST['metode_file'];

      $jumlah = $_POST['jumlah'];
      $harga = $cek['harga'];
      $berat = $cek['berat'];

      $panjang = $cek['p'];
      $lebar = $cek['l'];
      $tinggi = $cek['t'];

      $note = $_POST['note'];
      $detail = "";

      $vg_1 = $this->db(0)->get_where("varian_grup_1", "produk_id = " . $produk_id);

      foreach ($vg_1 as $v) {
         $input = $_POST["v1_" . $v['vg1_id']];

         $v_ = $this->db(0)->get_where_row("varian_1", "varian_id = " . $input);

         $harga += ($v_['harga']);
         $berat += ($v_['berat']);

         $panjang += $v_['p'];
         $lebar += $v_['l'];
         $tinggi += $v_['t'];

         $detail .= " " . $v['vg'] . "(" . $v_['varian'] . ")";

         $vg2 = $this->db(0)->get_where("varian_grup_2", "vg1_id = " . $v['vg1_id']);
         foreach ($vg2 as $v2) {
            if (!isset($_POST["v2_" . $v2['vg2_id']])) {
               break;
            }
            $input2 = $_POST["v2_" . $v2['vg2_id']];
            $v3 = $this->db(0)->get_where_row("varian_2", "varian_id = " . $input2);

            if (isset($v3['harga'])) {
               $harga += $v3['harga'];
               $berat += $v3['berat'];

               $panjang += $v3['p'];
               $lebar += $v3['l'];
               $tinggi += $v3['t'];

               $v2_h = $this->db(0)->get_where("v2_head", "vg2_id = " . $v2['vg2_id']);
               foreach ($v2_h as $value) {
                  if ($value['v2_head_id'] == $v3['v2_head_id']) {
                     $v2h_name = $value['v2_head'];
                  }
               }

               $detail .= ", " . $v2['vg'] . "(" . $v2h_name . ")";
            }
         }
      }

      $link_drive = "";
      if (isset($_POST['link_drive'])) {
         $link_drive = $_POST['link_drive'];
      }

      $file = "";

      if (isset($_FILES['file'])) {

         $uploads_dir = "files/order/" . date("Y-m-d");
         //BUAT FOLDER KALAU BELUM ADA
         if (!file_exists($uploads_dir)) {
            mkdir($uploads_dir, 0777, TRUE);
         }

         $file_ = $_FILES['order'];
         $imageTemp = $_FILES['file']['tmp_name'];
         $file_name = basename($file_['name']);
         $imageUploadPath =  $uploads_dir . '/' . rand(0, 9) . rand(0, 9) . "_" . $file_name;
         $allowExt   = array('png', 'jpg', 'jpeg', 'PNG', 'JPG', 'JPEG', 'zip', 'rar', 'ZIP', 'RAR');
         $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION);
         $fileSize   = $file_['size'];
         $file = $imageUploadPath;

         if (in_array($fileType, $allowExt) === true) {
            if ($fileSize < 400000000) { //400mb
               move_uploaded_file($imageTemp, $imageUploadPath);
            } else {
               echo "MAX FILE SIZE 400MB";
               exit();
            }
         } else {
            echo "ALLOWED FILE EXT (.png .jpg .jpeg .zip .rar)";
            exit();
         }
      }

      if ($harga == 0) {
         echo "Maaf, produk ini terkendala sistem, dan sedang dalam perbaikan";
         $text = "*Warning*\nProduk " . $produk_name . " Error. Customer terkendala Order";
         $this->model('WA')->send($this->target_notif, $text);
         exit();
      }

      $cart = [];
      $new_cart = [
         "group_id" => $group_id,
         "produk_id" => $produk_id,
         "produk" => $produk_name,
         "detail" => $detail,
         "jumlah" => $jumlah,
         "harga" => $harga,
         "total" => $jumlah * $harga,
         "berat" => $berat,
         "panjang" => $panjang / 10,
         "lebar" => $lebar / 10,
         "tinggi" => $tinggi / 10,
         "note" => $note,
         "metode_file" => $metode_file,
         "link_drive" => $link_drive,
         "file" => $file
      ];

      if (isset($_SESSION['cart'])) {
         $cart = $_SESSION['cart'];
         array_push($cart, $new_cart);
         $_SESSION['cart'] = $cart;
      } else {
         array_push($cart, $new_cart);
         $_SESSION['cart'] = $cart;
      }

      //up freq
      $set = "freq = freq+1";
      $whereSort = "produk_id = " . $produk_id;
      $this->db(0)->update("produk", $set, $whereSort);

      echo 1;
   }

   function loadVarian($id_produk)
   {
      $get = unserialize($_POST['data']);
      $vg1_id = $get['vg1_id'];
      $data['v'] = $this->db(0)->get_where("varian_grup_2", "vg1_id = " . $vg1_id);
      $data['id'] = $get['v1_id'];;
      $this->view(__CLASS__, __CLASS__ . "/varian", $data);
   }
}
