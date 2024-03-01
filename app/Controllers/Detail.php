<?php

class Detail extends Controller
{
   public function __construct()
   {
   }

   public function index($id_produk)
   {
      $title = "Undefined";
      $produk = $this->model("D_Produk")->get($id_produk);
      $title = $produk[$id_produk]['produk'];
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
      $data['produk'] = $parse;
      $data['data'] = $this->model("D_Produk")->get($parse);
      $this->view(__CLASS__, __CLASS__ . "/content", $data);
   }

   public function upload()
   {
      $produk_id = $_POST['produk'];

      $d =  $this->model("D_Produk")->get($produk_id);

      $cek = $d[$produk_id];
      $group_id = $cek['group'];
      $produk_name = $cek['produk'];

      $jumlah = $_POST['jumlah'];
      $harga = $cek['harga'];
      $berat = $cek['berat'];
      $panjang = (isset($cek['panjang'])) ? (($cek['panjang'] == 0) ? 1 : $cek['panjang']) : 1;

      $lebar = (isset($cek['lebar'])) ? (($cek['lebar'] == 0) ? 1 : $cek['lebar']) : 1;
      $tinggi = (isset($cek['tinggi'])) ? (($cek['tinggi'] == 0) ? 1 : $cek['tinggi']) : 1;
      $note = $_POST['note'];
      $detail = "";

      // print_r($_POST);
      // exit();

      if ($cek['varian']) {
         $data_ = $this->varian($cek['varian'])->main();
         foreach ($data_ as $k => $v) {
            $selName1 = str_replace(" ", "_", $k);
            $input = $_POST["v1_" . $selName1];
            foreach ($v as $k_ => $v_) {
               if ($k_ == $input) {
                  $harga += ($v_['harga']);
                  $berat += ($v_['berat']);

                  $panjang += (isset($v_['panjang'])) ? $v_['panjang'] : 0;
                  $lebar += (isset($v_['lebar'])) ? $v_['lebar'] : 0;
                  $tinggi += (isset($v_['tinggi'])) ? $v_['tinggi'] == 0 : 0;

                  $detail .= " " . $k . "(" . $k_ . ")";

                  if (isset($v_['varian'])) {
                     foreach ($v_['varian'] as $k2 => $v2) {
                        $input2 = $_POST["v2_" . str_replace(" ", "_", $k2)];
                        foreach ($v2 as $k3 => $v3) {
                           if ($k3 == $input2) {
                              $harga += $v3['harga'];
                              $berat += $v3['berat'];


                              $panjang += (isset($v3['panjang'])) ? $v3['panjang'] : 0;
                              $lebar += (isset($v3['lebar'])) ? $v3['lebar'] : 0;
                              $tinggi += (isset($v3['tinggi'])) ? $v3['tinggi'] == 0 : 0;

                              $detail .= ", " . $k2 . "(" . $k3 . ")";
                           }
                        }
                     }
                  }
               }
            }
         }
      }

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

         $cart = [];
         $new_cart = [
            "group_id" => $group_id,
            "produk_id" => $produk_id,
            "produk" => $produk_name,
            "detail" => $detail,
            "jumlah" => $jumlah,
            "harga" => $harga,
            "total" => $jumlah * $harga,
            "berat" => $jumlah * $berat,
            "panjang" => $panjang,
            "lebar" => $lebar,
            "tinggi" => $tinggi,
            "note" => $note,
            "file" => $imageUploadPath
         ];

         if (in_array($fileType, $allowExt) === true) {
            if ($fileSize < 400000000) { //400mb

               move_uploaded_file($imageTemp, $imageUploadPath);
               if (isset($_SESSION['cart'])) {
                  $cart = $_SESSION['cart'];
                  array_push($cart, $new_cart);
                  $_SESSION['cart'] = $cart;
               } else {
                  array_push($cart, $new_cart);
                  $_SESSION['cart'] = $cart;
               }
               echo 1;
            } else {
               echo "GAGAL! FILE LEBIH BESAR DARI 400MB";
            }
         } else {
            echo "FILE EXT/TYPE TIDAK DIPERBOLEHKAN";
         }
      } else {
         $cart = [];
         if (isset($_POST['gdrive'])) {
            $file = $_POST['gdrive'];
         } else {
            $file = "";
         }
         $new_cart = [
            "group_id" => $group_id,
            "produk_id" => $produk_id,
            "produk" => $produk_name,
            "detail" => $detail,
            "jumlah" => $jumlah,
            "harga" => $harga,
            "total" => $jumlah * $harga,
            "berat" => $jumlah * $berat,
            "panjang" => $panjang,
            "lebar" => $lebar,
            "tinggi" => $tinggi,
            "note" => $note,
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
         echo 1;
      }
   }

   function loadVarian()
   {
      $data = $_POST['data'];
      $data = base64_decode($data);
      $data = unserialize($data);
      // echo "<pre>";
      // print_r($data);
      // echo "</pre>";



      $this->view(__CLASS__, __CLASS__ . "/varian", $data);
   }
}
