<?php

namespace ADEPSOFT\ComunBundle\Util;

use Base\ComunBundle\Util\Enums\ECalendario;
use Doctrine\ORM\EntityManager;

/**
 * Filtrado de tablas y QueryBuilder
 *
 * @author Franklin Rivero <frrivero@uci.cu>
 */
class FechaUtil
{
    /**
     * @author Franklin Rivero <frrivero@uci.cu>
     * Adiciona $dias a la $fechaInicio
     * @param \DateTime $fechaInicio
     * @param integetr $dias
     * @return \DateTime
     */
    public static function adicionarDiasNaturalAFecha(\DateTime $fechaInicioP, $dias)
    {
        $fechaInicio = FechaUtil::cloneDate($fechaInicioP);
        $fechaInicio->add(new \DateInterval("P" . $dias . "D"));
        return $fechaInicio;
    }

    /**
     * @author Julio Jesus Garcia <jjspider277@gmail.com>
     * Metodo para adicionar intervalos de hora y fecha
     * @param \DateTime $fecha
     * @param \int $deltaDays
     * * @param \int $deltaMinutes
     * @return String
     */
    public static function addInterval($fecha,$deltaDays,$deltaMinutes)
    {
        $fecha=$fecha->format("Y-m-d-h-i");
        $fecha=explode("-",$fecha);
        $date = new \DateTime();
        $date->setDate($fecha[0]  ,$fecha[1],$fecha[2]+$deltaDays);
        $date->setTime($fecha[3]  ,$fecha[4]+$deltaMinutes);
        return $date;
    }
    /**
     * @author Julio Jesus Garcia <jjspider277@gmail.com>
     * Encuentra % tiempo Transcurrido
     * @param \DateTime $fechaInicio
     * @param \DateTime $fechaFin
     * * @param \DateTime $fechaBase
     * @return String
     */
    public static function porCientoTranscurrido($fechaInicio,$fechaFin,$fechaBase=null)
    {
    if($fechaFin->getTimestamp()-self::getFechaActual()->getTimestamp()<0)
          return 100;
        if($fechaInicio->getTimestamp()-self::getFechaActual()->getTimestamp()>0)
          return -1;
        if ($fechaBase!=null)
            $fechaBase=$fechaBase->getTimestamp();
        else
            $fechaBase= self::getFechaActual()->getTimestamp();
        $intervalo =$fechaFin->getTimestamp()-$fechaInicio->getTimestamp();
        $fraccion=$fechaBase-$fechaInicio->getTimestamp();
        return intval((($fraccion/$intervalo)*100)>100?100:($fraccion/$intervalo)*100);
    }

    /**
     * @author Franklin Rivero <frrivero@uci.cu>
     * Adiciona $dias a la $fechaInicio
     * @param \DateTime $fechaInicio
     * @param integetr $dias
     * @return \DateTime
     */
    public static function restarDiasNaturalAFecha(\DateTime $fechaInicioP, $dias)
    {
        $fechaInicio = FechaUtil::cloneDate($fechaInicioP);
        $fechaInicio->sub(new \DateInterval("P" . $dias . "D"));
        return $fechaInicio;
    }
    /**
     * @author Franklin Rivero <frrivero@uci.cu>
     * @param \Doctrine\ORM\EntityManager $em
     * @param \DateTime $fechaInicio
     * @param type $dias
     * @param type $idExpdiente
     * @param type $idSala
     * @param type $idTribunal
     */
    public static function adicionarDiasSinFinSemanaAFecha(\DateTime $fechaInicioP, $dias)
    {
        $fechaInicio = FechaUtil::cloneDate($fechaInicioP);
        for ($i = 0; $i < $dias; $i++) {
            $fechaInicio->add(new \DateInterval("P1D"));
            if (FechaUtil::esFinSemana($fechaInicio))
                $i--;
        }

        return $fechaInicio;
    }
    /**
     * @author Franklin Rivero <frrivero@uci.cu>
     * @param \Doctrine\ORM\EntityManager $em
     * @param \DateTime $fechaInicio
     * @param type $dias
     * @param type $idExpdiente
     * @param type $idSala
     * @param type $idTribunal
     */
    public static function adicionarDiasHabilAFecha(EntityManager $em, \DateTime $fechaInicioP, $dias, $idExpediente, $idSala, $idTribunal)
    {
        $fechaInicio = FechaUtil::cloneDate($fechaInicioP);
        for ($i = 0; $i < $dias; $i++) {
            $fechaInicio->add(new \DateInterval("P1D"));
            if (!FechaUtil::isDiaHabil($em, $fechaInicio, $idSala, $idTribunal, $idExpediente))
                $i--;
        }
        $tribu = $em->find('ComunBundle:AG\Tribunal', $idTribunal);

        $hinicio = new \DateTime();
        $hinicio->setTime(7, 0, 0);
        if ($tribu->getHorarioHabil() != null) {
            $hhabil = $tribu->getHorarioHabil();
            $hinicio = $hhabil->getHoraInicio();
        }

        $fechaInicio->setTime($hinicio->format('H'), $hinicio->format('i'), $hinicio->format('s'));
        return $fechaInicio;
    }

    /**
     * @author Franklin Rivero <frrivero@uci.cu>
     * @return \DateTime
     */
    public static function getFechaActual()
    {
        $date = date_create(date('Y-m-d H:i:s'));
        return $date;
    }

    /**
     * @author Franklin Rivero <frrivero@uci.cu>
     * @param \DateTime $fechaVencimiento
     * @return Enums\EColor
     */
    public static function obtenerColorSemaforo($fechaVencimiento)
    {
        $fechaActual = FechaUtil::getFechaActual();
        $dif = $fechaVencimiento->diff($fechaActual);
        $dias = $dif->days;
        if ($dias == 0)
            return Enums\EColor::Amarillo;
        if ($dias > 0)
            return Enums\EColor::Verde;
        return Enums\EColor::Rojo;
    }

    public static function restarFechaXCalendario(EntityManager $em, $fechaInicioP, $fechaVencimiento, $idExpediente, $idSala, $idTribunal, $calendario = ECalendario::Natural)
    {
        $fechaInicio = FechaUtil::cloneDate($fechaInicioP);
        $fechaInicio->setTime(0,0,0);
        $cantidad = -1;
        if ($fechaVencimiento == null)
            throw new \Exception('La fecha de vencimiento no puede ser nula.');
        if ($calendario == ECalendario::Habil) {
            $continue = true;
            while ($continue == true) {
                $dif = $fechaVencimiento->diff($fechaInicio);
                $dias = $dif->days;
                if ($dias == 0)
                    $continue = false;
                $fechaInicio = FechaUtil::adicionarDiasHabilAFecha($em, $fechaInicio, 1, $idExpediente, $idSala, $idTribunal);
                $cantidad++;
            }
            return $cantidad;
        } else
            return FechaUtil::restarFechaNatural($fechaVencimiento, $fechaInicio);
    }

    /**
     * @author Frankln Rivero <frrivero@uci.cu>
     * @param \DateTime $fecha
     * @return boolean
     */
    public static function esFinSemana(\DateTime $fecha)
    {
        return $fecha->format('N') > 5;
    }

    /**
     * @author Frankln Rivero <frrivero@uci.cu>
     * @param \Doctrine\ORM\EntityManager $em
     * @param \DateTime $fecha
     * @param type $idSala
     * @param type $idTribunal
     * @param type $idExpediente
     */
    public static function isDiaHabil(EntityManager $em, \DateTime $fechaP, $idSala, $idTribunal, $idExpediente)
    {
        $fechaFin = new \DateTime();
        $fecha = clone $fechaP;
        $fecha->setTime(0, 0, 0);

        $fechaFin->setDate($fecha->format('Y'), $fecha->format('m'), $fecha->format('d'));
        $fechaFin->setTime(23, 59, 59);

        $repoRegla = $em->getRepository('ComunBundle:AG\Regla');
        $reglas = $repoRegla->listarXRangoFecha($fecha, $fechaFin, ResultType::ObjectType);

        if (count($reglas) == 0)
            return !FechaUtil::esFinSemana($fecha);

        if ($idExpediente != null) {
            $porExp = $repoRegla->filtarXReglasYExpediente($idExpediente, $reglas);
            if (count($porExp) > 0)
                return !FechaUtil::esFinSemana($fecha);
        }
        if ($idSala != null) {
            $porSala = $repoRegla->filtarXReglasYSala($idSala, $reglas);
            if (count($porSala) > 0)
                return !FechaUtil::esFinSemana($fecha);
        }
        if ($idTribunal != null) {
            $porTribunal = $repoRegla->filtarXReglasYTribunal($idTribunal, $reglas);
            if (count($porTribunal) > 0)
                return !FechaUtil::esFinSemana($fecha);
        }
        return FechaUtil::esFinSemana($fecha);
    }

    /**
     * @author Frankln Rivero <frrivero@uci.cu>
     * @param \Doctrine\ORM\EntityManager $em
     * @param type $idSala
     * @param type $idTribunal
     * @param type $idExpediente
     * @param \DateTime $fcha si no se le pasa el coge la fecha y hora actual
     * @return boolean
     */
    public static function isHoraHabil(EntityManager $em, $idSala, $idTribunal, $idExpediente, $fecha = null)
    {
        $actual = $fecha;

        if ($fecha == null)
            $actual = FechaUtil::getFechaActual();
        if (!FechaUtil::isDiaHabil($em, $actual, $idSala, $idTribunal, $idExpediente))
            return false;
        $tribu = $em->find('ComunBundle:AG\Tribunal', $idTribunal);


        $hhabil = $tribu->getHorarioHabil();
        $hinicio = NULL;
        $hfin = null;
        if ($hhabil != false) {
            $hinicio = $hhabil->getHoraInicio();
            $hfin = $hhabil->getHoraFin();
        } else
            throw new \Exception('Debe configurar horario h&aacute;bil del tribunal');
        return $actual >= $hinicio && $actual < $hfin;
    }

    /**
     * @author Franklin Rivero <frrivero@uci.cu>
     * @param \Doctrine\ORM\EntityManager $em
     * @param type $idSala
     * @param type $idTribunal
     * @param type $idExpediente
     * @return \DateTime
     */
    public static function proximoHabil(EntityManager $em, $idSala, $idTribunal, $idExpediente)
    {
        if (FechaUtil::isDiaHabil($em, new \DateTime(), $idSala, $idTribunal, $idExpediente)) {
            $tribu = $em->find('ComunBundle:AG\Tribunal', $idTribunal);
            $hhabil = $tribu->getHorarioHabil();
            $fecha = new \DateTime();
            $fecha->setTime($hhabil->getHoraInicio()->format('H'), $hhabil->getHoraInicio()->format('i'), $hhabil->getHoraInicio()->format('s'));
            return $fecha;
        }

        return FechaUtil::adicionarDiasHabilAFecha($em, FechaUtil::getFechaActual(), 1, $idExpediente, $idSala, $idTribunal);
    }

    /**
     * @author Franklin Rivero <frrivero@uci.cu>
     * @param EntityManager $em
     * @param \DateTime $fechaInicio (new DateTime)
     * @param $calendario
     * @param $idSala
     * @param $idTribunal
     * @param $idExpediente
     * @return \DateTime
     */
    public static function getFechaInicio(EntityManager $em, \DateTime $fechaInicio, $calendario, $idSala, $idTribunal, $idExpediente)
    {
//        ldd(FechaUtil::isHoraHabil($em, $idSala, $idTribunal, $idExpediente));
        if ($calendario == ECalendario::Habil && !FechaUtil::isHoraHabil($em, $idSala, $idTribunal, $idExpediente))
            return FechaUtil::proximoHabil($em, $idSala, $idTribunal, $idExpediente);
        elseif($calendario == ECalendario::Natural && !FechaUtil::isHoraHabil($em, $idSala, $idTribunal, $idExpediente))
            return FechaUtil::adicionarDiasNaturalAFecha($fechaInicio,1);

        return $fechaInicio;
    }

    /**
     * @author Franklin Rivero <frrivero@uci.cu>
     * @param \Doctrine\ORM\EntityManager $em
     * @param type $idSala
     * @param type $idTribunal
     * @param type $idExpediente
     * @return \DateTime
     */
    public static function getFechaVencimiento(EntityManager $em, \DateTime $fecha, $dias, $calendario = ECalendario::Natural, $idSala = null, $idTribunal = null, $idExpediente = null)
    {
        if ($calendario == ECalendario::Habil)
            return FechaUtil::adicionarDiasHabilAFecha($em, $fecha, $dias, $idExpediente, $idSala, $idTribunal);

        return FechaUtil::adicionarDiasNaturalAFecha($fecha, $dias);
    }

    /**
     * @author Yosviel Dominguez <ydominguezg@uci.cu>
     * @param \DateTime $fecha fecha a convertir a string
     * @return string Ejemplo  20 de agosto de 2013
     */
    public static function toString($fecha)
    {

        if (strpos($_SERVER['SERVER_SOFTWARE'], "Win32") !== false || strpos($_SERVER['SERVER_SOFTWARE'], "Win64") !== false) {
            setlocale(LC_TIME, 'Spanish');
            $fechaStr = strftime('%d de %B de %Y', strtotime($fecha->format('Y') . '-' . $fecha->format('m') . '-' . $fecha->format('j')));
        } else {
            setlocale(LC_ALL, "es_ES.UTF-8");
            $fechaStr = strftime("%e de %B de %Y", mktime(0, 0, 0, $fecha->format('m'), $fecha->format('j'), $fecha->format('Y')));
        }
        setlocale(LC_ALL, '');
        return $fechaStr;
    }
    /**
     * Retorna los dias de diferencia entre una fecha segun calendario natural
     * @author Yosviel Dominguez <ydominguezg@uci.cu>
     * @param \DateTime $fecha1
     * @param \DateTime $fecha2
     */
    public static function restarFechaNatural(\DateTime $pfecha1, \DateTime $pfecha2)
    {
        $fecha1 = FechaUtil::cloneDate($pfecha1);
        $fecha2 = FechaUtil::cloneDate($pfecha2);
        $fecha1->setTime(23, 0, 0);
        $fecha2->setTime(23, 0, 0);
        $dias = $fecha1->diff($fecha2)->days;
        return $dias;
    }
    /**
     * Retorna los dias de diferencia entre una fecha segun calendario natural
     * @author Yosviel Dominguez <ydominguezg@uci.cu>
     * @param \DateTime $fecha1
     * @param \DateTime $fecha2
     */
    public static function restarFechaNaturalAnnos(\DateTime $pfecha1, $pfecha2)
    {
        if($pfecha1 == null || $pfecha2 == null)
            return null;

        $fecha1 = FechaUtil::cloneDate($pfecha1);
        $fecha2 = FechaUtil::cloneDate($pfecha2);
        $fecha1->setTime(23, 0, 0);
        $fecha2->setTime(23, 0, 0);
        $fecha2->setDate($fecha2->format('Y'),1,1);
        $fecha1->setDate($fecha1->format('Y'),1,1);
        $year = $fecha1->diff($fecha2)->y;
        return $year;
    }
    public static function getDateFormat(){
        return "d-m-Y";
    }
    public static function getTimeFormat()
    {
        return "H:i";
    }
    /**
     * @param $fechaString
     * @param string $format
     * @return bool|string
     */
    public static function getFechaByFormat($fechaString,$format='Y-m-d H:i:s')
    {
        $real = "";
        $c = strlen($fechaString);
        for($i = 0; $i < $c && $fechaString[$i] != '(';$i++)
            $real.=$fechaString[$i];
        $fecha = date_format(date_create($real),$format);
        return $fecha;
    }
    public static function cloneDate(\DateTime $fecha)
    {
        $clone = new \DateTime();
        $clone->setDate($fecha->format('Y'), $fecha->format('m'), $fecha->format('d'));
        $clone->setTime($fecha->format('H'), $fecha->format('i'), $fecha->format('s'));
        return $clone;
    }

}

?>
