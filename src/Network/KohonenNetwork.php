<?php

namespace Neural\Network;


use Neural\Learning\ISelfLearning;
use Neural\Network\Layer\Layer;
use Neural\Network\Node\Input;
use Neural\Network\Node\KohonenNeuron;
use Neural\Network\Node\Neuron;
use Neural\Network\Synapse\Synapse;

class KohonenNetwork extends LayeredNetwork implements ISelfLearning
{

    public function __construct(array $layersConfiguration = null)
    {
        if (is_null($layersConfiguration)) {
            return;
        }

        foreach ($layersConfiguration as $key => $neuronsInLayer) {
            $layer = new Layer(
                $neuronsInLayer, $key
                ? KohonenNeuron::class
                : Input::class
            );
            $this->addLayer($layer);
        }
    }

    public function generateSynapses()
    {
        for ($i = 0; $i < count($this->layers) - 1; $i++) {
            $curLayer = $this->layers[$i];
            $nextLayer = $this->layers[$i + 1];
            foreach ($nextLayer->getNodes() as $nextNeuron) {
                foreach ($curLayer->getNodes() as $curNeuron) {
                    $nextNeuron->addSynapse(new Synapse($curNeuron));
                }
            }
        }
    }

    public function output()
    {
        $outputCount = count($this->getOutputLayer()->getNodes());
        $max = -$outputCount;
        $maxIndex = -1;

        foreach ($this->getOutputLayer()->getNodes() as $index => $node) {
            if ($node->output() >= $max) {
                $maxIndex = $index;
                $max = $node->output();
            }
        }

        $result = array_fill(0, $outputCount, 0);
        $result[$maxIndex] = 1;
        return $result;
    }

    public function learn(array $input)
    {
        $result = $this->input($input)->output();

        $neuronKey = array_search(1, $result);

        //search 'winner'
        /** @var Neuron $neuron */
        foreach ($this->getOutputLayer()->getNodes() as $key => $neuron) {
            if ($key == $neuronKey) {
                break;
            }
        }

        //change winner's weights (move to input vector)
        foreach ($neuron->getSynapses() as $key => $synapse) {
            $synapse->changeWeight(0.15 * ($input[$key] - $synapse->getWeight()));
        }
    }

}