<?php

class Load extends Controller
{
   function cart()
   {
      if (isset($_SESSION['cart'])) {
         $cart = $_SESSION['cart'];
         $count = count($cart);
         echo '<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">' . $count . '</span>';
      }
   }

   function account()
   {
      if (isset($_SESSION['hp'])) {
         $where = "hp = '" . $_SESSION['hp'] . "'";
         $cust = $this->db(0)->get_where_row("customer", $where);
         if (!isset($_SESSION['customer_id'])) {
            $_SESSION['customer_id'] = $cust['customer_id'];
         }
         if (isset($cust['name'])) {
            echo ucfirst(strtok($cust['name'], " "));
         } else {
            unset($_SESSION['hp']);
         }
      }
   }

   function account_cs()
   {
      if (isset($_SESSION['cs'])) {
         echo $_SESSION['cs']['name'];
      }
   }

   function account_admin_produk()
   {
      if (isset($_SESSION['admin_produk'])) {
         echo $_SESSION['admin_produk']['name'];
      }
   }

   function spinner($tipe)
   {
      $this->load("Spinner", $tipe);
   }

   function produk_deskripsi($produk)
   {
      $this->load("Produk_Deskripsi", $produk);
   }
}
