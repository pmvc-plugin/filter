<?php

namespace PMVC\PlugIn\filter;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\Validate';

class Validate extends BaseFilter
{
    function __invoke($val, array $params = [])
    {
        $v =& \PMVC\ref($val);
        $params = $this->mergeDefault($params);
        if (!empty($params['trim'])) {
            $v = trim($v);
        }
        if (empty($params['type'])) {
            return !trigger_error('Missing type.');
        }
        $type = constant(
            'FILTER_VALIDATE_'.
            strtoupper($params['type'])
        );
        $v = filter_var($v, $type, \PMVC\get(
            $params,
            ['options', 'flags']
        ));
        if (empty($params['empty'])) {
            return !empty($v);
        } else {
            return $v;
        }
    }

    public function getDefaults()
    {
        return [
            'trim'=>true,
            'empty'=>false
        ];
    }
}
