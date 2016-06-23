<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Helper extends Model
{
    public static function slug($name, $id = null) {
        
            $name = trim($name);
            
            $table = array(

                'Š'=>'S', 'š'=>'s', 'Đ'=>'Dj', 'đ'=>'dj', 'Ž'=>'Z', 'ž'=>'z', 'Č'=>'C', 'č'=>'c', 'Ć'=>'C', 'ć'=>'c',

                'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',

                'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',

                'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss',

                'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e',

                'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o',

                'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y','þ'=>'b', 'ÿ'=>'y',

                'Ŕ'=>'R', 'ŕ'=>'r', '/' => '', ' ' => '-', '.' => '', '"' => '', ',' => '', "'" => '', ':' => '',
                ';' => '', '<' => '', '>' => '', '?' => ''

            );

            $name = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $name);

            $name = strtolower(strtr($name, $table));

            if ($id) {
                $name .= '-' . $id;
            }

            return $name;

    }

    public static function getTimeDifference($time)
    {
        $str = strtotime($time);
        $today = strtotime(date('Y-m-d H:i:s'));

        // It returns the time difference in Seconds...
        $time_differnce = $today-$str;

        // To Calculate the time difference in Years...
        $years = 60*60*24*365;

        // To Calculate the time difference in Months...
        $months = 60*60*24*30;

        // To Calculate the time difference in Days...
        $days = 60*60*24;

        // To Calculate the time difference in Hours...
        $hours = 60*60;

        // To Calculate the time difference in Minutes...
        $minutes = 60;

        if(intval($time_differnce/$years) > 1) {
            return intval($time_differnce/$years)." years ago";
        } else if(intval($time_differnce/$years) > 0) {
            return intval($time_differnce/$years)." year ago";
        } else if(intval($time_differnce/$months) > 1) {
            return intval($time_differnce/$months)." months ago";
        } else if(intval(($time_differnce/$months)) > 0) {
            return intval(($time_differnce/$months))." month ago";
        } else if(intval(($time_differnce/$days)) > 1) {
            return intval(($time_differnce/$days))." days ago";
        } else if (intval(($time_differnce/$days)) > 0) {
            return intval(($time_differnce/$days))." day ago";
        } else if (intval(($time_differnce/$hours)) > 1) {
            return intval(($time_differnce/$hours))." hours ago";
        } else if (intval(($time_differnce/$hours)) > 0) {
            return intval(($time_differnce/$hours))." hour ago";
        } else if (intval(($time_differnce/$minutes)) > 1) {
            return intval(($time_differnce/$minutes))." minutes ago";
        } else if (intval(($time_differnce/$minutes)) > 0)  {
            return intval(($time_differnce/$minutes))." minute ago";
        } else if (intval(($time_differnce)) > 1) {
            return intval(($time_differnce))." seconds ago";
        } else {
            return "few seconds ago";
        }
    }
}
