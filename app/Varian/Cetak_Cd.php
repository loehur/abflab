<?php

class Cetak_Cd
{
    function main()
    {
        $data = [
            "pilihan" => [
                "CD" => [
                    "berat" => 0,
                    "harga" => 0,
                    "img" => "1",
                ],
                "DVD" => [
                    "berat" => 0,
                    "harga" => 0,
                    "img" => "2",
                ],
            ],
            "jumlah" => [
                "50 pcs" => [
                    "berat" => 300,
                    "harga" => 250000,
                ],
                "100 pcs" => [
                    "berat" => 300,
                    "harga" => 500000,
                ],
            ]
        ];

        return $data;
    }
}
