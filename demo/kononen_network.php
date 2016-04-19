<?php

use Neural\KohonenNetwork;

require_once '../vendor/autoload.php';

$p = new KohonenNetwork([3, 5]);
$p->generateSynapses();

$data = [];
for($x = 0; $x<=1; $x+=0.5)
    for($y = 0; $y<=1; $y+=0.5)
        for($z = 0; $z<=1; $z+=0.5)
            $data[] = [$x, $y, $z];

for($i = 0; $i<100;$i++)
foreach($data as $set) {
    $p->learn($set);
}

foreach($data as $set) {
    echo implode(', ',$p->input($set)->output()).PHP_EOL;
}
