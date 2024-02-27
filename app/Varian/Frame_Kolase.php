<?php

class Frame_Kolase
{
    function main()
    {
        $data = [
            "Tema" => [
                "Reuni" => [
                    "berat" => 6,
                    "harga" => 0,
                    "img" => "r",
                ],
                "Baby" => [
                    "berat" => 4,
                    "harga" => 0,
                    "img" => "b",
                ],
            ],
            "Orientasi" => [
                "Portrait" => [
                    "berat" => 6,
                    "harga" => 0,
                    "img" => "p",
                ],
                "Landscape" => [
                    "berat" => 4,
                    "harga" => 0,
                    "img" => "l",
                ],
            ],
            "Varian" => [
                "Frame collage" => [
                    "berat" => 6,
                    "harga" => 145000,
                    "img" => "polos",
                ],
                "Frame collage+cetak poto" => [
                    "berat" => 4,
                    "harga" => 167500,
                    "img" => "paper",
                ],
                "Frame collage+cetak pvc" => [
                    "berat" => 6,
                    "harga" => 370000,
                    "img" => "pvc",
                ],
            ]
        ];

        return $data;
    }
}
