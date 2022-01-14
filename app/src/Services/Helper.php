<?php

namespace Services;

use Cassandra\Date;
use DateTime;

class Helper
{
    public static function validatePhonenumber($num) {
        $allNumbers = explode(' ',$num);
        $numberCorrect = true;
        foreach($allNumbers as $partial) {
            if(!is_numeric($partial)) {
                $numberCorrect = false;
            }
        }
        echo $numberCorrect;
        return $numberCorrect;
    }

    public static function validateDate($time) : string {
        $error = '';
        if(strtotime($time)< time()) {
            $error = 'Please pick a time in the future';
        }
        if(strtotime($time) == 0) {
            $error[] = 'Please give in a valid date';
        }
        return $error;
    }

    public static function removeSpaces($string) : string {
        return str_replace(" ", "", $string);
    }

}