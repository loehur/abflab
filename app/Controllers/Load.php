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
      if (isset($_SESSION['log']['hp'])) {
         $where = "hp = '" . $_SESSION['log']['hp'] . "'";
         $cust = $this->db(0)->get_where_row("customer", $where);
         if (!isset($_SESSION['log']['customer_id'])) {
            $_SESSION['log']['customer_id'] = $cust['customer_id'];
         }
         if (isset($cust['name'])) {
            echo ucfirst(strtok($cust['name'], " "));
         } else {
            unset($_SESSION['log']);
         }
      } else {
         echo "Account";
      }
   }

   function account_admin()
   {
      if (isset($_SESSION['log_admin'])) {
         echo $_SESSION['log_admin']['nama'];
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
