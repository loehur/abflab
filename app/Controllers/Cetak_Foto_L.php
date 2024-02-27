<?php

class Cetak_Foto_L extends Controller
{
   public function __construct()
   {
   }

   public function index()
   {
      $data = [
         'title' => "Cetak",
         'content' => __CLASS__
      ];

      $this->view_layout(__CLASS__, $data);
   }

   public function content($parse)
   {
      $data = [];
      $this->view(__CLASS__, __CLASS__ . "/content", $data);
   }
}
