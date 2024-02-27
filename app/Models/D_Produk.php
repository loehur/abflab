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
                "detail" => ['cetak_foto', 'ukuran_cetak'], // File di Views/Load/Produk_Deskripsi
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
                "detail" => ['acrylic_figure'],
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
                "detail" => ['frame_kolase'],
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
                "detail" => ['greeting_card'],
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
                "detail" => ['print_frame', 'ukuran_print_frame'],
                "berat" => 0,
                "harga" => 0
            ],
            5 => [
                "produk" => "Plank Parkir",
                "group" => 51,
                "img" => "plank_parkir",
                "img_detail" => "plank_parkir",
                "link" => 0,
                "target" => "_self",
                "varian" => "Plang_Parkir",
                "detail" => ['plang_parkir'],
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
                "detail" => ['cetak_canvas', 'ukuran_kanvas'],
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
                "detail" => ['wood_print'],
                "berat" => 0,
                "harga" => 0
            ],
            8 => [
                "produk" => "Cetak PVC Card",
                "group" => 0, // Cetak
                "img" => "cetakpvc",
                "img_detail" => "pvc",
                "link" => 0,
                "target" => "_self",
                "varian" => "Cetak_PVC_Card",
                "detail" => ['cetak_pvc_card'],
                "berat" => 0,
                "harga" => 0
            ],
            9 => [
                "produk" => "Cetak CD",
                "group" => 0, // Cetak
                "img" => "cd",
                "img_detail" => "cetak_cd",
                "link" => 0,
                "target" => "_self",
                "varian" => "Cetak_Cd",
                "detail" => ['cetak_cd'],
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
                "detail" => ['frame_border'],
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
                "detail" => ['apg'],
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
