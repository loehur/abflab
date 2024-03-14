<?php

class GeoIP extends Public_Variables
{
    public $api_key = "3693521b32e34dd4a0f3dee567c0e59f";
    public $host = "https://api.geoapify.com";

    public function longlat()
    {
        $url = $this->host . "/v1/ipinfo?&apiKey=" . $this->api_key;
        $get = $this->curl_get($url);
        if (isset($get['location'])) {
            $data['lat'] = $get['location']['latitude'];
            $data['long'] = $get['location']['longitude'];
        } else {
            $data['lat'] = 0.5395;
            $data['long'] = 101.4457;
        }

        return $data;
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
