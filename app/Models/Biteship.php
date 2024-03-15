<?php

class Biteship extends Public_Variables
{
    private $host = "https://api.biteship.com";
    private $key = null;

    public function __construct()
    {
        $this->key = $this->api_key['biteship'][$this->SETTING['production']];
    }

    function get_area($input)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->host . '/v1/maps/areas?countries=ID&input=' . base64_decode($input) . '&type=single',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_POSTFIELDS => array(),
            CURLOPT_HTTPHEADER => array(
                'Authorization: ' . $this->key,
                'content-type: application/json'
            )
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $res = json_decode($response, true);

        if (isset($res['areas'])) {
            foreach ($res['areas'] as $k => $v) {
                if (strtoupper($v['administrative_division_level_3_name']) <> strtoupper($input)) {
                    unset($res[$k]);
                }
            }
        } else {
            $res['areas'] = [];
        }

        return $res['areas'];
    }

    function get_area_id($id)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->host . '/v1/maps/areas/' . $id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_POSTFIELDS => array(),
            CURLOPT_HTTPHEADER => array(
                'Authorization: ' . $this->key,
                'content-type: application/json'
            )
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $res = json_decode($response, true);
        if (!isset($res['areas'])) {
            $res['areas'] = [];
        }
        return $res['areas'];
    }

    function cek_ongkir($dest_id, $dest_lat, $dest_long)
    {
        $items = [];
        $count = 0;
        foreach ($_SESSION['cart'] as $c) {
            $items[$count] = [
                "name" => $c['produk'],
                "description" => $c['detail'],
                "value" => $c['total'],
                "length" => $c['panjang'],
                "width" => $c['lebar'],
                "height" => $c['tinggi'],
                "weight" => $c['berat'],
                "quantity" => $c['jumlah']
            ];
            $count += 1;
        }

        $curl = curl_init();
        $params = [
            "origin_area_id" => $this->SETTING['origin_id'],
            "destination_area_id" => $dest_id,
            "origin_latitude" => $this->SETTING['lat'],
            "origin_longitude" => $this->SETTING['long'],
            "destination_latitude" => $dest_lat,
            "destination_longitude" => $dest_long,
            "couriers" => $this->SETTING['couriers'],
            "items" => $items
        ];

        $reques_body = json_encode($params);
        curl_setopt_array(
            $curl,
            [
                CURLOPT_URL => $this->host . '/v1/rates/couriers',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $reques_body,
                CURLOPT_HTTPHEADER => [
                    'Authorization: ' . $this->key,
                    'content-type: application/json'
                ]
            ]
        );

        $response = curl_exec($curl);
        curl_close($curl);
        $res = json_decode($response, true);

        if (isset($res['pricing'])) {
            return $res['pricing'];
        } else {
            return [];
        }
    }
}
