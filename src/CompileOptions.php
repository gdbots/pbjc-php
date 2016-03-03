<?php

namespace Gdbots\Pbjc;

final class CompileOptions
{
    /** @var array */
    private $namespaces = [];

    /** @var string */
    private $output;

    /** @var string */
    private $manifest;

    /** @var \Closure */
    private $callback;

    /**
     * Construct.
     *
     * @param array $options
     */
    public function __construct(array $options)
    {
        foreach ($options as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    /**
     * @return array
     */
    public function getNamespaces()
    {
        return $this->namespaces;
    }

    /**
     * @return string
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * @return string
     */
    public function getManifest()
    {
        return $this->manifest;
    }

    /**
     * @return \Closure
     */
    public function getCallback()
    {
        return $this->callback;
    }
}