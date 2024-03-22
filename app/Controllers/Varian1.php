<?php

class Varian1 extends Controller
{
   public $access = false;
   public function __construct()
   {
      if (isset($_SESSION['log_admin'])) {
         if (in_array(1, $_SESSION['log_admin']['access']) == true) {
            $this->access = true;
         }
      }
   }

   public function index($parse, $parse2 = null)
   {
      $data = [
         'title' => "Varian_1",
         'content' => __CLASS__,
         'parse' => $parse,
         'parse2' => $parse2
      ];

      $this->view_layout_admin(__CLASS__, $data);
   }

   function content($parse, $gid = null)
   {
      if ($this->access == false) {
         $this->view(__CLASS__, __CLASS__ . "/login");
         exit();
      }

      $data['produk'] = $this->db(0)->get_where_row("produk", "produk_id = " . $parse);
      $data['grup'] = $this->db(0)->get_where("varian_grup_1", "produk_id = " . $parse);

      if (count($data['grup']) <> 0) {
         if ($gid == null) {
            foreach ($data['grup'] as $dg) {
               $gid = $dg['vg1_id'];
               break;
            }
         }
         $data['varian1'] = $this->db(0)->get_where("varian_1", "vg1_id = " . $gid);
      } else {
         $data['varian1'] = [];
      }

      $data['gid'] = $gid;

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

   function tambah_head($produk_id)
   {
      $name = $_POST['name'];

      $cek = $this->db(0)->get_where("varian_grup_1", "produk_id = " . $produk_id . " AND vg = '" . $name . "'");
      if (count($cek) == 0) {
         $cols = "produk_id, vg";
         $vals = $produk_id . ",'" . $name . "'";
         $this->db(0)->insertCols("varian_grup_1", $cols, $vals);
      } else {
         echo "Data sudah Ada";
         exit();
      }

      echo 1;
   }
}
