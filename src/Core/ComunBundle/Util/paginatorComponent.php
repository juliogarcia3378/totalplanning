<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Julio
 * Date: 2/10/14
 * Time: 17:18
 * To change this template use File | Settings | File Templates.
 */
class NumerosUtil
{
public static function paginar($array, $page = 1, $cantidad = 30) {

    if ($page <= 0)
        $page = 1;
    if (count($array) < $cantidad)
        $output = $array;
    else
        $output = array_slice($array, ($page - 1) * $cantidad, $cantidad);

    $val["pagina"] = $page;
    $val["elementoInicial"] = ($page - 1) * $cantidad + 1;
    $val["elementoFinal"] = ((($page- 1) * $cantidad + $cantidad) > count($array)) ? count($array) : (($page- 1) * $cantidad + $cantidad );
    $val["cantidadpaginas"] =  ((count($array) % $cantidad)>0) ? ((int)(count($array)/ $cantidad)) + 1 : (count($array)/ $cantidad);
    $val["valor"] = $output;
    $val["cantElementosEncontrados"] = count($array);

    return $val;
}

}