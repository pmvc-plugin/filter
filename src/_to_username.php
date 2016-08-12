<?php
namespace PMVC\PlugIn\filter;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\Username';

class Username extends BaseFilter
{
    function __invoke($val, array $params = [])
    {
        return \PMVC\plug('filter')->one(
            'string',
            [
               $val, 
               'reg'=>'/[^a-z0-9\.]/',
               'regBool'=>false
            ]
        );
    }
}

