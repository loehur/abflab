<?php

class WH_biteship extends Controller
{
   public function price()
   {
      header('Content-Type: application/json; charset=utf-8');

      $json = file_get_contents('php://input');
      $data = json_decode($json, true);
      $res = [];
      if (isset($data['price'])) {
         $this->model('Log')->write($data['price']);
         $res = [
            "status" => "ok",
            "new_price" => $data['price']
         ];
      } else {
         $res = [
            "status" => "error",
            "mesaage" => "bad parameters"
         ];
      }

      print_r(json_encode($res));
   }
}
