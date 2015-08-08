<?php

namespace Fototea\Util;

class DateHelper {

    private static $months = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

//echo $dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;

    /**
     * Return the numbers of days (if apply) and hours to reach the current date
     *
     * @param $date string future date
     * @return string
     */
    public static function getHoursLeft($date) {
        $datetime1 = date_create();
        $datetime2 = date_create($date);

        if ($datetime1 < $datetime2) {
            $result = "";

            $diff = date_diff($datetime1, $datetime2);
            if ($diff->d > 0) {
                $result .= $diff->d . "d";
            }

            if ($diff->h > 0 || $diff->i > 0) {
                if ($result != ""){
                    $result .= " ";
                }
                $result .= $diff->h . "h";
            }
            //$project->days_left = date_diff($datetime1, $datetime2)->d;
            return $result;
        }
        return "";
    }

    public static function addDaysToTime($time, $days){
        return strtotime("+$days days",$time);
    }

    public static function getLongDate($date, $includeHours = false) {
        $time = strtotime($date);
        $result = date('d', $time)." de ".self::$months[date('n')-1]. " de ".date('Y', $time);
        if ($includeHours){
            $result .= " a la(s) " . date('H') . ':' . date('i');
        }
        return $result;
    }

    public static function getTimeSince($date) {
        $datetime1 = date_create();
        $datetime2 = date_create($date);
        if ($datetime1 > $datetime2) {
            $diff = (object) date_diff($datetime1, $datetime2);

//            if ($diff->y > 0) {
//                $result = "hace " . $diff->y;
//                if ($diff->y == 1){
//                    $result .= " año";
//                } else {
//                    $result .= " años";
//                }
//                return $result;
//            }
//
//            if ($diff->m > 0) {
//                $result = "hace " . $diff->m;
//                if ($diff->m == 1){
//                    $result .= " mes";
//                } else {
//                    $result .= " meses";
//                }
//                return $result;
//            }

            if ($diff->d > 0) {

                if ($diff-> d > 7) {
                    return self::getShortDate($date);
                }

                $result = "hace " . $diff->d;
                if ($diff->d == 1){
                    $result .= " día";
                } else {
                    $result .= " días";
                }
                return $result;
            }

            if ($diff->h > 0) {
                $result = "hace " . $diff->h;
                if ($diff->h == 1){
                    $result .= " hora";
                } else {
                    $result .= " horas";
                }
                return $result;
            }

            if ($diff->i > 0) {
                $result = "hace " . $diff->i;
                if ($diff->i == 1){
                    $result .= " minuto";
                } else {
                    $result .= " minutos";
                }
                return $result;
            }

            if ($diff->s >= 0) {
                return "hace unos segundos";
            }
        } else {
            return false;
        }
    }

    public static function isPastDate($date) {
        $datetime1 = date_create(); //now
        $datetime2 = date_create($date);

        return ($datetime1 > $datetime2);
    }

    /**
     * @param $date string valid strtotime date
     * @param string $format
     * @return bool|string
     */
    public static function getShortDate($date, $format = 'd-m-Y') {
        return date($format, strtotime($date));
    }

    /**
     * Return current date time in format (YYYY-mm-dd H:m:s)
     */
    public static function getCurrentDateTime(){
        return date('Y-m-d H:i:s');
    }

    /**
     * Return a boolean indicating if the specified date with format dd/mm/yyyy is valid
     * @param $date
     * @param string $format
     * @return bool
     */
    public static function validateDate($date){
        $date = str_replace('/', '-', $date);

        $split = array();
        if (preg_match ("/^([0-9]{2})-([0-9]{2})-([0-9]{4})$/", $date, $split))
        {
            if(checkdate($split[2],$split[1],$split[3]))
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }
}