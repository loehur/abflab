<?php

class WA extends Public_Variables
{
    public function send($target, $text)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('target' => $target, 'message' => $text),
            CURLOPT_HTTPHEADER => array('Authorization: GPGCCYK7X!wKwfcD4ATE')
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $res = json_decode($response, true);
        return $res;
    }
}
