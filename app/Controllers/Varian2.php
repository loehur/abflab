<?php

class Varian2 extends Controller
{
   public function index($parse)
   {
      $data = [
         'title' => "Varian_2",
         'content' => __CLASS__,
         'parse' => $parse,
      ];

      $this->view_layout_produk(__CLASS__, $data);
   }

   function content($parse, $gid = null)
   {
      if (!isset($_SESSION['admin_produk'])) {
         $this->view(__CLASS__, __CLASS__ . "/login");
         exit();
      }

      $parse = base64_decode($parse);
      $parse = unserialize($parse);
      $vg1_id = $parse['vg1_id'];
      $v1_id = $parse['v1_id'];

      $data['grup'] = $this->db(0)->get_where("varian_grup_2", "vg1_id = " . $vg1_id);
      if ($gid == null) {
         foreach ($data['grup'] as $dg) {
            $gid = $dg['vg2_id'];
            break;
         }
      }

      $data['gid'] = $gid;
      $data['vg1_id'] = $vg1_id;
      $data['v1'] = $this->db(0)->get_where_row("varian_1", "varian_id = " . $v1_id);;
      $data['varian2'] = $this->db(0)->get_where("varian_2", "v1_id = " . $v1_id);
      $data['produk'] = $this->db(0)->get_where_row("produk", "produk_id = " . $parse['produk_id']);
      $this->view(__CLASS__, __CLASS__ . "/content", $data);
   }

   function tambah($gid, $v1_id)
   {
      $varian = $_POST['varian'];
      $harga = $_POST['harga'];
      $image = $_POST['image'];
      $berat = $_POST['berat'];
      $p = $_POST['p'];
      $l = $_POST['l'];
      $t = $_POST['t'];

      $cek = $this->db(0)->get_where_row("v2_head", "vg2_id = " . $gid . " AND v2_head = '" . $varian . "'");

      if (!isset($cek['v2_head_id'])) {
         $cols = "vg2_id, v2_head";
         $vals = $gid . ",'" . $varian . "'";
         $this->db(0)->insertCols("v2_head", $cols, $vals);
         $cek = $this->db(0)->get_where_row("v2_head", "vg2_id = " . $gid . " AND v2_head = '" . $varian . "'");
      }

      if (isset($cek['v2_head_id'])) {
         $cek2 = $this->db(0)->get_where("varian_2", "v2_head_id = " . $cek['v2_head_id'] . " AND vg2_id = " . $gid . " AND v1_id = " . $v1_id);
         if (count($cek2) == 0) {
            $cols = "v1_id, vg2_id, v2_head_id, harga, berat, img, p, l, t";
            $vals = $v1_id . "," . $gid . "," . $cek['v2_head_id'] . "," . $harga . "," . $berat . ",'" . $image . "'," . $p . "," . $l . "," . $t . "";
            $this->db(0)->insertCols("varian_2", $cols, $vals);
         } else {
            echo "Data sudah Ada";
            exit();
         }
      }

      echo 1;
   }
}
