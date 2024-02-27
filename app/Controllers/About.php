<?php

class About extends Controller
{
   public function __construct()
   {
   }

   public function index()
   {
      $data = [
         'title' => 'About',
         'content' => __CLASS__,
      ];

      $this->view_layout(__CLASS__, $data);
   }

   public function content($parse)
   {
      $data = [];
      $this->view(__CLASS__, __CLASS__ . "/content", $data);
   }
}
