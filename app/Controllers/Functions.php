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
}
