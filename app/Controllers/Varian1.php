<?php

class Varian1 extends Controller
{
   public function index($parse)
   {
      $data = [
         'title' => "Varian_1",
         'content' => __CLASS__,
         'parse' => $parse
      ];

      $this->view_layout_produk(__CLASS__, $data);
   }

   function content($parse, $gid = null)
   {
      if (!isset($_SESSION['admin_produk'])) {
         $this->view(__CLASS__, __CLASS__ . "/login");
         exit();
      }

      $data['produk'] = $this->db(0)->get_where_row("produk", "produk_id = " . $parse);
      $data['grup'] = $this->db(0)->get_where("varian_grup_1", "produk_id = " . $parse);

      if ($gid == null) {
         foreach ($data['grup'] as $dg) {
            $gid = $dg['vg1_id'];
            break;
         }
      }

      $data['gid'] = $gid;
      $data['varian1'] = $this->db(0)->get_where("varian_1", "vg1_id = " . $gid);
      $this->view(__CLASS__, __CLASS__ . "/content", $data);
   }

   function tambah($gid)
   {
      $varian = $_POST['varian'];
      $harga = $_POST['harga'];
      $image = $_POST['image'];
      $berat = $_POST['berat'];
      $p = $_POST['p'];
      $l = $_POST['l'];
      $t = $_POST['t'];

      $cek = $this->db(0)->get_where("varian_1", "vg1_id = " . $gid . " AND varian = '" . $varian . "'");
      if (count($cek) == 0) {
         $cols = "vg1_id, varian, harga, berat, img, p, l, t";
         $vals = $gid . ",'" . $varian . "'," . $harga . "," . $berat . ",'" . $image . "'," . $p . "," . $l . "," . $t . "";
         $this->db(0)->insertCols("varian_1", $cols, $vals);
      } else {
         echo "Data sudah Ada";
         exit();
      }

      echo 1;
   }
}
