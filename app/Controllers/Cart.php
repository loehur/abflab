<?php

class Cart extends Controller
{
   public function __construct()
   {
   }

   public function index()
   {
      $data = [
         'title' => "Cart",
         'content' => __CLASS__
      ];

      $this->view_layout(__CLASS__, $data);
   }

   public function content($parse)
   {
      $data = [];
      $this->view(__CLASS__, __CLASS__ . "/content", $data);
   }

   function clear()
   {
      unset($_SESSION['cart']);
      $this->index();
   }
}
