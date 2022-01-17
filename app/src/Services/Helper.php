<?php

namespace Services;

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
        return $numberCorrect;
    }

    public static function convertToDateTime($timeString) : DateTime {
        $epoch = strtotime($timeString);
        $datetime = new DateTime();
        $datetime->setTimestamp($epoch);
        return $datetime;
    }

    public static function validateDate($time) : string
    {
        $error = '';
        //var_dump($time);
        $arr = explode('-', $time);
        echo '---------';
        //var_dump($arr);
        echo '---------';
        //var_dump(count($arr));
        echo '---------';
        if (count($arr) == 3) {
            $month = $arr[1];
            $day = $arr[2];
            $year = $arr[0];
            echo 'Month : '.$month . ' Day : ' . $day .' year : '.$year;
            if (!checkdate($month , $day, $year)) {
                return 'Please give in a valid date.';
            }
        } else {
            return 'Please give in a valid date';
        }
        if (strtotime($time) < time()) {
            return'Please pick a time in the future';
        }
        return $error;
    }

    public static function removeSpaces($string) : string {
        return str_replace(" ", "", $string);
    }

    public static function getValuesFromSQLArray($array,$key) : array {
        $newArray = [];
        foreach($array as $element) {
            $newArray[]=$element[$key];
        }
        return $newArray;
    }

    public static function replaceSpacesWithUnderscores($string) : string {
        return str_replace(' ','_',$string);
    }

    public static function replaceUnderscoresWithSpaces($string) : string {
        return str_replace('_',' ',$string);
    }

    public static function doesContainSpaces($string) : bool  {
        return ctype_space($string);
    }

}