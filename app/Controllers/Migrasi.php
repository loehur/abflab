<?php

class Pindah extends Controller
{
   function insert_varian()
   {
      $produk_id = [];
      $data = [];

      echo "insert vg1<br>";
      foreach ($data as $k => $d) {
         $cek_vg1 = $this->db(0)->get_where("varian_grup_1", "produk_id = " . $produk_id . " AND vg = '" . $k . "'");
         if (count($cek_vg1) == 0) {
            $cols = "produk_id, vg";
            $vals = $produk_id . ",'" . $k . "'";
            print_r($this->db(0)->insertCols("varian_grup_1", $cols, $vals)['errno']);
            echo "<br>";
         }
      }
      $vg_1 = $this->db(0)->get_where("varian_grup_1", "produk_id = " . $produk_id);

      echo "<br><br>insert v1<br>";
      foreach ($vg_1 as $vg1) {
         foreach ($data[$vg1['vg']] as $k => $d) {
            $cek_v1 = $this->db(0)->get_where("varian_1", "vg1_id = " . $vg1['vg1_id'] . " AND varian = '" . $k . "'");
            if (count($cek_v1) == 0) {
               $cols = "vg1_id, varian, berat, harga, img";
               $berat = $d['berat'];
               $img = (isset($d['img']) ? $d['img'] : '');
               $harga = $d['harga'];
               $vals = $vg1['vg1_id'] . ",'" . $k . "',$berat,$harga,'$img'";
               print_r($this->db(0)->insertCols("varian_1", $cols, $vals)['errno']);
               echo "<br>";
            }
         }
      }

      echo "<br><br>insert vg2<br>";
      foreach ($vg_1 as $vg1) {
         foreach ($data[$vg1['vg']] as $k => $d1) {
            if (isset($d1['varian'])) {
               foreach ($d1['varian'] as $kv2 => $v2) {
                  $cek = $this->db(0)->get_where("varian_grup_2", "vg1_id = " . $vg1['vg1_id'] . " AND vg = '" . $kv2 . "'");
                  if (count($cek) == 0) {
                     $cols = "vg1_id, vg";
                     $vals = $vg1['vg1_id'] . ",'" . $kv2 . "'";
                     print_r($this->db(0)->insertCols("varian_grup_2", $cols, $vals)['errno']);
                     echo "<br>";
                  }
               }
            }
         }
      }
      echo "<br><br>insert vh2<br>";
      foreach ($vg_1 as $vg1) {
         foreach ($data[$vg1['vg']] as $k => $d1) {
            if (isset($d1['varian'])) {
               foreach ($d1['varian'] as $kv2 => $v2) {
                  foreach ($v2 as $kv2_ => $v2_2) {
                     $vg2 = $this->db(0)->get_where("varian_grup_2", "vg1_id = " . $vg1['vg1_id'] . " AND vg = '" . $kv2 . "'");
                     foreach ($vg2 as $vg2v) {
                        $cek2 = $this->db(0)->get_where("v2_head", "vg2_id = " . $vg2v['vg2_id'] . " AND v2_head = '" . $kv2_ . "'");
                        if (count($cek2) == 0) {
                           $cols = "vg2_id, v2_head";
                           $vals = $vg2v['vg2_id'] . ",'" . $kv2_ . "'";
                           print_r($this->db(0)->insertCols("v2_head", $cols, $vals)['errno']);
                           echo "<br>";
                        }
                     }
                  }
               }
            }
         }
      }

      echo "<br><br>insert v2<br>";

      foreach ($vg_1 as $vg1) {
         foreach ($data[$vg1['vg']] as $k => $d1) {
            $v1_d = $this->db(0)->get_where_row("varian_1", "varian = '" . $k . "'");
            if (isset($d1['varian'])) {
               foreach ($d1['varian'] as $kv2 => $v2) {
                  $vg2 = $this->db(0)->get_where_row("varian_grup_2", "vg = '" . $kv2 . "'");
                  foreach ($v2 as $kv2_ => $v2_2) {
                     $v2_h = $this->db(0)->get_where_row("v2_head", "v2_head = '" . $kv2_ . "'");
                     $cek3 = $this->db(0)->get_where("varian_2", "v1_id = " . $v1_d['varian_id'] . " AND vg2_id = " . $vg2['vg2_id'] . " AND v2_head_id = " . $v2_h['v2_head_id']);
                     if (count($cek3) == 0) {
                        $cols = "v1_id, vg2_id, v2_head_id, harga, berat, img";
                        $berat = $v2_2['berat'];
                        $harga = $v2_2['harga'];
                        $img = (isset($v2_2['img']) ? $v2_2['img'] : '');
                        $vals = $v1_d['varian_id'] . "," . $vg2['vg2_id'] . "," . $v2_h['v2_head_id'] . ",$harga,$berat,'$img'";
                        print_r($this->db(0)->insertCols("varian_2", $cols, $vals)['errno']);
                        echo "<br>";
                     }
                  }
               }
            }
         }
      }
   }
}
