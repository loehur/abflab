<?php

class Print_Frame
{
    function main()
    {
        $data = [
            "Motif" => [
                "Merdeka" => [
                    "berat" => 4,
                    "harga" => 2500,
                    "varian" => [
                        "Ukuran" => [
                            "10R" =>
                            [
                                "berat" => 10,
                                "harga" => 0,
                            ],
                            "20R" =>
                            [
                                "berat" => 10,
                                "harga" => 0,
                            ],
                        ]
                    ]
                ],
            ]
        ];

        return $data;
    }
}
