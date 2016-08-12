<?php
namespace PMVC\PlugIn\filter;

use PMVC\Object;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\filter';

\PMVC\l(__DIR__.'/src/BaseFilter.php');

/**
 * @parameters string lastError debug message 
 */
class filter extends \PMVC\PlugIn
{
    public function one($type, array $params=[])
    {
        $value = ($params[0] instanceof Object) ? 
            $params[0] :
            new Object($params[0]);
        array_shift($params);
        
        return call_user_func(
            [$this,'to_'.$type],
            $value,
            $params
        );
    }

    public function all(array $values, array $params)
    {
        $results = array();
        foreach($values as $key=>$value) {
            $type = array_shift($params[$key]);
            array_unshift($params[$key],$value);
            $results[$key] = $this->one(
                $type,
                $params[$key]
            );
        }
        return $results;
    }
}
