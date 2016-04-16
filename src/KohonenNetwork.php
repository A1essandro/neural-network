<?php

namespace Neural;


use Neural\Abstraction\LayeredNetwork;

class KohonenNetwork extends LayeredNetwork
{

    public function __construct(array $layersConfiguration = null)
    {
        if (is_null($layersConfiguration)) {
            return;
        }

        foreach ($layersConfiguration as $key => $neuronsInLayer) {
            $layer = new Layer(
                $neuronsInLayer, $key
                ? Layer::NODE_TYPE_NEURON
                : Layer::NODE_TYPE_INPUT
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
        $outputCount = count(iterator_to_array($this->getOutputLayer()->getNodes()));
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

}