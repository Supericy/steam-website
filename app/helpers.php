<?php

class ViewHelper {

    /*
     * Simple foreach wrapper so that we can simplify our views where we're just displaying an array
     */
    public static function displayArray($arr)
    {
        $ret = '';

        foreach ($arr as $msg)
        {
            $ret .= $msg;
        }

        return $ret;
    }

}