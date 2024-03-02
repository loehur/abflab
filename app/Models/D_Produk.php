<?php

class D_Produk
{
    function main()
    {
        $data = [
            0 => [
                "produk" => "Cetak Foto",
                "group" => 0,
                "icon" => "",
                "img" => "CETAK ",
                "img_detail" => "cetak_foto",
                "link" => 0,
                "target" => "_self",
                "varian" => "Cetak_Foto",
                "detail" => [
                    0 => [
                        "judul" => 'Deskripsi',
                        "konten" => 'cetak_foto'
                    ],
                    1 => [
                        "judul" => 'Ukuran Cetak',
                        "konten" => 'ukuran_cetak'
                    ]
                ],
                "berat" => 0,
                "harga" => 0
            ],
            1 => [
                "produk" => "Acrylic Figure",
                "group" => 50,
                "img" => "acrylic_figure",
                "img_detail" => "acrylic_figure",
                "link" => 0,
                "target" => "_self",
                "varian" => "Acrylic_Figure",
                "detail" => [
                    0 => [
                        "judul" => 'Deskripsi',
                        "konten" => 'acrylic_figure'
                    ],
                ],
                "berat" => 0,
                "harga" => 0
            ],
            2 => [
                "produk" => "Frame Kolase",
                "group" => 1,
                "img" => "frame_kolase-2",
                "img_detail" => "frame_kolase",
                "link" => 0,
                "target" => "_self",
                "varian" => "Frame_Kolase",
                "detail" => [
                    0 => [
                        "judul" => 'Deskripsi',
                        "konten" => 'frame_kolase'
                    ],
                ],
                "berat" => 0,
                "harga" => 0
            ],
            3 => [
                "produk" => "Greeting Card",
                "group" => 50,
                "img" => "greeting_card",
                "img_detail" => "greeting_card",
                "link" => 0,
                "target" => "_self",
                "varian" => "Greeting_Card",
                "detail" => [
                    0 => [
                        "judul" => 'Deskripsi',
                        "konten" => 'greeting_card'
                    ],
                ],
                "berat" => 0,
                "harga" => 0
            ],
            4 => [
                "produk" => "Print Frame",
                "group" => 1,
                "img" => "frame print",
                "img_detail" => "print_frame",
                "link" => 0,
                "target" => "_self",
                "varian" => "Print_Frame",
                "detail" => [
                    0 => [
                        "judul" => 'Deskripsi',
                        "konten" => 'print_frame'
                    ],
                    1 => [
                        "judul" => 'Ukuran Print Frame',
                        "konten" => 'ukuran_print_frame'
                    ],
                ],
                "berat" => 0,
                "harga" => 0
            ],
            5 => [
                "produk" => "Plank Parkir",
                "group" => 51,
                "img" => "plank_parkir",
                "img_detail" => "plank_parkir",
                "mal" => ['MAL_PALNG_PARKIR'],
                "link" => 0,
                "target" => "_self",
                "varian" => "Plang_Parkir",
                "detail" => [
                    0 => [
                        "judul" => 'Deskripsi',
                        "konten" => 'plang_parkir'
                    ],
                ],
                "berat" => 0,
                "harga" => 0

            ],
            6 => [
                "produk" => "Cetak Kanvas",
                "group" => 0, // Cetak
                "img" => "kanvas 01",
                "img_detail" => "canvas",
                "link" => 0,
                "target" => "_self",
                "varian" => "Cetak_Canvas",
                "detail" => [
                    0 => [
                        "judul" => 'Deskripsi',
                        "konten" => 'cetak_canvas'
                    ],
                    1 => [
                        "judul" => 'Ukuran Kanvas',
                        "konten" => 'ukuran_kanvas'
                    ],
                ],
                "berat" => 0,
                "harga" => 0
            ],
            7 => [
                "produk" => "Wood Print",
                "group" => 0, // Cetak
                "img" => "Woodprint",
                "img_detail" => "wood_print",
                "link" => 0,
                "target" => "_self",
                "varian" => "Wood_Print",
                "detail" => [
                    0 => [
                        "judul" => 'Deskripsi',
                        "konten" => 'wood_print'
                    ],
                ],
                "berat" => 0,
                "harga" => 0
            ],
            8 => [
                "produk" => "Cetak PVC Card",
                "group" => 0, // Cetak
                "img" => "cetakpvc",
                "img_detail" => "pvc",
                "mal" => ['mal_cd'],
                "link" => 0,
                "target" => "_self",
                "varian" => "Cetak_PVC_Card",
                "detail" => [
                    0 => [
                        "judul" => 'Deskripsi',
                        "konten" => 'cetak_pvc_card'
                    ],
                ],
                "berat" => 0,
                "harga" => 0
            ],
            9 => [
                "produk" => "Cetak CD",
                "group" => 0, // Cetak
                "img" => "cd",
                "img_detail" => "cetak_cd",
                "mal" => ['mal_cd'],
                "link" => 0,
                "target" => "_self",
                "varian" => "Cetak_Cd",
                "detail" => [
                    0 => [
                        "judul" => 'Deskripsi',
                        "konten" => 'cetak_cd'
                    ],
                ],
                "berat" => 0,
                "harga" => 0
            ],

            12 => [
                "produk" => "Frame Border",
                "group" => 0, // Cetak
                "img" => "frameborder",
                "img_detail" => "frameborder",
                "link" => 0,
                "target" => "_self",
                "varian" => "Frame_Border",
                "detail" => [
                    0 => [
                        "judul" => 'Deskripsi',
                        "konten" => 'frame_border'
                    ],
                ],
                "berat" => 0,
                "harga" => 0
            ],
            13 => [
                "produk" => "APG",
                "group" => 2,
                "img" => "apg",
                "img_detail" => "apg",
                "mal" => ['10 sheet.rar', '15 sheet.rar', '20 sheet.rar'],
                "link" => 0,
                "target" => "_self",
                "varian" => "APG",
                "detail" => [
                    0 => [
                        "judul" => 'Deskripsi',
                        "konten" => 'apg'
                    ],
                ],
                "berat" => 0,
                "harga" => 0
            ],
        ];

        return $data;
    }

    function get($id_produk)
    {
        $data = [];
        $d = $this->main();
        foreach ($d as $k => $m) {
            if ($k == $id_produk) {
                $data[$k] = $m;
            }
        }
        return $data;
    }
}
