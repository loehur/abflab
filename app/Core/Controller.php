<?php

require 'app/Config/Public_Variables.php';

class Controller extends Public_Variables
{

    public $v_viewer, $v_content, $v_load;

    public function view_layout($con, $data = [])
    {
        require_once "app/Views/Layout/main.php";
    }

    public function view_layout_cs($con, $data = [])
    {
        require_once "app/Views/Layout_CS/main.php";
    }
    public function view_layout_produk($con, $data = [])
    {
        require_once "app/Views/Layout_Produk/main.php";
    }

    public function view($con, $file, $data = [])
    {
        require_once "app/Views/Pages/" . $file . ".php";
    }

    public function load($dir, $file)
    {
        require_once "app/Views/Load/" . $dir . "/" . $file . ".php";
    }

    public function model($file)
    {
        require_once "app/Models/" . $file . ".php";
        return new $file();
    }

    public function db($db = 0)
    {
        $file = "M_DB";
        require_once "app/Models/" . $file . ".php";
        return new $file($db);
    }
}
