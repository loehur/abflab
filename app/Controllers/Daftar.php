<?php

class Daftar extends Controller
{

   public function index()
   {
      $data = [
         'title' => "Daftar",
         'content' => __CLASS__
      ];

      $this->view_layout(__CLASS__, $data);
   }

   public function content()
   {
      $data = [];
      if (isset($_SESSION['tools']['provinsi'])) {
         $data['provinsi'] = $_SESSION['tools']['provinsi'];
      } else {
         $cek = $this->model("Place")->provinsi();
         if (isset($cek['value'])) {
            $_SESSION['tools']['provinsi'] = $cek['value'];
            $data['provinsi'] = $_SESSION['tools']['provinsi'];
         }
      }

      if (isset($_SESSION['log'])) {
         $get = $_SESSION['log'];
         $_SESSION['tools']['location']['lat'] =  $get['latt'];
         $_SESSION['tools']['location']['long'] = $get['longt'];
      }

      if (isset($_SESSION['tools']['location'])) {
         $data['geo'] =  $_SESSION['tools']['location'];
      } else {
         $data['geo'] = $this->model("GeoIP")->longlat();
         $_SESSION['tools']['location'] =  $data['geo'];
      }


      $this->view(__CLASS__, __CLASS__ . "/content", $data);
   }
}