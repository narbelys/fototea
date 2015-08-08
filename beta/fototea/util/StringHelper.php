<?php

namespace Fototea\Util;

class StringHelper {

    /**
     * Return a random string
     */
    public static function generateRandomString($length = 10,$uc = true,$n = true, $sc = false){
        $source = 'abcdefghijklmnopqrstuvwxyz';
        if($uc==1) $source .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        if($n==1) $source .= '1234567890';
        if($sc==1) $source .= '|@#~$%()=^*+[]{}-_';
        if($length>0){
            $rstr = "";
            $source = str_split($source,1);
            for($i=1; $i<=$length; $i++){
                mt_srand((double)microtime() * 1000000);
                $num = mt_rand(1,count($source));
                $rstr .= $source[$num-1];
            }
        }

        return $rstr;
    }

    /**
     * Place params into right position for given string
     * Ej. THis is a {0} from {1}  where 0,1 are positions of array params
     *
     * @param $msg
     * @param null $params
     * @return mixed
     */
    public static function replaceParams($msg, $params = null) {

        if ($params == null) {
            return $msg;
        }

        if (is_array($params)){
            foreach ($params as $key => $value) {
                $msg = str_replace('{' . $key . '}', $value, $msg);
            }
        } else {
            $msg = str_replace('{0}', $params, $msg);
        }

        return $msg;
    }

    public static function brToLn($string) {
        $string = str_replace(array("\n","\r\n"), '', $string);
        return str_replace(array("<br>","<br/>", "<br />"), '\n', $string);
    }

    public static function validateEmail($email){
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}