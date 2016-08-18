<?php

namespace Core\Planeacion\AdminBundle\Repository;


use Core\ComunBundle\Util\ResultType;
use Core\Planeacion\AdminBundle\Entity\HoraPeriodo;
use Doctrine\ORM\Mapping as ORM;

class HoraPeriodoRepository extends \Core\ComunBundle\Util\NomencladoresRepository
{
    public function getOrderedByPeriodo($idPeriodo, $filters = array(), $resultType = ResultType::ObjectType)
    {
        $filters['periodo'] = $idPeriodo;
        $qb = $this->getQB();
        return $this->filterQB($qb, $filters, $resultType, array('horaTime' => 'asc'));
    }


    public function getHorarioByGrupo($filters = array(), $resultType = ResultType::ObjectType)
    {
        $periodo = $filters['periodo'];
        $id = $filters['grupo'];

        $arr = $this->getRepo("PlaneacionAdminBundle:GrupoHorarioAnteproyecto")->findAulasByGroup(array("periodo" => $periodo, "grupo" => $id));
        $grupo = $this->getRepo("PlaneacionAdminBundle:GrupoEstudiantes")->find($id);
        $aula = $grupo->getAula();
        $aulas_grupo = array();
        /*if (count($arr) == 0) {
            $aulas_grupo[] = $aula;
        } else {*/
        for ($i = 0; $i < count($arr); $i++) {
            $aulas_grupo[$arr[$i]->getAula()->getId()]["nombre"] = $arr[$i]->getAula()->getNombre();
            $aulas_grupo[$arr[$i]->getAula()->getId()]["id"] = $arr[$i]->getAula()->getId();
        }
        //}
        //$aulas_grupo[$aula->getId()]["nombre"] = $aula->getNombre();
        //$aulas_grupo[$aula->getId()]["id"] = $aula->getId();
        //en aulas_grupos todas las aulas en las que un grupo tiene clases
        //ldd($aulas_grupo);
        //$this->getRepo("PlaneacionAdminBundle:GrupoHorarioAnteproyecto")->findAll();
        $gruposHorarios = $this->getRepo("PlaneacionAdminBundle:GrupoHorarioAnteproyecto")->findByCriteria(array("periodo" => $periodo, "grupo" => $grupo->getId()));
        $xs = array();
            if ($gruposHorarios != 0) //{
            foreach ($gruposHorarios as $x) {

                $aulas_grupo[$x->getAula()->getId()]["nombre"] = $x->getAula()->getNombre();
                $aulas_grupo[$x->getAula()->getId()]["id"] = $x->getAula()->getId();
                if ($x->getProfePeriodo() != null) {
                    $xs[] = array($x->getAula()->getId(),
                        $x->getAula()->getNombre(),
                        $x->getHora()->getId(),
                        $x->getDia()->getId(),
                        $x->getMateria()->getId(),
                        $x->getMateria()->getNombre(),
                        $x->getMateria()->getClave(),
                        $x->getGrupo()->getId(),
                        $x->getGrupo()->getNombre(),
                        $x->getProfePeriodo()->getProfesor()->getNumeroEmpleado()
                    );
                } else {
                    if ($x->getHora() != null and $x->getMateria() != null and $x->getDia() != null) {
                        $xs[] = array($x->getAula()->getId(),
                            $x->getAula()->getNombre(),
                            $x->getHora()->getId(),
                            $x->getDia()->getId(),
                            $x->getMateria()->getId(),
                            $x->getMateria()->getNombre(),
                            $x->getMateria()->getClave(),
                            $x->getGrupo()->getId(),
                            $x->getGrupo()->getNombre()
                        );
                    } else {
                        $this->getEntityManager()->remove($x);
                        $this->getEntityManager()->flush();
                    }
                }
            }
            /*} else {
                $aulas_grupo[] = $aula;
            }*/
        if (count($xs) == 0) {
            $aulas_grupo[] = $aula;
        }
        $dias = $this->getRepo("PlaneacionAdminBundle:Dia")->getEntreSemana();
        $horas = $this->getRepo("PlaneacionAdminBundle:HoraPeriodo")->getOrderedByPeriodo($periodo);
        return array("horarios" => $xs, "aulas" => $aulas_grupo, "grupo" => $grupo, "room" => $aula->getId(), "horas" => $horas, "dias" => $dias);
    }

    public function duplicarHoras($anterior, $siguiente)
    {

        $horasPeriodo = $this->findBy(array("periodo" => $anterior->getId()));

        foreach ($horasPeriodo as $horaPeriodo) {
            $nHora = new HoraPeriodo();
            $nHora->setTurno($horaPeriodo->getTurno());
            $nHora->setNombre($horaPeriodo->getNombre());
            $nHora->setPeriodo($siguiente);
            $nHora->setHoraTime($horaPeriodo->getHoraTime());
            $this->getEntityManager()->persist($nHora);

        }
        $this->getEntityManager()->flush();
    }

}
