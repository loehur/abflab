<?php

class JSON extends PC
{

   function provinsi()
   {
      $json = file_get_contents('assets/wilayah/provinsi.json');
      $json_data = json_decode($json, true);
      return $json_data;
   }

   function get($file)
   {
      $json = file_get_contents($file);
      $json_data = json_decode($json, true);
      return $json_data;
   }
}
