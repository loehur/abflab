<?php

require 'app/Config/PC.php';

class Controller extends PC
{

    public $v_viewer, $v_content, $v_load;

    public function view_layout($con, $data = [])
    {
        require_once "app/Views/Layout/main.php";
    }

    public function view_layout_admin($con, $data = [])
    {
        require_once "app/Views/Layout_Admin/main.php";
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
