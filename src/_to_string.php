<?php
namespace PMVC\PlugIn\filter;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\FilterString';

class FilterString extends BaseFilter
{
    function __invoke($val, array $params = [])
    {
        $v =& \PMVC\ref($val);
        extract(
            $this->mergeDefault($params),
            EXTR_PREFIX_ALL,
            'p'
        );
        if ($p_trim) {
            $v = trim($v);
        }
	$len = strlen($v);
	if ($len < $p_min) {
            return false;
        }    
	if(!empty($p_max) && $len > $p_max){
            return false;
        }
        if ($p_reg) {
            if ($p_regReplace) {
                $v = preg_replace( 
                    $p_reg,
                    $p_regReplace,
                    $v,
                    -1,
                    $c
                );
            } else {
                $c = preg_match($p_reg, $v);
            }
            if ($p_regBool) {
                if (!$c) {
                    return false;
                }
            } else {
                if ($c) {
                    return false;
                }
            } 
	}
        return true;
    }

    function getDefaults()
    {
        return [ 
            'trim'=>true,
            'min'=>1,
            'max'=>null,
            'reg'=>null,
            'regBool'=>null,
            'regReplace'=>null
        ];
    }
}

