<?php
namespace PMVC\PlugIn\filter;

abstract class BaseFilter {
    abstract function validate(&$value, $params=array());

    public function &getValue(&$value)
    {
        if (is_a($value, '\PMVC\Object')) {
            return $value();
        } else {
            return $value;
        }
    }

    public function getDefaults()
    {
    }

    public function mergeDefault($params)
    {
        return \PMVC\mergeDefault(
            $this->getDefaults(),
            $params
        );
    }
}
