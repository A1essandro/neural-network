<?php

namespace Neural;


use Neural\Abstraction\IInput;
use Neural\Abstraction\ILayer;
use Neural\Abstraction\IOutput;

class Network implements IInput, IOutput
{

    /**
     * @var ILayer[]
     */
    protected $layers = [];

    /**
     * @param array $layersOptions
     */
    public function __construct(array $layersOptions)
    {
        $lastLayer = count($layersOptions) - 1;
        foreach ($layersOptions as $key => $neuronsInLayer) {
            $layer = new Layer(
                $neuronsInLayer, $key
                ? Layer::NODE_TYPE_NEURON
                : Layer::NODE_TYPE_INPUT
            );
            if ($lastLayer != $key) {
                $layer->addNode(new Bias());
            }
            $this->layers[$key] = $layer;
        }
    }

    /**
     * @param array $input
     *
     * @return $this
     */
    public function input($input)
    {
        $firstLayer = $this->layers[0];
        $filter = function ($node) {
            return $node instanceof Input;
        };

        foreach ($firstLayer->getNodes($filter) as $key => $neuron) {
            $neuron->input($input[$key]);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function output()
    {
        $result = [];
        $lastLayer = $this->layers[count($this->layers) - 1];
        foreach ($lastLayer->getNodes() as $neuron) {
            $result[] = $neuron->output();
        }

        return $result;
    }

    /**
     * @param Neuron $fromNeuron
     * @param Neuron $toNeuron
     */
    public function addSynapse($fromNeuron, $toNeuron)
    {
        $toNeuron->addSynapse(new Synapse($fromNeuron));
    }

    public function trace()
    {
        $this->output();
        foreach ($this->layers as $lk => $layer) {
            echo 'L' . $lk . ': ' . PHP_EOL;
            foreach ($layer->getNodes() as $nk => $neuron) {
                echo "\t" . 'N' . $nk . ': ' . $neuron->getValue() . PHP_EOL;
                foreach ($neuron->getSynapses() as $sk => $synapse) {
                    echo "\t\tS" . $sk . ': ' . $synapse->getWeight() . PHP_EOL;
                }
            }
        }
    }

    public function generateSynapses()
    {
        for ($i = 0; $i < count($this->layers) - 1; $i++) {
            $curLayer = $this->layers[$i];
            $nextLayer = $this->layers[$i + 1];
            foreach ($nextLayer->getNodes() as $nextNeuron) {
                foreach ($curLayer->getNodes() as $curNeuron) {
                    if (!$nextNeuron instanceof Bias) {
                        $this->addSynapse($curNeuron, $nextNeuron);
                    }
                }
            }
        }
    }

    protected function getOutputNeurons()
    {
        return $this->layers[count($this->layers) - 1]->getNodes();
    }

    /**
     * @return ILayer
     */
    public function getOutputLayer()
    {
        return $this->layers[count($this->layers) - 1];
    }

    public function getLayers()
    {
        return $this->layers;
    }

    /**
     * @return ILayer[] Returns Generator!
     */
    public function getLayersReverse()
    {
        for ($i = count($this->layers) - 1; $i >= 0; $i--) {
            yield $this->layers[$i];
        }
    }

}
