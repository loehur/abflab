<?php

class Session extends Controller
{
   function set()
   {
      $name = $_POST['name'];
      $value = $_POST['value'];

      $_SESSION[$name] = $value;
   }

   function login()
   {
      if (!isset($_SESSION['hp'])) {
         $where = "hp = '" . $_POST['hp'] . "'";
         $cust = $this->db(0)->get_where_row("customer", $where);
         if (isset($cust['hp'])) {
            $_SESSION['hp'] = $cust['hp'];
            $_SESSION['nama'] = $cust['name'];
            $_SESSION['alamat'] = $cust['address'];
            $_SESSION['customer_id'] = $cust['customer_id'];
            echo 1;
         } else {
            $_SESSION['hp'] = $_POST['hp'];
            echo "Anda belum terdaftar dengan no " . $_POST['hp'];
         }
      } else {
         unset($_SESSION['hp']);
         unset($_SESSION['nama']);
         unset($_SESSION['alamat']);
         unset($_SESSION['customer_id']);
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
         if ($_SESSION['cart'][$id]['jumlah'] == 1) {
            unset($_SESSION['cart'][$id]);
            exit();
         } else {
            $_SESSION['cart'][$id]['jumlah'] -= 1;
         }
      }

      $_SESSION['cart'][$id]['total'] = $_SESSION['cart'][$id]['harga'] * $_SESSION['cart'][$id]['jumlah'];
   }
}
