<?php
for($i = 1; $i < 13; $i++) {
    $months[$i] = $i;
}
for($i = 2010; $i <= 2050; $i++) {
    $years[$i] = $i;
}
return [
    'months' => $months,
    'years' => $years
];
?>