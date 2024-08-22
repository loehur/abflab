<?php

class Cron extends Controller
{
   public function expired()
   {
      $where = "order_status = 0";
      $step = $this->db(0)->get_where("order_step", $where);
      foreach ($step as $s) {
         $order_time = $s['insertTime'];
         $order_ref = $s['order_ref'];
         $expired = false;

         $t1 = strtotime($s['insertTime']);
         $t2 = strtotime(date("Y-m-d H:i:s"));
         $diff = $t2 - $t1;
         $hours = round($diff / (60 * 60), 1);

         if ($hours > 25) {
            $expired = true;
         }
         if ($expired == true) {
            $where = "order_ref = '" . $order_ref . "'";
            $set = "order_status = 4";
            $up2 = $this->db(0)->update("order_step", $set, $where);
            if ($up2['errno'] <> 0) {
               $text = "ERROR UPDATE ORDER STEP PAYMENT. update DB when trigger New Status, Order Ref: " . $order_ref . ", New Status ORDER STEP: Expired, " . $up2['error'];
               $this->model('Log')->write($text);
            }
         }
         sleep(1);
      }
   }

   public function cek()
   {
      $where = "proses = '' AND token <> '' AND status <> 5 AND id_api = '' ORDER BY insertTime ASC";
      $data = $this->model('M_DB_1')->get_where('notif', $where);

      foreach ($data as $dm) {
         $id_notif = $dm['id_notif'];
         $hp = $dm['phone'];
         $text = $dm['text'];

         echo $id_notif . ": [" . $hp . "] " . $text . "<br>";
      }
   }

   function wa($hp = '081268098300')
   {
      $token = 'M2tCJhb_mcr5tHFo5r4B';
      $res = $this->model("M_WA")->send($hp, "Whatsapp OK", $token);
      echo "<pre>";
      print_r($res);
      echo "</pre><br>";

      if (isset($res["id"])) {
         foreach ($res["id"] as $v) {
            $status = $res["process"];
            echo "ID: " . $v . ", Status: " . $status . "<br>";
         }
      }
   }
}
