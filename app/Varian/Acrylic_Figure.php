<?php

class Acrylic_Figure
{
    function main()
    {
        $data = [
            "Ukuran" => [
                "10x10cm" => [
                    "berat" => 4,
                    "harga" => 65000,
                    "varian" => [
                        "Tambahan Layer" =>
                        [
                            "Logo/Tulisan" =>
                            [
                                "berat" => 0,
                                "harga" => 13000,
                                "img" => "logo",
                            ],
                            "Layer Full" =>
                            [
                                "berat" => 0,
                                "harga" => 65000,
                                "img" => "full",
                            ],
                            "Layer Full + Logo/Tulisan" =>
                            [
                                "berat" => 0,
                                "harga" => 78000,
                                "img" => "full_logo",
                            ],
                        ],

                    ],
                ],
                "15x10cm" => [
                    "berat" => 6,
                    "harga" => 75000,
                    "varian" => [
                        "Tambahan Layer" =>
                        [
                            "Logo/Tulisan" =>
                            [
                                "berat" => 0,
                                "harga" => 15000,
                                "img" => "logo",
                            ],
                            "Layer Full" =>
                            [
                                "berat" => 0,
                                "harga" => 75000,
                                "img" => "full",
                            ],
                            "Layer Full + Logo/Tulisan" =>
                            [
                                "berat" => 0,
                                "harga" => 90000,
                                "img" => "full_logo",
                            ],
                        ],

                    ],
                ],
                "20x10cm" => [
                    "berat" => 6,
                    "harga" => 90000,
                    "varian" => [
                        "Tambahan Layer" =>
                        [
                            "Logo/Tulisan" =>
                            [
                                "berat" => 0,
                                "harga" => 18000,
                                "img" => 2,
                            ],
                            "Layer Full" =>
                            [
                                "berat" => 0,
                                "harga" => 90000,
                                "img" => 3,
                            ],
                            "Layer Full + Logo/Tulisan" =>
                            [
                                "berat" => 0,
                                "harga" => 108000,
                                "img" => 4,
                            ],
                        ],

                    ],
                ],
                "20x15cm" => [
                    "berat" => 6,
                    "harga" => 125000,
                    "varian" => [
                        "Tambahan Layer" =>
                        [
                            "Logo/Tulisan" =>
                            [
                                "berat" => 1,
                                "harga" => 25000,
                                "img" => 2,
                            ],
                            "Layer Full" =>
                            [
                                "berat" => 0,
                                "harga" => 125000,
                                "img" => 3,
                            ],
                            "Layer Full + Logo/Tulisan" =>
                            [
                                "berat" => 0,
                                "harga" => 150000,
                                "img" => 4,
                            ],
                        ],

                    ],
                ],
                "20x20cm" => [
                    "berat" => 6,
                    "harga" => 145000,
                    "varian" => [
                        "Tambahan Layer" =>
                        [
                            "Logo/Tulisan" =>
                            [
                                "berat" => 0,
                                "harga" => 29000,
                                "img" => 2,
                            ],
                            "Layer Full" =>
                            [
                                "berat" => 0,
                                "harga" => 145000,
                                "img" => 3,
                            ],
                            "Layer Full + Logo/Tulisan" =>
                            [
                                "berat" => 0,
                                "harga" => 174000,
                                "img" => 4,
                            ],
                        ],

                    ],
                ],
            ]
        ];

        return $data;
    }
}
