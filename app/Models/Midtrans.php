<?php

class Midtrans extends Public_Variables
{
    public $merchant_id = "G508678094";
    public $key_client = "SB-Mid-client-yGhmZSPkw-EDcVl4";
    public $key_server = "SB-Mid-server-ZHst9ED0Coy3bXI47MtueQQD";
    public $host = "https://app.sandbox.midtrans.com/snap/v1/transactions";

    function token($es, $amount, $name, $email, $hp)
    {
        $curl = curl_init();
        $id = rand(1000000, 9999999);
        $name_ = explode(" ", $name);
        $fname = $name_[0];
        $lname = "";
        $c = count($name_);
        if ($c > 1) {
            foreach ($name_ as $key => $n) {
                if ($key <> 0) {
                    if ($key == ($c - 1)) {
                        if ($c == 2) {
                            $lname = $n;
                        } else {
                            $lname += $n;
                        }
                    } else {
                        $lname += $n . " ";
                    }
                }
            }
        }

        $params = [
            "transaction_details" => [
                "order_id" => $id,
                "gross_amount" => $amount
            ],
            "credit_card" => [
                "secure" => true
            ],
            "customer_details" => [
                "first_name" => $fname,
                "last_name" => $lname,
                "email" => $email,
                "phone" => $hp
            ]
        ];

        $reques_body = json_encode($params);

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->host,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $reques_body,
            CURLOPT_HTTPHEADER => [
                'Accept: application/json',
                'Authorization: Basic ' . base64_encode($this->key_server . ":"),
                'Content-Type: application/json'
            ]
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $res = json_decode($response, true);
        return $res;
    }
}
