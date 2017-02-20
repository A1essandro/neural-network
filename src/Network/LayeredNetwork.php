<?php

namespace Neural\Network;


use Closure;
use Neural\Abstraction\ILayer;
use Neural\Network\Node\{
    INode, Input, Neuron
};

abstract class LayeredNetwork implements INetwork
{

    /**
     * @var ILayer[]
     */
    protected $layers = [];

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
     * @return $this|LayeredNetwork
     */
    public function input($input): LayeredNetwork
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
     * @param Closure $filter
     *
     * @return INode[]|Neuron[]
     */
    public function getNodes(Closure $filter = null): array
    {
        $nodes = [];
        foreach ($this->layers as $layer) {
            $nodes = array_merge($nodes, $layer->getNodes($filter));
        }

        return $nodes;
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
     * @return ILayer
     */
    public function getOutputLayer()
    {
        return $this->layers[count($this->layers) - 1];
    }

    /**
     * @return ILayer
     */
    public function toLastLayer()
    {
        return end($this->layers);
    }

}