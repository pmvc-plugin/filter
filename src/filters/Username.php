<?php
namespace PMVC\PlugIn\filter;

class Username extends BaseFilter
{
    function validate(&$val, $params = array())
    {
        return \PMVC\plug('filter')->toString(
            $val, 
            array(
               'reg'=>'/[^a-z0-9\.]/',
               'regBool'=>false
            )
        );
    }
}

