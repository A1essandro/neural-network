<?php

use Neural\KohonenNetwork;

class KohonenNetworkTest extends PHPUnit_Framework_TestCase
{

    public function testDemo()
    {
        $control['A'] = [1, 0.5, 0];
        $control['B'] = [0, 0.5, 1];
        $control['C'] = [0, 0.7, 0.9];

        $network = new KohonenNetwork([3, 2]);
        $network->generateSynapses();

        $learningData = [];
        for ($i = 0; $i < 1000; $i++) {
            $randomProperty1 = mt_rand() / mt_getrandmax(); //random value from 0 to 1
            $randomProperty2 = mt_rand() / mt_getrandmax(); //random value from 0 to 1
            $randomProperty3 = mt_rand() / mt_getrandmax(); //random value from 0 to 1
            $learningData[] = [$randomProperty1, $randomProperty2, $randomProperty3];
        }

        for ($i = 0; $i < 250; $i++) {
            foreach ($learningData as $set) {
                $network->learn($set);
            }
        }

        $A = $network->input($control['A'])->output();
        $B = $network->input($control['B'])->output();
        $C = $network->input($control['C'])->output();

        $this->assertNotEquals($A, $B);
        $this->assertNotEquals($A, $C);
        $this->assertEquals($C, $B);
    }
    
}
