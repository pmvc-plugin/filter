<?php
namespace PMVC\PlugIn\filter;

class Email extends BaseFilter
{
    function validate(&$val, $params = array())
    {
        $v =& $this->getValue($val);
        $v = trim($v);
        $v = filter_var($v, FILTER_VALIDATE_EMAIL);
        return !empty($v);
    }
}

