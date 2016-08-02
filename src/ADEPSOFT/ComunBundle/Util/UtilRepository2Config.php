<?php

namespace ADEPSOFT\ComunBundle\Util;


/**
 * Filtrado de tablas y QueryBuilder
 *
 * @author Franklin Rivero <frrivero@uci.cu>
 */
class UtilRepository2Config {
    public static $defaultForeignCompareOperator = '=';
    public static $defaultQueryStringCompareOperator = 'like';
    public static $defaultJoinType = 'innerJoin';
    public static $defaultStringComparer = 'like';
    public static $paginate=true;
    public static $output;
}

?>
