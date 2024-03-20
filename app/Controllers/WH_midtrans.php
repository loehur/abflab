<?php

class WH_midtrans extends Controller
{
   private $target_notif = null;

   public function __construct()
   {
      $this->target_notif = PC::NOTIF[PC::SETTING['production']];
   }

   function notification()
   {
      header('Content-Type: application/json; charset=utf-8');

      $json = file_get_contents('php://input');
      $data = json_decode($json, true);
      $res = [];
      if (isset($data['transaction_status'])) {

         $order_ref = $data['order_id'];
         $status = $data['transaction_status'];
         $tr_time = $data['transaction_time'];
         $tr_id = $data['transaction_id'];
         $fraud_status = $data['fraud_status'];

         $this->model('Log')->write("Order Ref: " . $order_ref . " New Status" . $status);

         $where = "order_ref = '" . $order_ref . "'";
         $set = "transaction_id = '" . $tr_id . "', transaction_status = '" . $status . "', transaction_time = '" . $tr_time . "', fraud_status = '" . $fraud_status . "'";
         $up = $this->db(0)->update("payment", $set, $where);

         if ($up['errno'] <> 0) {
            $text = "ERROR PAYMENT. update DB when trigger New Status, Order Ref: " . $order_ref . ", New Status: " . $status . " " . $up['error'];
            $this->model('Log')->write($text);
            $this->model('WA')->send($this->target_notif, $text);
         }

         switch ($status) {
            case 'settlement':
               $os = 1; // paid
               $text_o = "VitaPictura, order baru *DITERIMA*. REF#" . $order_ref . " " . PC::HOST . "/CS";
               $this->model('WA')->send($this->target_notif, $text_o);
               break;
            case 'deny';
            case 'cancel';
            case 'refund';
            case 'partial_refund';
            case 'expire';
            case 'failure';
               $os = 4; // cancel
               $text_o = "VitaPictura, order *CANCELED* by " . $status . " Payment. REF#" . $order_ref . " " . PC::HOST . "/CS";
               $this->model('WA')->send($this->target_notif, $text_o);
            default:
               $os = 0; //proses
               break;
         }

         $where = "order_ref = '" . $order_ref . "'";
         $set = "order_status = " . $os;
         $up2 = $this->db(0)->update("order_step", $set, $where);
         if ($up2['errno'] <> 0) {
            $text = "ERROR UPDATE ORDER STEP PAYMENT. update DB when trigger New Status, Order Ref: " . $order_ref . ", New Status ORDER STEP: " . $status . " " . $up2['error'];
            $this->model('Log')->write($text);
            $this->model('WA')->send($this->target_notif, $text);
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
}
