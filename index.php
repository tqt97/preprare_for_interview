<?php


$array = [1, 2, 3, 4, 5];
$result = [];
foreach ($array as $value) {
    if ($value % 2 == 0) {
        $result[] = $value;
    }
}

$rs2 = array_filter($array, function ($value) {
    return $value % 2 == 0;
});

$result2 = array_map(fn($value) => $value * 2, $array);

echo '<pre>';
// print_r($result);
// print_r($rs2);
print_r($result2);
echo '</pre>';
