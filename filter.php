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
        if (empty($params[1])) {
            $params[1] = [];
        }
        return call_user_func(
            [$this,'to'.$type],
            $value,
            $params[1]
        );
    }

    public function all(array $values, array $params)
    {
        $results = array();
        foreach($values as $key=>$value) {
            $results[$key] = $this->one(
                $params[$key]['type'],
                [
                    $value,
                    $params[$key]['params']
                ]
            );
        }
        return $results;
    }
}
