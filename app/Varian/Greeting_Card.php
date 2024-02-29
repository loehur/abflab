<?php

class Greeting_Card
{
    function main()
    {
        $data = [
            "Motif" => [
                "Wisuda" => [
                    "berat" => 6,
                    "harga" => 0,
                    "img" => "1",
                ],
                "Pernikah" => [
                    "berat" => 4,
                    "harga" => 0,
                    "img" => "2",
                ],
                "ulang tahun" => [
                    "berat" => 4,
                    "harga" => 0,
                    "img" => "3",
                ],
                "anniversary" => [
                    "berat" => 4,
                    "harga" => 0,
                    "img" => "4",
                ],
                "new born" => [
                    "berat" => 4,
                    "harga" => 0,
                    "img" => "5",
                ],
            
           
            ],
            "Ukuran" => [
                "14x18cm" => [
                    "berat" => 4,
                    "harga" => 75000,
                ],

            ]
        ];

        return $data;
    }
}
