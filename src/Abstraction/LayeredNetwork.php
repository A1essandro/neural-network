<?php

namespace Neural\Abstraction;


use Closure;
use Generator;
use Neural\Node\INode;
use Neural\Node\Input;
use Neural\Node\Neuron;

abstract class LayeredNetwork implements INetwork
{

    /**
     * @var ILayer[]
     */
    protected $layers;

    /**
     * @return ILayer
     */
    public function getOutputLayer()
    {
        $this->layers[0]->getNodes();
        return $this->layers[count($this->layers) - 1];
    }

    /**
     * @return ILayer[]
     */
    public function getLayers()
    {
        return $this->layers;
    }

    /**
     * @param ILayer $layer
     *
     * @return $this
     */
    public function addLayer(ILayer $layer)
    {
        $this->layers[] = $layer;

        return $this;
    }

    /**
     * @param array $input
     *
     * @return $this
     */
    public function input($input)
    {
        $firstLayer = $this->layers[0];
        $inputsFilter = function ($node) {
            return $node instanceof Input;
        };
        $neuronsFilter = function ($node) {
            return $node instanceof Neuron;
        };

        foreach ($firstLayer->getNodes($inputsFilter) as $key => $neuron) {
            $neuron->input($input[$key]);
        }

        foreach ($this->getNodes($neuronsFilter) as $neuron) {
            $neuron->refresh();
        }

        return $this;
    }

    /**
     * @return array
     */
    public function output()
    {
        $result = [];
        $lastLayer = $this->getOutputLayer();
        foreach ($lastLayer->getNodes() as $neuron) {
            $result[] = $neuron->output();
        }

        return $result;
    }

    /**
     * @return Generator|INode[]
     */
    protected function getOutputNeurons()
    {
        return $this->getOutputLayer()->getNodes();
    }

    /**
     * @param Closure $filter
     *
     * @return INode[]|Neuron[]
     */
    public function getNodes(Closure $filter = null)
    {
        $nodes = [];
        foreach ($this->layers as $layer) {
            $nodes = array_merge($nodes, $layer->getNodes($filter));
        }

        return $nodes;
    }

    /**
     * @return ILayer
     */
    public function toLastLayer()
    {
        return end($this->layers);
    }


    public function trace()
    {
        $this->output();
        foreach ($this->layers as $lk => $layer) {
            echo 'L' . $lk . ': ' . PHP_EOL;
            foreach ($layer->getNodes() as $nk => $neuron) {
                echo "\t" . 'N' . $nk . ': ' . $neuron->output() . PHP_EOL;
                if ($neuron instanceof Neuron) {
                    foreach ($neuron->getSynapses() as $sk => $synapse) {
                        echo "\t\tS" . $sk . ': ' . $synapse->getWeight() . PHP_EOL;
                    }
                }
            }
        }
    }

}