<?php

class D_Group
{
    function main()
    {
        $data = [
            0 => [
                "name" => "Cetak",
                "aktif" => "Cetak",
                "icon" => "<i class='fa-solid fa-print'></i>"
            ],
            1 => [
                "name" => "Frame",
                "aktif" => "Frame",
                "icon" => ""
            ],
            2 => [
                "name" => "Album",
                "aktif" => "Album",
                "icon" => ""
            ],
            50 => [
                "name" => "Plakat",
                "aktif" => "Plakat",
                "icon" => ""
            ],
            51 => [
                "name" => "Display",
                "aktif" => "Display",
                "icon" => ""
            ],
        ];

        return $data;
    }
}
