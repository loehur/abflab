<?php

class Place extends Public_Variables
{
    public $api_key = "0cd76730-bbde-5d12-4f47-bf42373a";
    public $host = "https://api.goapi.io";

    public function provinsi()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->host . '/regional/provinsi',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_POSTFIELDS => array(
                'api_key' => $this->api_key
            ),
            CURLOPT_HTTPHEADER => array(
                'accept: application/json',
                'X-API-KEY: ' . $this->api_key
            )
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $res = json_decode($response, true);
        return $res;
    }
}
