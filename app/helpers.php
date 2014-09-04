<?php

class ViewHelper {

    /*
     * Simple foreach wrapper so that we can simplify our views where we're just displaying an array
     */
    public static function displayArray($arr, $format = null)
    {
        $ret = '';

        if ($arr !== null && is_array($arr))
        {
            foreach ($arr as $msg)
            {
                if (isset($format))
                {
                    $ret .= str_replace(':message', $msg, $format);
                }
                else
                {
                    $ret .= $msg;
                }
            }
        }

        return $ret;
    }

}

class FlashHelper {

    // http://stackoverflow.com/questions/19777837/is-it-possible-to-store-an-array-as-flash-data-in-laravel

    /*
     * Behaves similar to Session::push, but for flash values.
     * The difference is that it does not explode the key on periods, so append('test.key') will append to ['test.key']
     */
    public static function append($key, $value) {
        $values = Session::get($key, []);
        $values[] = $value;
        Session::flash($key, $values);
    }

}