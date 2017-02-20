<?php


use Neural\Network\KohonenNetwork;

class KohonenNetworkTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var KohonenNetwork
     */
    private $network;

    protected function setUp()
    {
        $this->network = new KohonenNetwork([3, 2]);
    }

    protected function tearDown()
    {
        $this->network = null;
    }

    public function testConfiguration()
    {
        $this->assertCount(2, $this->network->getLayers());
        $this->assertCount(2, $this->network->toLastLayer()->getNodes());
        $this->assertCount(3, $this->network->getLayers()[0]->getNodes());
    }

    public function testSynapses()
    {
        $this->network->generateSynapses();

        $this->assertCount(3, $this->network->toLastLayer()->getNodes()[0]->getSynapses());
    }

    public function testOutput()
    {
        $this->network->generateSynapses();

        $this->assertCount(2, $this->network->output());
        $this->assertEquals(1, array_sum($this->network->output()));
    }

    public function testNullConfiguration()
    {
        $network = new KohonenNetwork();

        $this->assertCount(0, $network->getLayers());
    }

    public function testLearn()
    {
        $network = new KohonenNetwork([2, 4]);
        $network->generateSynapses();
        for ($i = 0; $i < 1500; $i++)
            $network->learn([mt_rand() / mt_getrandmax(), mt_rand() / mt_getrandmax()]);

        $things = [
            [0.9, 0.1],
            [0.05, 0.8],
            [0, 0.05],
            [1, 0.89]
        ];

        for ($a = 0; $a < 4; $a++) {
            for ($b = 0; $b < 4; $b++) {
                if ($a == $b)
                    continue;
                $this->assertNotEquals($network->input($things[$a])->output(),
                    $network->input($things[$b])->output());
            }
        }
    }


}
