<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 05-Jan-17
 * Time: 9:18 PM
 */
// lay ngay tu dang int, $time - int
//$full_time co muon lay ca gio phut giay ko
function get_date($time,$full_time=TRUE)
{
    $format = '%d-%m-%Y';
    if($full_time)
    {
        $format .= ' - %H:%i:%s';
    }
    return mdate($format,$time);
}