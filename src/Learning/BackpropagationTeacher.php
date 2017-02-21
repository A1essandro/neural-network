<?php

namespace Neural\Learning;


use Exception;
use Neural\Abstraction\ILayer;
use Neural\Network\MultilayerPerceptron;
use Neural\Network\Node\Neuron;

class BackpropagationTeacher implements ITeacher
{

    const INEFFECTUALLY_LEARN = -1;

    /**
     * @var float
     */
    protected $theta;

    /**
     * @var MultilayerPerceptron
     */
    protected $perceptron;

    public function __construct(MultilayerPerceptron $perceptron, float $theta = 1.0)
    {
        $this->perceptron = $perceptron;
        $this->theta = $theta;
    }

    /**
     * @param array $kit
     * @param array $expectations
     * @param float $error
     * @param int $maxIterations
     * @return int
     * @throws Exception
     */
    public function teachKit(array $kit, array $expectations, float $error = 0.3, int $maxIterations = 10000): int
    {
        if (count($kit) != count($expectations)) {
            throw new Exception("Kit and expectations quantities must be equals");
        }

        for ($i = 0; $i < $maxIterations; $i++) {
            $trueResults = 0;
            foreach ($expectations as $key => $expectation) {
                $result = $this->perceptron->input($kit[$key])->output();
                $isTrueResults = (int)self::isTrueResult($result, $expectation, $error);
                if (!$isTrueResults) {
                    $this->teach($kit[$key], $expectation);
                } else {
                    $trueResults++;
                }
            }
            if ($trueResults == count($kit)) {
                return $i;
            }

        }
        return self::INEFFECTUALLY_LEARN;
    }

    private static function isTrueResult($result, $expectation, $error)
    {
        foreach ($expectation as $key => $true) {
            if (abs($result[$key] - $true) > $error) {
                return false;
            }
        }
        return true;
    }

    public function teach(array $input, array $expectation)
    {
        $this->perceptron->input($input)->output();
        $nFilter = function ($node) {
            return $node instanceof Neuron;
        };

        $childLayer = null;
        $sigmas = [];

        /** @var ILayer $layer */
        foreach (array_reverse($this->perceptron->getLayers()) as $layer) {
            if ($this->perceptron->getLayers()[0] == $layer) {
                continue;
            }
            foreach ($layer->getNodes($nFilter) as $nk => $neuron) {
                $neuronOutput = $neuron->output();
                $sigma = !empty($childLayer)
                    ? $neuronOutput * (1 - $neuronOutput) * $this->getChildSigmas($sigmas, $neuron)
                    : $neuronOutput * (1 - $neuronOutput) * ($expectation[$nk] - $neuronOutput);
                $sigmas[] = new NeuronsSigma($neuron, $sigma);
                foreach ($neuron->getSynapses() as $synapse) {
                    $synapse->changeWeight($this->theta * $sigma * $synapse->getParentNode()->output());
                }
            }

            $childLayer = $layer;
        }
    }

    /**
     * @param NeuronsSigma[] $sigmas
     * @param Neuron $forNeuron
     *
     * @return float
     */
    private function getChildSigmas(array $sigmas, Neuron $forNeuron): float
    {
        $sigma = 0;
        foreach ($sigmas as $neuronWithSigma) {
            foreach ($neuronWithSigma->neuron->getSynapses() as $synapse) {
                if ($synapse->getParentNode() == $forNeuron) {
                    $sigma += $synapse->getWeight() * $neuronWithSigma->sigma;
                }
            }
        }
        return $sigma;
    }

}

class NeuronsSigma
{
    /**
     * @var Neuron
     */
    public $neuron;
    public $sigma;

    public function __construct($neuron, $sigma)
    {
        $this->neuron = $neuron;
        $this->sigma = $sigma;
    }
}