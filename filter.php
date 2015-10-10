<?php
namespace PMVC\PlugIn\filter;


${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\filter';

class filter extends \PMVC\PlugIn
{

    private $filter;

    public function __call($method, $args)
    {
        if ('to' !== substr($method,0,2)) {
            return parent::__call($method, $args);
        } else {
            $method = substr($method, 2);
        }
        $value =& $args[0];
        $params = array();
        if (!empty($args[1])) {
            $params = $args[1];
        }
        return call_user_func(
            array($this,'one'),
            $method,
            $value,
            $params
        );
    }

    public function initFilter($type)
    {
        \PMVC\l(__DIR__.'/src/BaseFilter.php');
        \PMVC\l(__DIR__.'/src/filters/'.$type.'.php');
        $class = __NAMESPACE__.'\\'.$type;
        $this->filter[$type] = new $class();
    }

    public function one($type, $value, $params=array())
    {
        if (empty($this->filter[$type])) {
            $this->initFilter($type);
        }
        return $this->filter[$type]->validate(
            $value,
            $params
        );
    }

    public function all($values, $params)
    {
        $results = array();
        foreach($values as $key=>$value) {
            $results[$key] = $this->one(
                $params[$key]['type'],
                $params['type']
            );
        }
        return $results;
    }
}
