<?php
namespace ADEPSOFT\ComunBundle\Util;
/**
 * Description of SubscriberFuncionalidades
 *
 * @author Yoelvis Mulen Llorente <ymulen@uci.cu>
 */
class NumerosUtil
{

    /**
     * @author Yoelvis Mulen Llorente <ymulen@uci.cu>
     * Dado un número lo devuelve escrito (optimizado para dinero).
     * @param type $num Número a convertir.
     * @return string
     */
    public static function dinero2letras($num)
    {
        $float = explode('.', number_format($num, 2, '.', ''));

//        se divide el numero en dos, los q soporta el int hasta 9 cifras y le resto
        $end = strlen($float[0]);
        $star = $end - 9;
        if ($star > 0) {
            //las ultimas 9 cifras, lo q soporta el int
            $numero = substr($float[0], $star, $end);

            //el resto del numero
            $numeroMas = substr($float[0], 0, $star);
        } else {
            $numero = $float[0];
            $numeroMas = 0;
        }

        $de = (($numero % 1000000 == 0 && $numero != 0) || ($numeroMas != 0 && $numero % 1000000 == 0)) ? ' de' : '';


        $letras = NumerosUtil::num2letras($float[0], true, false, false, false);
        $pesos = ($float[0] == 1) ? ' peso' : ' pesos';
        $centavos = ($float[1] == 1) ? ' centavo' : ' centavos';
        $decimales = '';
        if (isset($float[1]) && $float[1] != 0) {
            $decimales = ' y ' . NumerosUtil::num2letras($float[1], true, false, false, false) . $centavos;
        }

        return $letras . $de . $pesos . $decimales;
    }


    /**
     * @author Yoelvis Mulen Llorente <ymulen@uci.cu>
     * Dado un número lo devuelve escrito.
     * @param number $num - Número a convertir.
     * @param bool $fem - Forma femenina (true) o no (false).
     * @param bool $dec - Con decimales (true) o no (false).
     * @return string - Devuelve el número escrito en letra.
     */
    public static function num2letras($num, $antesSustantivo = false, $fem = false, $dec = true, $capitalizar = false)
    {
        $matuni[2] = "dos";
        $matuni[3] = "tres";
        $matuni[4] = "cuatro";
        $matuni[5] = "cinco";
        $matuni[6] = "seis";
        $matuni[7] = "siete";
        $matuni[8] = "ocho";
        $matuni[9] = "nueve";
        $matuni[10] = "diez";
        $matuni[11] = "once";
        $matuni[12] = "doce";
        $matuni[13] = "trece";
        $matuni[14] = "catorce";
        $matuni[15] = "quince";
        $matuni[16] = "dieciseis";
        $matuni[17] = "diecisiete";
        $matuni[18] = "dieciocho";
        $matuni[19] = "diecinueve";
        $matuni[20] = "veinte";
        $matunisub[2] = "dos";
        $matunisub[3] = "tres";
        $matunisub[4] = "cuatro";
        $matunisub[5] = "quin";
        $matunisub[6] = "seis";
        $matunisub[7] = "sete";
        $matunisub[8] = "ocho";
        $matunisub[9] = "nueve";//nove

        $matdec[2] = "veinte";//veint
        $matdec[3] = "treinta";
        $matdec[4] = "cuarenta";
        $matdec[5] = "cincuenta";
        $matdec[6] = "sesenta";
        $matdec[7] = "setenta";
        $matdec[8] = "ochenta";
        $matdec[9] = "noventa";
        $matsub[3] = 'mill';
        $matsub[5] = 'bill';
        $matsub[7] = 'mill';
        $matsub[9] = 'trill';
        $matsub[11] = 'mill';
        $matsub[13] = 'bill';
        $matsub[15] = 'mill';
        $matmil[4] = 'millones';
        $matmil[6] = 'billones';
        $matmil[7] = 'de billones';
        $matmil[8] = 'millones de billones';
        $matmil[10] = 'trillones';
        $matmil[11] = 'de trillones';
        $matmil[12] = 'millones de trillones';
        $matmil[13] = 'de trillones';
        $matmil[14] = 'billones de trillones';
        $matmil[15] = 'de billones de trillones';
        $matmil[16] = 'millones de billones de trillones';

        //Zi hack
//        $float = explode('.', $num);
//        $num = $float[0];

        $num = trim((string)@$num);
        if ($num[0] == '-') {
            $neg = 'menos ';
            $num = substr($num, 1);
        } else
            $neg = '';
        while ($num[0] == '0')
            $num = substr($num, 1);
        if ($num[0] < '1' or $num[0] > 9)
            $num = '0' . $num;
        $zeros = true;
        $punt = false;
        $ent = '';
        $fra = '';
        for ($c = 0; $c < strlen($num); $c++) {
            $n = $num[$c];
            if (!(strpos(".,'''", $n) === false)) {
                if ($punt)
                    break;
                else {
                    $punt = true;
                    continue;
                }
            } elseif (!(strpos('0123456789', $n) === false)) {
                if ($punt) {
                    if ($n != '0')
                        $zeros = false;
                    $fra .= $n;
                } else
                    $ent .= $n;
            } else
                break;
        }
        $ent = '     ' . $ent;
        if ($dec and $fra and !$zeros) {
            $fin = ' coma';
            for ($n = 0; $n < strlen($fra); $n++) {
                if (($s = $fra[$n]) == '0')
                    $fin .= ' cero';
                elseif ($s == '1')
                    $fin .= $fem ? ' una' : ' un';
                else
                    $fin .= ' ' . $matuni[$s];
            }
        } else
            $fin = '';
        if ((int)$ent === 0)
            return $capitalizar ? 'Cero' : 'cero' . $fin;
        $tex = '';
        $sub = 0;
        $mils = 0;
        $neutro = $antesSustantivo;
        while (($num = substr($ent, -3)) != '   ') {
            $ent = substr($ent, 0, -3);
            if (++$sub < 3 and $fem) {
                $matuni[1] = 'una';
                $subcent = 'as';
            } else {
                $matuni[1] = $neutro ? 'un' : 'uno';
                $subcent = 'os';
            }
            $t = '';
            $n2 = substr($num, 1);
            if ($n2 == '00') {

            } elseif ($n2 < 21)
                $t = ' ' . $matuni[(int)$n2];
            elseif ($n2 < 30) {
                $n3 = $num[2];
                if ($n3 != 0)
                    $t = 'i' . $matuni[$n3];
                $n2 = $num[1];
                $t = ' ' . $matdec[$n2] . $t;
            } else {
                $n3 = $num[2];
                if ($n3 != 0)
                    $t = ' y ' . $matuni[$n3];
                $n2 = $num[1];
                $t = ' ' . $matdec[$n2] . $t;
            }
            $n = $num[0];
            if ($n == 1) {
                if ($num == '100') {
                    $t = ' cien' . $t;
                } else {
                    $t = ' ciento' . $t;
                }
            } elseif ($n == 5) {
                $t = ' ' . $matunisub[$n] . 'ient' . $subcent . $t;
            } elseif ($n != 0) {
                $t = ' ' . $matunisub[$n] . 'cient' . $subcent . $t;
            }
            if ($sub == 1) {

            } elseif (!isset($matsub[$sub])) {
                if ($num == 1) {
                    $t = ' mil';
                } elseif ($num > 1) {
                    $t .= ' mil';
                }
            } elseif ($num == 1) {
                $t .= ' ' . $matsub[$sub] . 'ón';
            } elseif ($num > 1) {
                $t .= ' ' . $matsub[$sub] . 'ones';
            }
            if ($num == '000')
                $mils++;
            elseif ($mils != 0) {
                if (isset($matmil[$sub]))
                    $t .= ' ' . $matmil[$sub];
                $mils = 0;
            }
            $neutro = true;
            $tex = $t . $tex;
        }
        $tex = $neg . substr($tex, 1) . $fin;
        //Zi hack --> return ucfirst($tex);

        $tex = str_replace('dieciseis', 'dieciséis', $tex);
        if (true == $antesSustantivo) {
            $tex = str_replace('veintiun', 'veintiún', $tex);
        }

        $tex = str_replace('veintidos', 'veintidós', $tex);
        $tex = str_replace('veintitres', 'veintitrés', $tex);
        $tex = str_replace('veintiseis', 'veintiséis', $tex);

        return $capitalizar ? ucfirst($tex) : $tex;
    }

    /**
     * @author murquiza
     * Dado un número expediente lo devuelve con el formato en que se debe mostrar
     * @param type $numExp Número de Expediente a dar formato
     * @return string
     */
    public static function formatoNumExp($numExp)
    {
        return substr($numExp, -4) . '/' . substr($numExp, 0, 4);
    }

    /**
     * @author Yosviel Dominguez
     * Dado un número expediente lo devuelve el anno del expediente
     * @param type $numExp Número de Expediente a dar formato
     * @return string
     */
    public static function annoDelExp($numExp)
    {
        return substr($numExp, 0, 4);
    }

    /**
     * @author Ariel <amontiel@uci.cu>
     * Dado un número del 1 al 99 lo devuelve escrito en formato ordinal ej. 1 =Primero 0 Primera.
     * @param number $num - Número a convertir.
     * @param bool $fem - Forma femenina (true) o no (false).
     */
    public static function num2LetrasOrdinal($num, $fem)
    {
        $matuni[1] = "Primer";
        $matuni[2] = "Segund";
        $matuni[3] = "Tercer";
        $matuni[4] = "Cuart";
        $matuni[5] = "Quint";
        $matuni[6] = "Sext";
        $matuni[7] = "Séptim";
        $matuni[8] = "Octav";
        $matuni[9] = "Noven";
        $matuni[10] = "Décim";
        $matuni[20] = 'Vigésim';
        $matuni[30] = 'Trigésim';
        $matuni[40] = 'Cuadragésim';
        $matuni[50] = 'Quincuagésim';
        $matuni[60] = 'Sexagésim';
        $matuni[70] = 'Septuagésim';
        $matuni[80] = 'Octogésim';
        $matuni[90] = 'Nonagésim';
        $matdec[1] = "Decimo";
        $matdec[2] = "Vigésimo";
        $matdec[3] = "Trigésimo";
        $matdec[4] = "Cuadragésimo";
        $matdec[5] = "Quincuagésimo";
        $matdec[6] = "Sexagésimo";
        $matdec[7] = "Septuagésimo";
        $matdec[8] = "Octogésimo";
        $matdec[9] = "Nonagésimo";
        $matcon[1] = "primer";
        $matcon[2] = "segund";
        $matcon[3] = "tercer";
        $matcon[4] = "cuart";
        $matcon[5] = "quint";
        $matcon[6] = "sext";
        $matcon[7] = "séptim";
        $matcon[8] = "octav";
        $matcon[9] = "noven";
        $result = "";
        $coc = $num / 10;
        $rest = $num % 10;
        if ($num <= 10 || $rest == 0) {
            $result = $matuni[$num];
        } else {
            $result = $matdec[$coc] . ' ' . $matcon[$rest];
        }
        if ($fem) {
            return $result . 'a';
        } else {
            return $result . 'o';
        }
    }

}

?>
