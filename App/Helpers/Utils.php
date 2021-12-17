<?php

namespace App\Helpers;

class Utils 
{
    public static function formatDate($date)
    {
        return date('M Y',strtotime($date));
    }

    public static function sortData($data, $sqn) {
        $fdata = [];
        foreach ($data as $dt) {
            $obj = [];
            foreach ($sqn as $sq) {
                $obj[$sq] = $dt[$sq];
            }
            array_push($fdata, $obj);
        }
        return $fdata;
    }
}
