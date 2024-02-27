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
         echo ucfirst(strtok($cust['name'], " "));
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
