<?php

namespace Services;

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

}