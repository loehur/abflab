<?php

class API extends Controller
{
   function get_area($input)
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
            'Authorization: biteship_live.eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJuYW1lIjoidml0YXBpY3R1cmFfYWJmX2tleWFwaSIsInVzZXJJZCI6IjY1OWUwYmJmMzA4NzYwZDU4N2M4YWQzYyIsImlhdCI6MTcxMDIyNDQ2NH0.KiqfLU-GtU0RTCv-FZ-UglkXfvY3KpsLCqENrvUmoHY',
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

   function get_area_id($id)
   {
      $curl = curl_init();

      curl_setopt_array($curl, array(
         CURLOPT_URL => 'https://api.biteship.com/v1/maps/areas/' . $id,
         CURLOPT_RETURNTRANSFER => true,
         CURLOPT_ENCODING => '',
         CURLOPT_MAXREDIRS => 10,
         CURLOPT_TIMEOUT => 0,
         CURLOPT_FOLLOWLOCATION => true,
         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
         CURLOPT_CUSTOMREQUEST => 'GET',
         CURLOPT_POSTFIELDS => array(),
         CURLOPT_HTTPHEADER => array(
            'Authorization: biteship_live.eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJuYW1lIjoidml0YXBpY3R1cmFfYWJmX2tleWFwaSIsInVzZXJJZCI6IjY1OWUwYmJmMzA4NzYwZDU4N2M4YWQzYyIsImlhdCI6MTcxMDIyNDQ2NH0.KiqfLU-GtU0RTCv-FZ-UglkXfvY3KpsLCqENrvUmoHY',
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

      $items[0] = [
         "name" => "document",
         "description" => "usb card",
         "value" => 200000,
         "length" => 6,
         "width" => 4,
         "height" => 1,
         "weight" => 400,
         "quantity" => 1
      ];

      $params = [
         "origin_latitude" => 0.4592214531209369,
         "origin_longitude" => 101.45248264074326,
         "destination_latitude" => 0.48023028211479485,
         "destination_longitude" => 101.37518284110435,
         "couriers" => "gojek",
         "items" => $items
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
               'Authorization: biteship_live.eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJuYW1lIjoidml0YXBpY3R1cmFfYWJmX2tleWFwaSIsInVzZXJJZCI6IjY1OWUwYmJmMzA4NzYwZDU4N2M4YWQzYyIsImlhdCI6MTcxMDIyNDQ2NH0.KiqfLU-GtU0RTCv-FZ-UglkXfvY3KpsLCqENrvUmoHY',
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

      $items[0] = [
         "name" => "document",
         "description" => "usb card",
         "value" => 200000,
         "length" => 6,
         "width" => 4,
         "height" => 1,
         "weight" => 400,
         "quantity" => 1
      ];

      $params = [
         "origin_contact_name" => "RIZA",
         "origin_contact_phone" => "085278114125",
         "origin_address" => "Eureka Creatio, Samping J&L Parfum",
         "origin_postal_code" => 28284,
         "origin_coordinate" => [
            "latitude" =>  0.4592214531209369,
            "longitude" => 101.45248264074326
         ],
         "destination_contact_name" => "Raihan Azari",
         "destination_contact_phone" => "082183588415",
         "destination_address" => "Kos Aqila Dekat Unri",
         "destination_note" => "",
         "destination_postal_code" => 28292,
         "destination_coordinate" => [
            "latitude" => 0.48023028211479485,
            "longitude" => 101.37518284110435
         ],
         "courier_company" => "gojek",
         "courier_type" => 'instant',
         "delivery_type" => "now",
         "order_note" => "",
         "metadata" => [],
         "items" => $items
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
               'Authorization: ' . PC::API_KEY['biteship'][1],
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

   function update($id)
   {
      $curl = curl_init();
      $params = [
         "origin_address" => "Jalan Kayu Manis, No. 23",
      ];

      $reques_body = json_encode($params);
      curl_setopt_array(
         $curl,
         [
            CURLOPT_URL => 'https://api.biteship.com/v1/orders/' . $id,
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

   function cancel($id)
   {
      $curl = curl_init();
      $params = [
         "cancellation_reason" => "Ingin ganti barang",
      ];

      $reques_body = json_encode($params);
      curl_setopt_array(
         $curl,
         [
            CURLOPT_URL => 'https://api.biteship.com/v1/orders/' . $id,
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

   function tracking($id)
   {
      $curl = curl_init();
      $params = [];

      $reques_body = json_encode($params);
      curl_setopt_array(
         $curl,
         [
            CURLOPT_URL => 'https://api.biteship.com/v1/trackings/' . $id,
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

   function public_tracking($waybill, $courier)
   {
      $curl = curl_init();
      $params = [];

      $reques_body = json_encode($params);
      curl_setopt_array(
         $curl,
         [
            CURLOPT_URL => 'https://api.biteship.com/v1/trackings/' . $waybill . '/couriers/' . $courier,
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
}
