<?php

use Neural\KohonenNetwork;

require_once '../vendor/autoload.php';

$p = new KohonenNetwork([9, 2]);
$p->generateSynapses();

print_r($p->input([0,1,0,0,1,0,0,1,0])->output());