<?php

class Place extends Public_Variables
{
    public $api_key = "35d4eafdc92d38e08e4e6c3c8992e04253770d9b3a8ac28300898b48e47334ca";
    public $host = "https://api.binderbyte.com";

    public function provinsi()
    {
        $url = $this->host . '/wilayah/provinsi?api_key=' . $this->api_key;
        return $this->curl_get($url);
    }

    public function kota($id)
    {
        $url = $this->host . '/wilayah/kabupaten?id_provinsi=' . $id . '&api_key=' . $this->api_key;
        return $this->curl_get($url);
    }

    public function kecamatan($id)
    {
        $url = $this->host . '/wilayah/kecamatan?id_kabupaten=' . $id . '&api_key=' . $this->api_key;
        return $this->curl_get($url);
    }

    function curl_get($url)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $res = json_decode($response, true);
        return $res;
    }
}
