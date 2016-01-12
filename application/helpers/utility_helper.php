<?php
/**
 * Created by PhpStorm.
 * User: guizmo
 * Date: 09/01/2016
 * Time: 10:47
 */

if (!function_exists('pr')) {
    function pr($param)
    {
        echo "<pre>";
        print_r($param);
        echo "</pre>";
    }
}

if (!function_exists('asset_url')) {
    function asset_url(){
        return base_url().'assets/';
    }
}