<?php
$parameter = $argv[1];
echo $parameter . ' is a palindrome: ' . isPalindrome($parameter);
function isPalinDrome($string): boolean
{
    return strrev($string) === $string;
}

$p = $argv[2];
echo $p . 'is a leapyear' . isLeap($p);
function isLeap($year){
    return (date('L', mktime(0, 0, 0, 1, 1, $year)) == 1);
}

$kw = $argv[3];
$kinderen = $argv[4];

echo 'het totaal is '.cost($kw, $kinderen);
function cost($kw, $kinderen):int{
    $total = 0;
    if($kw > 150){
        $total += ($kw - 150) * 0.3;
        $kw -= ($kw - 150);
    }
    if($kw > 50 && $kw <= 150){
        $total += ($kw - 50) * 0.25;
        $kw -= ($kw - 50);
    }
    $total += $kw * 0.15;
    if ($kinderen > 2){
        $total *= 0.9;
    }
    return $total;
}
?>