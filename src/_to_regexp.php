<?php
namespace PMVC\PlugIn\filter;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\Regexp';

class Regexp extends BaseFilter
{
    function __invoke($val, array $params = [])
    {
        $v =& \PMVC\ref($val);
        set_error_handler([$this, 'fail']);
        $bool = preg_match($v,null,$match);
        restore_error_handler();
        return $bool!==false;
    }

    function fail($level, $message)
    {
        $errors = [
            PREG_NO_ERROR
                => 'NO_ERROR',
            PREG_INTERNAL_ERROR
                => 'INTERNAL_ERROR',
            PREG_BACKTRACK_LIMIT_ERROR
                => 'BACKTRACK_LIMIT_ERROR',
            PREG_RECURSION_LIMIT_ERROR
                => 'RECURSION_LIMIT_ERROR',
            PREG_BAD_UTF8_ERROR
                => 'BAD_UTF8_ERROR',
        ];
        if (defined('PREG_BAD_UTF8_OFFSET_ERROR')) {
            $errors[PREG_BAD_UTF8_OFFSET_ERROR] = 'BAD_UTF8_OFFSET_ERROR';
        }
        if (defined('PREG_JIT_STACKLIMIT_ERROR')) {
            $errors[PREG_JIT_STACKLIMIT_ERROR] = 'JIT_STACKLIMIT_ERROR';
        }

        if (isset($errors[preg_last_error()])) {
            $preg_fail = $errors[preg_last_error()];
        } else {
            $preg_fail = 'Unknow';
        }
        $message .= '. PREG Fail: ['.$preg_fail.']';
        $this->caller['lastError'] = $message;
    }
}

