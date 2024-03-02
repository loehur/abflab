<?php

class Checkout extends Controller
{
   public function __construct()
   {
   }

   public function index()
   {
      $data = [
         'title' => "Checkout",
         'content' => __CLASS__
      ];

      $this->view_layout(__CLASS__, $data);
   }

   public function content($parse)
   {
      $data = [];

      //JANGAN DIHAPUS, SUATU SAAT AKAN DIBUTUHKAN KEMBALI (LUHUR)
      // if (!isset($_SESSION["provinsi"]) && !is_array($_SESSION["provinsi"])) {
      //    $_SESSION["provinsi"] = $this->model("RajaOngkir")->provinsi();
      // }

      // $data['provinsi'] = json_decode($_SESSION["provinsi"], JSON_PRETTY_PRINT);
      // $data['provinsi'] = $data['provinsi']['rajaongkir']['results'];

      // $cols = "province_id, province";
      // foreach ($data['provinsi'] as $dp) {
      //    $val = $dp['province_id'] . ",'" . $dp['province'] . "'";
      //    $this->db(0)->insertCols("_province", $cols, $val);
      // }

      $data['provinsi'] = $this->db(0)->get("_province");
      $this->view(__CLASS__, __CLASS__ . "/content", $data);
   }

   public function kota($id_provinsi)
   {
      //JANGAN DIHAPUS, SUATU SAAT AKAN DIBUTUHKAN KEMBALI (LUHUR)
      // $data = $this->model("RajaOngkir")->kota($id_provinsi);
      // $data = json_decode($data, JSON_PRETTY_PRINT);
      // $data = $data['rajaongkir']['results'];

      // $cols = "city_id, province_id, province, type, city_name, postal_code";
      // foreach ($data as $d) {
      //    $val = $d['city_id'] . "," . $d['province_id'] . ",'" . $d['province'] . "','" . $d['type'] . "','" . $d['city_name'] . "','" . $d['postal_code'] . "'";
      //    $this->db(0)->insertCols("_city", $cols, $val);
      // }

      $data = $this->db(0)->get_where("_city", "province_id = " . $id_provinsi);
      $this->view(__CLASS__, __CLASS__ . "/list_kota", $data);
   }

   public function kecamatan($id_kota)
   {
      //cek dl ada gk di db
      $cek = $this->db(0)->get_where("_subdistrict", "city_id = " . $id_kota);

      if (count($cek) == 0) {
         $data = $this->model("RajaOngkir")->kecamatan($id_kota);
         $data = json_decode($data, JSON_PRETTY_PRINT);
         $data = $data['rajaongkir']['results'];

         $cols = "subdistrict_id, province_id, province, city_id, city, type, subdistrict_name";
         foreach ($data as $d) {
            $val = $d['subdistrict_id'] . "," . $d['province_id'] . ",'" . $d['province'] . "'," . $d['city_id'] . ",'" . $d['city'] . "','" . $d['type'] . "','" . $d['subdistrict_name'] . "'";
            $this->db(0)->insertCols("_subdistrict", $cols, $val);
         }
      } else {
         $data = $cek;
      }

      $this->view(__CLASS__, __CLASS__ . "/list_kecamatan", $data);
   }

   public function cost($destination, $courier, $weight = 1000, $p = 1, $l = 1, $t = 1)
   {
      $data_ = $this->model("RajaOngkir")->cost($destination, $courier, $weight, $p, $l, $t);
      $data = json_decode($data_, JSON_PRETTY_PRINT);
      $data['ori'] = $data['rajaongkir']['results'][0]['costs'];

      $_SESSION['ongkir'] = $data['ori'];

      $this->view(__CLASS__, __CLASS__ . "/list_service", $data);
   }
}
