<?php 


class Helpers {

    public static function dnd($data)
    {
        echo '<pre>';
        var_dump($data);
        echo '<pre>';
        die();
    }

    public static function currentPage()
    {
        $currentPage = $_SERVER["REQUEST_URI"];
        if($currentPage == SROOT || $currentPage == SROOT.'home/index'){
            $currentPage = SROOT .  'home';
        }
        return $currentPage;
    }

    public static function getObjectProperties($obj)
    {
        return get_object_vars($obj);
    }

}