<?php
namespace PMVC\PlugIn\filter;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\Email';

class Email extends BaseFilter
{
    function __invoke($val, array $params = [])
    {
        $v =& \PMVC\ref($val);
        $v = trim($v);
        $v = filter_var($v, FILTER_VALIDATE_EMAIL);
        return !empty($v);
    }
}

