<?php
namespace PMVC\PlugIn\filter;

use PMVC\BaseObject;
use PMVC\PlugIn;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\filter';

\PMVC\l(__DIR__.'/src/BaseFilter.php');

/**
 * @parameters string lastError debug message 
 */
class filter extends PlugIn
{

    private $_phpFilters;

    public function one($type, array $params=[])
    {
        $value = ($params[0] instanceof BaseObject) ? 
            $params[0] :
            new BaseObject($params[0]);
        array_shift($params);
        $func = 'to_'.$type;
        if ($this->isCallable($func)) { 
            return call_user_func(
                [$this,$func],
                $value,
                $params
            );
        }
        if (in_array(strtolower($type), $this->_getPhpFilters())) {
            return call_user_func(
                [$this, 'to_validate'],
                $value,
                array_merge( $params, ['type'=>$type] )
            );
        }
        return !trigger_error('Type is not support. ['.$type.']');
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

    private function _getPhpFilters()
    {
        if (empty($this->_phpFilters)) {
            $this->_phpFilters = filter_list();
        }
        return $this->_phpFilters;
    }
}
