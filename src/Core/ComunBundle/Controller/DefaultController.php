<?php

namespace Core\ComunBundle\Controller;

use Core\ComunBundle\Enums\ETurno;
use Core\ComunBundle\Util\FechaUtil;
use Core\Planeacion\AdminBundle\Entity\GrupoEstudiantes;
use Core\Planeacion\AdminBundle\Entity\Hora;
use Core\Planeacion\AdminBundle\Entity\HoraPeriodo;
use Core\Planeacion\AdminBundle\Entity\Materia;
use Core\Planeacion\AdminBundle\Enums\EDia;
use Core\Planeacion\AdminBundle\Enums\ETipoMateria;

class DefaultController extends BaseController
{
    public function pruebaAction(){
        $vieja = 15;
        $nueva=1355;
        $materia = $this->getRepo('PlaneacionAdminBundle:PreferenciaProfeMateria')->findBy(array('materia'=>$vieja));

        foreach ($materia as $m){
            $m->setMateria( $this->getRepo('PlaneacionAdminBundle:PreferenciaProfeMateria')->find($nueva));
            $this->getEm()->persist($m);
                   }

        $this->getEm()->flush();

        $materia = $this->getRepo('PlaneacionAdminBundle:Materia')->find($nueva);
          $profeperiodpM = $materia->getProfePeriodo();
        foreach($profeperiodpM as $profeperio){
            $materia->removeProfePeriodo($profeperio);
            $this->getEm()->persist($materia);
     // ldd($profeperio);
            $profeperio->removeMateria($materia);
            $this->getEm()->persist($profeperio);
           // $nmateria = $this->getRepo('PlaneacionAdminBundle:PreferenciaProfeMateria')->findBy(array('materia'=>$nueva));
        }
        $this->getEm()->flush();
//        $dias = $this->getRepo('PlaneacionAdminBundle:Dia')->findAll();
//        foreach($horas as $hora)
//            foreach($dias as $dia){
//                if($hora->getNombre() != '17:50' && $dia->getId() != EDia::Sabado && $dia->getId() != EDia::Domingo)
//                    $hora->addDia($dia);
//                if($hora->getNombre() <= '17:50' && $dia->getId() == EDia::Sabado)
//                    $hora->addDia($dia);
//                $this->getEm()->persist($hora);
//            }
//        $this->getEm()->flush();
//        die;
    }

    public function readAction()
    {

        $foto = null;
        if($this->getUser() && $this->getUser()->getProfesor() )
            $foto = $this->getUser()->getProfesor()->getFoto();

        if($this->getUser()->onlyProfe())
        {
            $response = $this->forward('PlaneacionAdminBundle:ProfesorPropio:edit', array(
            ));
//            ldd($response);
            return $response;
        }
//            return $this->render('@PlaneacionAdmin/Profesor/hoja_propia.html.twig',array('foto'=>$foto,'onlyProfe'=>true));
//        $this->get('router')->
        return $this->render('@Comun/Default/index.html.twig',array('foto'=>$foto));
    }
    protected function changeClave()
    {
        $horas = $this->getEm()->getRepository("PlaneacionAdminBundle:Materia")->filterObjects(array('tipoMateria'=>ETipoMateria::Optativa,'planEstudio'=>4));
        foreach($horas as $hora)
        {
            $hora->setClave($hora->getClave()."p");
            $this->getEm()->persist($hora);
        }
        $this->getEm()->flush();
    }
    protected function horaPeriodoNames()
    {
        $horas = $this->getEm()->getRepository("PlaneacionAdminBundle:HoraPeriodo")->findAll();
        foreach($horas as $hora)
        {
            $hora->setNombre($hora->getHoraTime()->format(FechaUtil::getTimeFormat()));
            $this->getEm()->persist($hora);
        }
        $this->getEm()->flush();
    }
    protected function doit()
    {
//        $content = json_decode(file_get_contents("http://tribunalvirtual.pjenl.gob.mx/SVC/tvm/v2.3.1/tvm_get_perfil?AppVersion=2.3.1&IdUsuario=4644"));
//        ld($content);
        $xml = "<?xml version='1.0' standalone='yes'?><usuarios></usuarios>";
        $obj = new \SimpleXMLElement($xml);
        for($i=1;$i<=5000;$i++)
        {
             try {
                 if ($i != 2171 && $i != 4644 && $i != 4177 && $i != 4535 && $i != 4645 && $i != 4906 && $i != 5075 && $i != 5076 && $i != 4216) {
                     $content = json_decode(file_get_contents("http://tribunalvirtual.pjenl.gob.mx/SVC/tvm/v2.3.1/tvm_get_perfil?AppVersion=2.3.1&IdUsuario=" . $i));
    //                ld($i);
                     $content = $content->User;
                     $usuario = $obj->addChild("usuario");
                     $vars = get_object_vars($content);
                     foreach ($vars as $key => $var) {
                         //var_dump($var);
                         if ($vars[$key] != false && $vars[$key] != "")
                             $usuario->addChild($key, $vars[$key]);
    //                $var = "\n".$key.":".$vars[$key];
                     }
                 }
             }catch(\Exception $e)
             {
                 ld($i);
             }


        }
        file_put_contents("G:\\wamp\\www\\test\\"."hasta el 5000.xml",$obj->asXML());
//        var_dump($obj->asXML());
        die('paco');
    }
    protected function updateHoraProfePeriodo()
    {
        $profePHs = $this->getEm()->getRepository("PlaneacionAdminBundle:ProfePeriodoHorario")->findAll();
        foreach ($profePHs as $profePH) {
            $periodo = $profePH->getProfePeriodo()->getPeriodo()->getId();
            $hora=$profePH->getHora()->getHora();
            $horaTime = $this->getEm()->getRepository("PlaneacionAdminBundle:HoraPeriodo")->filterObjects(array('horaTime'=>$hora,'periodo'=>$periodo));
            if(count($horaTime) > 1) {
                ld($periodo);
                ldd($hora);
            }
            $profePH->setHoraPeriodo($horaTime[0]);
            $this->getEm()->persist($profePH);
        }
        $this->getEm()->flush();

    }
    protected function updateHoraString()
    {
        $dias = $this->getEm()->getRepository("PlaneacionAdminBundle:HoraPeriodo")->findAll();
        foreach ($dias as $dia) {
            $dia->setHoraTime($dia->getHora()->getHora());
            $this->getEm()->persist($dia);
        }
        $this->getEm()->flush();

    }
    protected function creaByDatos($hora,$periodo,$turno)
    {
        $dias = $this->getEm()->getRepository("PlaneacionAdminBundle:Dia")->filterObjects(array('id'=>array('>=',2)));//sabado 7 domingo 8
        $sab = $this->getEm()->getRepository("PlaneacionAdminBundle:Dia")->find(EDia::Sabado);

        $obj = new HoraPeriodo();
        $obj->setHora($hora);
        $obj->setPeriodo($periodo);
        $obj->setTurno($turno);
        if($periodo->getId() == 3 && $hora->getNombre() == '17:50')
            $obj->addDia($sab);
        else{
            if($turno->getId() == ETurno::Nocturno) {
                foreach ($dias as $dia)
                    if ($dia->getId() != EDia::Sabado && $dia->getId() != EDia::Domingo) {
//                        ld("turno:".$turno->getId()."dia:".$dia->getId());
                        $obj->addDia($dia);
                    }
            }
            else{
                foreach ($dias as $dia)
                    if($dia->getId() != EDia::Domingo) {
                        $obj->addDia($dia);
//                        ld("turno:".$turno->getId()."dia:".$dia->getId());
                    }
            }
        }
        $this->getEm()->persist($obj);

    }
    protected function newHoras(){
        $horas = $this->getEm()->getRepository("PlaneacionAdminBundle:Hora")->filterObjects();
        $dias = $this->getEm()->getRepository("PlaneacionAdminBundle:Dia")->filterObjects(array('id'=>array('>=',2)));//sabado 7 domingo 8

        $matu = $this->getEm()->getRepository("PlaneacionAdminBundle:Turno")->find(ETurno::Matutino);
        $vesp = $this->getEm()->getRepository("PlaneacionAdminBundle:Turno")->find(ETurno::Vespertino);
        $pilo = $this->getEm()->getRepository("PlaneacionAdminBundle:Turno")->find(ETurno::Piloto);
        $noct = $this->getEm()->getRepository("PlaneacionAdminBundle:Turno")->find(ETurno::Nocturno);

        $periodos = $this->getEm()->getRepository("PlaneacionAdminBundle:Periodo")->filterObjects();
        foreach($periodos as $periodo)
        {
                foreach($horas as $hora)
                {
                        if($periodo->getId() == 3)
                        {
                            if($hora->getNombre()== '17:50')
                                $this->creaByDatos($hora,$periodo,$vesp);
                            elseif(($hora->getNombre()== '18:10' || $hora->getNombre()== '18:50' ||$hora->getNombre()== '19:30' ||$hora->getNombre()== '20:10' ||$hora->getNombre()== '20:50'))
                                $this->creaByDatos($hora,$periodo,$noct);
                            elseif($hora->getId() <= 4)
                                $this->creaByDatos($hora,$periodo,$matu);
                            elseif($hora->getId() <= 9)
                                $this->creaByDatos($hora,$periodo,$pilo);
                            elseif($hora->getId() <= 14)
                                $this->creaByDatos($hora,$periodo,$vesp);
                        }
                        else{
                            if($hora->getNombre()== '17:50')
                                $this->creaByDatos($hora,$periodo,$vesp);
                            elseif(($hora->getNombre()== '18:30' || $hora->getNombre()== '19:10' ||$hora->getNombre()== '19:50' ||$hora->getNombre()== '20:30') )
                                $this->creaByDatos($hora,$periodo,$noct);
                            elseif($hora->getId() <= 4)
                                $this->creaByDatos($hora,$periodo,$matu);
                            elseif($hora->getId() <= 9)
                                $this->creaByDatos($hora,$periodo,$pilo);
                            elseif($hora->getId() <= 14)
                                $this->creaByDatos($hora,$periodo,$vesp);
                        }
                }
        }
//        die;
        $this->getEm()->flush();
    }
    protected function horasDias()
    {
        $horas = $this->getEm()->getRepository("PlaneacionAdminBundle:Hora")->filterObjects(array('id'=>array('>=',21)));
        $dias = $this->getEm()->getRepository("PlaneacionAdminBundle:Dia")->filterObjects(array('id'=>array('>=',2)));

        foreach($horas as $hora)
        {
            foreach($dias as $dia)
            {
                if($dia->getId() < 7 || ($dia->getId() == 7 && $hora->getTurno()->getId() != ETurno::Nocturno) )
                {
                    /**
                     * @var Hora $hora
                     */
                    $hora->addDia($dia);
                }
            }
            $this->getEm()->persist($hora);
        }
        $this->getEm()->flush();
    }
    protected function horasPeriodo()
    {
        $horas = $this->getEm()->getRepository("PlaneacionAdminBundle:Hora")->filterObjects(array('id'=>array('<=',14)));
        foreach($horas as $hora)
        {
            $tmp = new Hora();
            $tmp->setNombre($hora->getNombre());
            $tmp->setHora($hora->getHora());
            $tmp->setPeriodo($this->getEm()->find('PlaneacionAdminBundle:Periodo',4));
            $this->getEm()->persist($tmp);
        }
        $this->getEm()->flush();
    }
    protected function mayusculizarMaterias()
    {
        $materias = $this->getEm()->getRepository("PlaneacionAdminBundle:Materia")->findAll();
        foreach($materias as $materia){
            $name = $materia->getNombre();
            $name = strtoupper($name);
            $name = str_replace('á','Á',$name);
            $name = str_replace('é','É',$name);
            $name = str_replace('í','Í',$name);
            $name = str_replace('ó','Ó',$name);
            $name = str_replace('ú','Ú',$name);
            $materia->setNombre($name);
            $this->getEm()->persist($materia);
        }
        $this->getEm()->flush();
    }
    protected function updateTipoMateria()
    {
        $materias = $this->getEm()->getRepository("PlaneacionAdminBundle:Materia")->findAll();
        foreach($materias as $materia){
            if($materia->getLibreEleccion() == 1)
                $materia->setTipoMateria($this->getEm()->getRepository("PlaneacionAdminBundle:TipoMateria")->find(3));
            else if($materia->getOpcional() == 1)
                $materia->setTipoMateria($this->getEm()->getRepository("PlaneacionAdminBundle:TipoMateria")->find(2));
            else
                $materia->setTipoMateria($this->getEm()->getRepository("PlaneacionAdminBundle:TipoMateria")->find(1));
            $this->getEm()->persist($materia);
        }
        $this->getEm()->flush();
    }
    protected function saveNombreGrupos()
    {
        $grupos = $this->getEm()->getRepository("PlaneacionAdminBundle:GrupoEstudiantes")->getOrderedForNaming();
//        ldd($grupos);
        for($i=0; $i < count($grupos) ;$i++)
        {
            $grupo = $grupos[$i];
            /**
             * @var $grupo GrupoEstudiantes
             */
            $turno = $grupo->getTurno()->getId();
            $count = 1;
            $grupo->setNombre($count++);
            for($j = $i+1; $j <  count($grupos) && $grupos[$j]->getTurno()->getId() == $turno ;$j++)
            {
                $grupos[$j]->setNombre($count++);
            }
            $i=$j-1;
            $this->getEm()->persist($grupo);
        }
        $this->getEm()->flush();
    }
    protected function saveGrpos()
    {
        $grupos = $this->getEm()->getRepository("PlaneacionAdminBundle:GrupoEstudiantes")->filterObjects();
        foreach ($grupos as $grupo)
        {
            /**
             * @var $grupo GrupoEstudiantes
             */
            $aula = $this->getEm()->getRepository("PlaneacionAdminBundle:Aula")->filterObjects(array('nombre'=>$grupo->getAulaString()));
            if(count($aula) == 0) {
                ld($grupo->getAulaString());
            }
            else {
                $grupo->setAula($aula[0]);
                $this->getEm()->persist($grupo);
            }
        }
        $this->getEm()->flush();
    }
    protected  function materias()
    {

        $materias = $this->getEm()->getRepository("PlaneacionAdminBundle:Materia")->filterObjects(array('id'=>array('>',90)));
        foreach($materias as $materia){
            /**
             * @var $materia Materia
             */
//            $materia->setPlanEstudio($this->getEm()->find('PlaneacionAdminBundle:PlanEstudio',1));
            if($materia->getClave()[0]=="C")
                $materia->setPlanEstudio($this->getEm()->find('PlaneacionAdminBundle:PlanEstudio',2));
            else
                $materia->setPlanEstudio($this->getEm()->find('PlaneacionAdminBundle:PlanEstudio',3));
            $this->getEm()->persist($materia);
        }
        $this->getEm()->flush();
    }
    protected function createGrupos(){
        $turnos = $this->getEm()->getRepository("PlaneacionAdminBundle:Turno")->findAll();
        $licenciaturas= $this->getEm()->getRepository("PlaneacionAdminBundle:Licenciatura")->findAll();
        $periodos= $this->getEm()->getRepository("PlaneacionAdminBundle:Periodo")->findAll();

        foreach($periodos as $periodo) {
            foreach ($turnos as $turno) {
                foreach ($licenciaturas as $licenciatura) {
                    for ($i = 1; $i <= 5; $i++) {
                        $grupo = new GrupoEstudiantes();
                        $grupo->setNombre($i);
                        $grupo->setLicenciatura($licenciatura);
                        $grupo->setTurno($turno);
                        $grupo->setPeriodo($periodo);
                        $this->getEm()->persist($grupo);
                    }
                }
                $this->getEm()->flush();
            }
        }
    }
}
