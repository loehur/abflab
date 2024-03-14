<?php

class Session extends Controller
{
   function login()
   {
      if (!isset($_SESSION['log']['hp'])) {
         $where = "hp = '" . $_POST['hp'] . "'";
         $cust = $this->db(0)->get_where_row("customer", $where);
         if (isset($cust['customer_id'])) {
            $_SESSION['log'] = $cust;
            echo 1;
         } else {
            echo "Anda belum terdaftar dengan no " . $_POST['hp'];
         }
      } else {
         unset($_SESSION['log']);
         echo 2;
      }
   }

   function add_cart()
   {
      $id = $_POST['id'];
      $mode = $_POST['mode'];
      if ($mode == 1) {
         $_SESSION['cart'][$id]['jumlah'] += 1;
      } else {
         if ($_SESSION['cart'][$id]['jumlah'] <= 1) {
            unset($_SESSION['cart'][$id]);
            if (count($_SESSION['cart']) == 0) {
               unset($_SESSION['cart']);
            }
            exit();
         } else {
            $_SESSION['cart'][$id]['jumlah'] -= 1;
         }
      }

      $_SESSION['cart'][$id]['total'] = $_SESSION['cart'][$id]['harga'] * $_SESSION['cart'][$id]['jumlah'];
   }
}
