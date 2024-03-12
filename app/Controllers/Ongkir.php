<?php

class Ongkir extends Controller
{
   public function __construct()
   {
   }

   function get_area($input = "marpoyan damai")
   {
      $curl = curl_init();

      curl_setopt_array($curl, array(
         CURLOPT_URL => 'https://api.biteship.com/v1/maps/areas?countries=ID&input=' . $input . '&type=single',
         CURLOPT_RETURNTRANSFER => true,
         CURLOPT_ENCODING => '',
         CURLOPT_MAXREDIRS => 10,
         CURLOPT_TIMEOUT => 0,
         CURLOPT_FOLLOWLOCATION => true,
         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
         CURLOPT_CUSTOMREQUEST => 'GET',
         CURLOPT_POSTFIELDS => array(),
         CURLOPT_HTTPHEADER => array(
            'Authorization: biteship_test.eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJuYW1lIjoicGVyYWh1MTIzNjU0IiwidXNlcklkIjoiNjU5ZTBiYmYzMDg3NjBkNTg3YzhhZDNjIiwiaWF0IjoxNzA5OTc2MjUwfQ.TlpFxcyW0ftiMyWL2b4KPRrFBUEA-zeq5F0h6QT2dxU',
            'content-type: application/json'
         )
      ));

      $response = curl_exec($curl);
      curl_close($curl);
      $res = json_decode($response, true);
      echo "<pre>";
      print_r($res);
      echo "</pre>";
   }

   function cek_ongkir()
   {
      $curl = curl_init();
      $params = [
         "origin_area_id" => "IDNP26IDNC346IDND4040IDZ28111",
         "destination_area_id" => "IDNP26IDNC142IDND764IDZ29212",
         "couriers" => "gojek,anteraja,jne,sicepat",
         "items" => [
            [
               "name" => "Shoes",
               "description" => "Black colored size 45",
               "value" => 199000,
               "length" => 30,
               "width" => 15,
               "height" => 20,
               "weight" => 200,
               "quantity" => 2
            ],
            [
               "name" => "Bag",
               "description" => "Black colored size 45",
               "value" => 199000,
               "length" => 30,
               "width" => 15,
               "height" => 20,
               "weight" => 200,
               "quantity" => 2
            ]
         ]
      ];

      $reques_body = json_encode($params);
      curl_setopt_array(
         $curl,
         [
            CURLOPT_URL => 'https://api.biteship.com/v1/rates/couriers',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $reques_body,
            CURLOPT_HTTPHEADER => [
               'Authorization: biteship_test.eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJuYW1lIjoicGVyYWh1MTIzNjU0IiwidXNlcklkIjoiNjU5ZTBiYmYzMDg3NjBkNTg3YzhhZDNjIiwiaWF0IjoxNzA5OTc2MjUwfQ.TlpFxcyW0ftiMyWL2b4KPRrFBUEA-zeq5F0h6QT2dxU',
               'content-type: application/json'
            ]
         ]
      );

      $response = curl_exec($curl);
      curl_close($curl);
      $res = json_decode($response, true);
      echo "<pre>";
      print_r($res);
      echo "</pre>";
   }

   function order()
   {
      $curl = curl_init();
      $params = [
         "origin_contact_name" => "ASIA BARU FOTO",
         "origin_contact_phone" => "08117677494",
         "origin_address" => "Jl. Jend. Sudirman No.331, Sumahilang, Kec. Pekanbaru Kota, Kota Pekanbaru",
         "origin_postal_code" => 28111,
         "origin_area_id" => "IDNP26IDNC346IDND4040IDZ28111",
         "origin_collection_method" => "pickup",
         "destination_contact_name" => "Pak Guru Photo",
         "destination_contact_phone" => "08170032123",
         "destination_address" => "Jl. Binakarya, No. 21, Tembilahan",
         "destination_note" => "Pinggir Jalan, Toko Pak Guru Photo",
         "destination_postal_code" => 29212,
         "destination_area_id " => "IDNP26IDNC142IDND764IDZ29212",
         "courier_company" => "jne",
         "courier_type" => "reg",
         "delivery_type" => "now",
         "order_note" => "jemput hari ini ya bang",
         "metadata" => [],
         "items" => [
            [
               "name" => "Shoes",
               "description" => "Black colored size 45",
               "value" => 199000,
               "length" => 30,
               "width" => 15,
               "height" => 20,
               "weight" => 200,
               "quantity" => 2
            ],
            [
               "name" => "Bag",
               "description" => "Black colored size 45",
               "value" => 199000,
               "length" => 30,
               "width" => 15,
               "height" => 20,
               "weight" => 200,
               "quantity" => 2
            ]
         ]
      ];

      $reques_body = json_encode($params);
      curl_setopt_array(
         $curl,
         [
            CURLOPT_URL => 'https://api.biteship.com/v1/orders',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $reques_body,
            CURLOPT_HTTPHEADER => [
               'Authorization: biteship_test.eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJuYW1lIjoicGVyYWh1MTIzNjU0IiwidXNlcklkIjoiNjU5ZTBiYmYzMDg3NjBkNTg3YzhhZDNjIiwiaWF0IjoxNzA5OTc2MjUwfQ.TlpFxcyW0ftiMyWL2b4KPRrFBUEA-zeq5F0h6QT2dxU',
               'content-type: application/json'
            ]
         ]
      );

      $response = curl_exec($curl);
      curl_close($curl);
      $res = json_decode($response, true);
      echo "<pre>";
      print_r($res);
      echo "</pre>";
   }

   function cek_order()
   {
      $curl = curl_init();
      $params = [];
      $reques_body = json_encode($params);
      curl_setopt_array(
         $curl,
         [
            CURLOPT_URL => 'https://api.biteship.com/v1/orders/65efd1405264e500129bfc89',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_POSTFIELDS => $reques_body,
            CURLOPT_HTTPHEADER => [
               'Authorization: biteship_test.eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJuYW1lIjoicGVyYWh1MTIzNjU0IiwidXNlcklkIjoiNjU5ZTBiYmYzMDg3NjBkNTg3YzhhZDNjIiwiaWF0IjoxNzA5OTc2MjUwfQ.TlpFxcyW0ftiMyWL2b4KPRrFBUEA-zeq5F0h6QT2dxU',
               'content-type: application/json'
            ]
         ]
      );

      $response = curl_exec($curl);
      curl_close($curl);
      $res = json_decode($response, true);
      echo "<pre>";
      print_r($res);
      echo "</pre>";
   }

   function cancel()
   {
      $curl = curl_init();
      $params = [
         "cancellation_reason" => "Ingin ganti barang",
      ];

      $reques_body = json_encode($params);
      curl_setopt_array(
         $curl,
         [
            CURLOPT_URL => 'https://api.biteship.com/v1/orders/65efd1405264e500129bfc89',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'DELETE',
            CURLOPT_POSTFIELDS => $reques_body,
            CURLOPT_HTTPHEADER => [
               'Authorization: biteship_test.eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJuYW1lIjoicGVyYWh1MTIzNjU0IiwidXNlcklkIjoiNjU5ZTBiYmYzMDg3NjBkNTg3YzhhZDNjIiwiaWF0IjoxNzA5OTc2MjUwfQ.TlpFxcyW0ftiMyWL2b4KPRrFBUEA-zeq5F0h6QT2dxU',
               'content-type: application/json'
            ]
         ]
      );

      $response = curl_exec($curl);
      curl_close($curl);
      $res = json_decode($response, true);
      echo "<pre>";
      print_r($res);
      echo "</pre>";
   }

   function pro()
   {
      $cek = $this->model("Place")->provinsi();
      echo "<pre>";
      print_r($cek);
      echo "</pre>";
   }
}
