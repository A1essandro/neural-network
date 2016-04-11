<?php

namespace Neural;


use Exception;
use Neural\Abstraction\ITeacher;

class BackpropagationTeacher implements ITeacher
{

    /**
     * @var float
     */
    protected $theta;

    /**
     * @var Network
     */
    protected $perceptron;

    public function __construct(Network $perceptron, $theta = 1)
    {
        $this->perceptron = $perceptron;
        $this->theta = $theta;
    }

    public function teach(array $input, array $expectation)
    {
        $this->perceptron->input($input)->output();
        $nFilter = function ($node) {
            return $node instanceof Neuron;
        };

        $childLayer = null;
        $sigmas = [];

        foreach ($this->perceptron->getLayersReverse() as $layer) {
            if ($this->perceptron->getLayers()[0] == $layer) {
                continue;
            }
            foreach ($layer->getNodes($nFilter) as $nk => $neuron) {
                $neuronOutput = $neuron->getValue();
                $sigma = !empty($childLayer)
                    ? $neuronOutput * (1 - $neuronOutput) * $this->getChildSigmas($sigmas, $neuron)
                    : $neuronOutput * (1 - $neuronOutput) * ($expectation[$nk] - $neuronOutput);
                $sigmas[] = new NeuronsSigma($neuron, $sigma);
                foreach ($neuron->getSynapses() as $synapse) {
                    $synapse->recalculateWeight($this->theta * $sigma * $synapse->getInputNode()->getValue());
                }
            }

            $childLayer = $layer;
        }

    }

    /**
     * @param NeuronsSigma[] $sigmas
     * @param Neuron         $forNeuron
     *
     * @return float|int|null
     */
    private function getChildSigmas($sigmas, $forNeuron)
    {
        $sigma = 0;
        foreach ($sigmas as $neuronWithSigma) {
            foreach ($neuronWithSigma->neuron->getSynapses() as $synapse) {
                if ($synapse->getInputNode() == $forNeuron) {
                    $sigma += $synapse->getWeight() * $neuronWithSigma->sigma;
                }
            }
        }
        return $sigma;
    }

    public function teachKit(array $kit, array $expectations, $error = 0.5, $maxIterations = 10000)
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
        return -1;
    }

    private static function isTrueResult($result, $expectation, $error)
    {
        foreach ($expectation as $key => $true) {
            if ($result[$key] > $true + $error || $result[$key] < $true - $error) {
                return false;
            }
        }
        return true;
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