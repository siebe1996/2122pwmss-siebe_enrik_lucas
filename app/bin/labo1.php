<?php
$alphabet = range('a', 'z');
print_r($alphabet);

$string = "";
foreach ($alphabet as $key => $item) {
    $string .= $key.$item;
}
print_r($string . PHP_EOL);

$strAlpas = implode(',', $alphabet);
print_r($strAlpas . PHP_EOL);

echo sizeof($alphabet) . ' ' . array_shift($alphabet). ' ' . sizeof($alphabet) . PHP_EOL;

$cities = array(9000 => 'Gent', 1000 => 'Brussel', 2000 => 'Antwerpen', 8500 => 'Brussel', 3000 => 'Leuven', 3500 => 'Hasselt');
print_r($cities);

$zips = array_keys($cities);
print_r($zips);

$sum = 0;
foreach ($zips as $value) {
    $sum += $value;
}
echo $sum . PHP_EOL;

asort($cities);
print_r($cities);

krsort($cities);
print_r($cities);

for ($i = 0; $i < 10000; $i+=1000) {
    if (array_key_exists($i, $cities)) {
        echo strtoupper($cities[$i]) . PHP_EOL;
    }
}
?>
