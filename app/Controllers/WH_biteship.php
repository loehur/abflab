<?php

class WH_biteship extends Controller
{
   function status()
   {
      header('Content-Type: application/json; charset=utf-8');

      $json = file_get_contents('php://input');
      $data = json_decode($json, true);
      $res = [];
      if (isset($data['status'])) {
         $order_id = $data['order_id'];
         $status = $data['status'];
         $this->model('Log')->write("Order ID: " . $order_id . " New Status" . $status);

         $where = "order_id = '" . $order_id . "'";
         $set = "delivery_status = '" . $status . "'";
         $up = $this->db(0)->update("delivery", $set, $where);

         if ($up['errno'] <> 0) {
            $text = "ERROR. update DB when trigger New Status, Order ID: " . $order_id . ", New Status: " . $status;
            $this->model('Log')->write($text);
            $this->model('WA')->send($text);
         }

         $res = [
            "status" => "ok",
            "message" => "status updated"
         ];
      } else {
         $res = [
            "status" => "failed",
            "message" => "unknown [status]"
         ];
      }

      print_r(json_encode($res));
   }

   function price()
   {
      header('Content-Type: application/json; charset=utf-8');

      $json = file_get_contents('php://input');
      $data = json_decode($json, true);
      $res = [];
      if (isset($data['price'])) {
         $price = $data['price'];
         $order_id = $data['order_id'];
         $this->model('Log')->write("Order ID: " . $data['order_id'] . " New Price" . $price);

         $warning = "WARNING. Price Updated! Order ID: " . $order_id . ", New Price: " . $price;
         $this->model('WA')->send($warning);

         $where = "order_id = '" . $order_id . "'";
         $set = "price = " . $price;
         $up = $this->db(0)->update("payment", $set, $where);

         if ($up['errno'] <> 0) {
            $text = "ERROR. update DB when trigger New Price, Order ID: " . $order_id . ", New Price: " . $price;
            $this->model('Log')->write($text);
            $this->model('WA')->send($text);
         }

         $res = [
            "status" => "ok",
            "message" => "price updated"
         ];
      } else {
         $res = [
            "status" => "failed",
            "message" => "unknown [price]"
         ];
      }

      print_r(json_encode($res));
   }

   function waybill()
   {
      header('Content-Type: application/json; charset=utf-8');

      $json = file_get_contents('php://input');
      $data = json_decode($json, true);
      $res = [];
      if (isset($data['courier_waybill_id'])) {
         $order_id = $data['order_id'];
         $waybill_id = $data['courier_waybill_id'];
         $status = $data['status'];

         $this->model('Log')->write("Order ID: " . $order_id . " waybill_id: " . $waybill_id);

         $where = "order_id = '" . $order_id . "'";
         $set = "delivery_status = '" . $status . "', waybill_id = '" . $waybill_id . "'";
         $up = $this->db(0)->update("delivery", $set, $where);

         if ($up['errno'] <> 0) {
            $text = "ERROR. update DB when trigger waybill_id, Order ID: " . $order_id . ", waybill_id: " . $waybill_id;
            $this->model('Log')->write($text);
            $this->model('WA')->send($text);
         }

         $res = [
            "status" => "ok",
            "message" => "waybill updated"
         ];
      } else {
         $res = [
            "status" => "failed",
            "message" => "unknown [courier_waybill_id]"
         ];
      }

      print_r(json_encode($res));
   }
}