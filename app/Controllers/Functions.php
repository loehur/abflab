<?php

class Functions extends Controller
{
   public function updateCell()
   {
      $id = $_POST['id'];
      $value = $_POST['value'];
      $col = $_POST['col'];
      $primary = $_POST['primary'];
      $tb = $_POST['tb'];
      $set = $col . " = '" . $value . "'";
      $where = $primary . " = " . $id;
      print_r($this->db(0)->update($tb, $set, $where));
   }

   public function deleteCell()
   {
      $id = $_POST['id'];
      $primary = $_POST['primary'];
      $tb = $_POST['tb'];
      $where = $primary . " = " . $id;
      print_r($this->db(0)->delete_where($tb, $where));
   }

   public function updateCell_des()
   {
      $id = $_POST['id'];
      $value = $_POST['value'];

      $des_ok = [];
      $deskripsi = $value;
      $des = explode(",", $deskripsi);
      foreach ($des as $key => $d) {
         $des2 = explode("|", $d);
         if (isset($des2[0]) && isset($des2[1])) {
            $des_ok[$key] = [
               "judul" => $des2[0],
               "konten" => $des2[1],
            ];
         } else {
            continue;
         }
      }

      $value = serialize($des_ok);

      $col = $_POST['col'];
      $primary = $_POST['primary'];
      $tb = $_POST['tb'];
      $set = $col . " = '" . $value . "'";
      $where = $primary . " = " . $id;
      print_r($this->db(0)->update($tb, $set, $where));
   }

   public function updateCell_mal()
   {
      $id = $_POST['id'];
      $value = $_POST['value'];

      $mal = $value;
      if (strlen($mal) > 0) {
         $mal = serialize(explode(",", $mal));
      }

      $value = $mal;
      $col = $_POST['col'];
      $primary = $_POST['primary'];
      $tb = $_POST['tb'];
      $set = $col . " = '" . $value . "'";
      $where = $primary . " = " . $id;
      print_r($this->db(0)->update($tb, $set, $where));
   }

   public function updateCell_grup()
   {
      $id = $_POST['id'];
      $value = $_POST['value'];

      foreach (PC::Group as $k => $dg) {
         if ($k == $value) {
            $col = $_POST['col'];
            $primary = $_POST['primary'];
            $tb = $_POST['tb'];
            $set = $col . " = '" . $value . "'";
            $where = $primary . " = " . $id;
            print_r($this->db(0)->update($tb, $set, $where));
         }
      }
   }
}
