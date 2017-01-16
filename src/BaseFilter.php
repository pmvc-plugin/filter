<?php
namespace PMVC\PlugIn\filter;

abstract class BaseFilter {

    abstract function __invoke($value, array $params=[]);

    public function getDefaults()
    {
    }

    public function mergeDefault($params)
    {
        return array_replace(
            $this->getDefaults(),
            $params
        );
    }
}
