<?php

namespace ADEPSOFT\Planeacion\AdminBundle\Repository;


use ADEPSOFT\ComunBundle\Util\ResultType;
use ADEPSOFT\ComunBundle\Util\UtilRepository2;
use ADEPSOFT\ComunBundle\Util\UtilRepository2Config;
use ADEPSOFT\Planeacion\AdminBundle\Enums\ELicenciatura;
use Doctrine\ORM\Mapping as ORM;

class ProfesorRepository extends \ADEPSOFT\ComunBundle\Util\NomencladoresRepository
{
    private  $joinedProfePeriodo =false;
    private   $joinedProfePeriodoHorario=false;
    private   $hora=false;
    private   $contexto3=false;
    private   $filterGlobal=array();

    public function listTable($filters=array(),$order=array(),$resultType=ResultType::ObjectType)
    {
        UtilRepository2Config::$paginate=false;

        //Order estabishment
        if(count($order) == 0)
            $order['id'] ='desc';

        if(array_key_exists('lic',$order) && $order['lic']!=null)
        {
            if($order['lic'] == 'asc')
                $order['carrera'] = 'asc';
            else
                $order['carrera'] = 'desc';

            unset($order['lic']);
        }
        //Filter establishment
        if(array_key_exists('lic',$filters) && $filters['lic']!=null)
        {
            if($filters['lic'] == ELicenciatura::Criminologia)
                $filters['carrera'] = ELicenciatura::Criminologia;
            if($filters['lic'] == ELicenciatura::Derecho)
                $filters['carrera'] = ELicenciatura::Derecho;
            unset($filters['lic']);
        }


        $rf=array();

//        ld($filters);
        $aux=array();
      
        $filters1 = $this->clearFilterContexto1($filters);//

        $filters2 = $this->clearFilterContexto2($filters);

        $filters3 = $this->getFitlersContexto3($filters);

        $filters4 = $this->clearFilterContexto4($filters);
           foreach ($filters as $key=>$filter)
             if ($filter!="")
                 $this->filterGlobal[$key]=$filter;
                // ldd($this->filterGlobal);
        $filters=$aux;
	foreach($filters as $f)
		$this->filterGlobal[]=$f;
       // $filters1 = array_merge($filters1,$filters);
        $filters2 = array_merge($filters2,$filters);
        $filters3 = array_merge($filters3,$filters);
        $filters4 = array_merge($filters4,$filters);
      //  ldd($filters3);
        $contexto1= $this->contexto1($filters1,array());
        $contexto2= $this->contexto2($filters2,array(),$filters3);
        $contexto3=$this->contexto3($filters3);

        $contexto4= $this->contexto4($filters4,array(),$filters3);

        $r1 = $contexto1[0];
        $r2 = $contexto2[0];
        $r3 = $contexto3[0];
        $r4 = $contexto4[0];

        $contexto1=$contexto1[1];
        $contexto2=$contexto2[1];
        $contexto3=$contexto3[1];
        $contexto4=$contexto4[1];
   //     ld($contexto3);
        if($contexto1)
            $rf =$r1;
        elseif($contexto2)
            $rf = $r2;
        elseif($contexto4)
            $rf = $r4;
        else {
            $rf = $r3;
        }


        if($contexto4)
            $rf= array_intersect($rf,$r4);
        if($contexto1)
            $rf= array_intersect($rf,$r1);
        if($contexto2)
            $rf= array_intersect($rf,$r2);
        if($contexto3)
            $rf= array_intersect($rf,$r3);
       // ldd($r2);
        $order=array("apellidos"=>"asc");
        if(count($rf) > 0) {
            $rf = $this->obtenerXArrayId($rf, $resultType,$order,'profesor');
            UtilRepository2Config::$paginate=true;
            UtilRepository2::getSession()->set('total', count($rf));
            $rf = array_slice($rf, UtilRepository2::getContainer()->get('request')->get('iDisplayStart'), UtilRepository2::getContainer()->get('request')->get('iDisplayLength'));
            return $rf;
        }
        else {
            UtilRepository2::getSession()->set('total', 0);
            return array();
        }

    }
    public function contexto1(&$filters,$order)
    {
      //  ldd($filters);
        $contexto1=false;
        $filtro_periodo_materia=null;
        $materia_imparte = null;
        $hora_clase_materia=null;
        $dia_clase_materia = null;
        $qb = $this->getQB();
        $r1=array();
        if(array_key_exists('filtro_periodo_materia',$filters) && $filters['filtro_periodo_materia'] != null && $filters['filtro_periodo_materia'] != "" ){
            $filtro_periodo_materia = $filters['filtro_periodo_materia'];
            unset($filters['filtro_periodo_materia']);
        }
        if(array_key_exists('materia_imparte',$filters)  && $filters['materia_imparte'] != null && $filters['materia_imparte'] != "" ){
            $materia_imparte = $filters['materia_imparte'];
            unset($filters['materia_imparte']);
        }
        if(array_key_exists('hora_clase_materia',$filters) && $filters['hora_clase_materia'] != null && $filters['hora_clase_materia'] != "" ){
            $hora_clase_materia= $filters['hora_clase_materia'];
            unset($filters['hora_clase_materia']);
        }
        if(array_key_exists('dia_clase_materia',$filters) && $filters['dia_clase_materia'] != null && $filters['dia_clase_materia'] != "" ){
            $dia_clase_materia = $filters['dia_clase_materia'];
            unset($filters['dia_clase_materia']);
        }



        if($filtro_periodo_materia !== null ){
            $qb->join('profesor.profePeriodo', 'profePeriodo');
            $qb->andWhere('profePeriodo.periodo = :filtro_periodo')->setParameter('filtro_periodo',$filtro_periodo_materia);
            $qb->join('profePeriodo.profePeriodoHorario','profePeriodoHorario');
            $this->joinedProfePeriodo = true;
            $this->joinedProfePeriodoHorario = true;
            $contexto1=true;
        }

        if($hora_clase_materia != null ){
            if(!$this->joinedProfePeriodo)
                $qb->join('profesor.profePeriodo', 'profePeriodo');
            if(!$this->joinedProfePeriodoHorario)
                $qb->join('profePeriodo.profePeriodoHorario', 'profePeriodoHorario');
            if (!$this->hora){
             $qb->join('profePeriodoHorario.hora','hora');
            $qb->andWhere("hora.nombre = :hora_clase")->setParameter('hora_clase',$hora_clase_materia);
            $this->hora=true;
            $contexto1=true;
            }
        }
        if($dia_clase_materia != null ){
            $qb->andWhere("profePeriodoHorario.dia = :dia_clase")->setParameter('dia_clase',$dia_clase_materia);
        }
        if($materia_imparte !== null){
            if(!$this->joinedProfePeriodo)
                $qb->join('profesor.profePeriodo', 'profePeriodo');
            if(!$this->joinedProfePeriodoHorario) {
                $qb->join('profePeriodo.profePeriodoHorario', 'profePeriodoHorario');
                $qb->leftJoin('profePeriodo.materia', 'materia');
                $qb->leftJoin('profePeriodo.historicoMateriaManual', 'materia2');
                $qb->andWhere('materia.id = :materia_imparte or materia2.id = :materia_imparte2')->setParameter('materia_imparte2',$materia_imparte)->setParameter('materia_imparte',$materia_imparte);
            }
            else {
                $qb->join('profePeriodoHorario.materia', 'materia');
                $qb->andWhere('materia.id = :materia_imparte')->setParameter('materia_imparte', $materia_imparte);
            }
        }
            $r1 = $this->filterQB($qb, $this->filterGlobal , ResultType::IDSType, $order);
        return array($r1,$contexto1);
    }
    public function contexto2(&$filters,$order){
        $ocupado=true;
        $r =array();
        $filtered= false;
        $contexto2=false;
        $qb = $this->getQB();
        $this->joinedProfePeriodo = false;
        $this->joinedProfePeriodoHorario = false;
        $this->hora = false;


        if(array_key_exists('filtro_periodo',$filters) && $filters['filtro_periodo'] != null ){
            if(!$this->joinedProfePeriodo){
                $qb->join('profesor.profePeriodo', 'profePeriodo');
            $qb->andWhere('profePeriodo.periodo = :filtro_periodo')->setParameter('filtro_periodo',$filters['filtro_periodo']);
            unset($filters['filtro_periodo']);
            $this->joinedProfePeriodo=true;
            $contexto2=true;

        }
        }

        if(array_key_exists('libre_ocupado',$filters) && $filters['libre_ocupado'] != null){
            if($filters['libre_ocupado']==1)
                $ocupado=false;
            unset($filters['libre_ocupado']);
        }
        if(array_key_exists('filtro_descarga',$filters) && $filters['filtro_descarga'] != null){
            $descarga=$filters["filtro_descarga"];
            if(!$this->joinedProfePeriodo)
                $qb->join('profesor.profePeriodo', 'profePeriodo');
            //  $qb->join('profePeriodo.tipoDescarga', 'tipoDescarga');
            if ($descarga=='1')
                $qb->join('profePeriodo.tipoDescarga', 'tipoDescarga');
            else
                $qb->andWhere('profePeriodo.tipoDescarga = :descarga')->setParameter('descarga',$descarga);
            $this->joinedProfePeriodo=true;
            $contexto2=true;
            unset($filters['filtro_descarga']);
        }
        if(array_key_exists('filtro_turno',$filters) &&  $filters['filtro_turno'] != null &&  $filters['filtro_turno'] != "" ){
            $turno=$filters["filtro_turno"];
            if(!$this->joinedProfePeriodo)
                $qb->join('profesor.profePeriodo','profePeriodo');

                if(!$this->joinedProfePeriodoHorario)
                    $qb->join('profePeriodo.profePeriodoHorario','profePeriodoHorario');


            if(!$this->hora)
                $qb->join('profePeriodoHorario.hora', 'hora');

            $qb->join('hora.turno', 'turno');
            $qb->andWhere("turno.id = :turno")->setParameter('turno', $turno);
            $this->hora=true;
            $this->joinedProfePeriodoHorario = true;
            $this->joinedProfePeriodo = true;
            $contexto2 = true;
//            }
            unset($filters['filtro_turno']);
//            ldd($op);
        }
        // ld( $qb->getQuery()->getDQL());
        if(array_key_exists('hora_clase',$filters) &&  $filters['hora_clase'] != null &&  $filters['hora_clase'] != "" ){

//            if(count($filters['hora_clase'][1])>0) {

            if (!$this->joinedProfePeriodo)
                $qb->join('profesor.profePeriodo', 'profePeriodo');
            if (!$this->joinedProfePeriodoHorario)
                $qb->join('profePeriodo.profePeriodoHorario', 'profePeriodoHorario');
            if(!$this->hora)
                $qb->join('profePeriodoHorario.hora', 'hora');

            $qb->andWhere("hora.nombre = :hora_clase")->setParameter('hora_clase', $filters['hora_clase']);
            $this->hora=true;
            $this->joinedProfePeriodoHorario = true;
            $this->joinedProfePeriodo = true;
            $contexto2 = true;
//            }
            unset($filters['hora_clase']);
//            ldd($op);
        }

      //  ldd($qb->getDQL());

        //  ldd( $qb->getQuery()->getDQL());
        if(array_key_exists('dia_clase',$filters)  &&  $filters['dia_clase'] != null &&  $filters['dia_clase'] != ""){
//            if(count($filters['dia_clase'][1])>0) {
            if (!$this->joinedProfePeriodo)
                $qb->join('profesor.profePeriodo', 'profePeriodo');
            if (!$this->joinedProfePeriodoHorario)
                $qb->join('profePeriodo.profePeriodoHorario', 'profePeriodoHorario');

            $qb->andWhere("profePeriodoHorario.dia = :dia_clase")->setParameter('dia_clase', $filters['dia_clase']);

            $this->joinedProfePeriodoHorario = true;
            $this->joinedProfePeriodo = true;
            $contexto2 = true;
//            }
            unset($filters['dia_clase']);
        }
        if(!$ocupado && ($this->joinedProfePeriodoHorario || $this->joinedProfePeriodo))
        {
//            UtilRepository2::getSession()->set('finishedTable', true);
            $r = $this->filterQB($qb, $filters, ResultType::IDSType);
//            UtilRepository2::getSession()->set('finishedTable', false);
            $this->joinedProfePeriodoHorario=false;
            $this->joinedProfePeriodo=false;
            $contexto2=true;
            $filtered=true;
//            $qb = $this->getQB();
        }

//        ldd($filters);
//        print ($qb->getQuery()->getSQL());
//        ldd('pac');
//        UtilRepository2::getSession()->set('total',false);

        if(!$filtered && $contexto2) {
            //$this->contexto3($qb,$filterContexto3);
            $r = $this->filterQB($qb, $filters, ResultType::IDSType, $order);
        }
        else{
            if(count($r)>0 && $contexto2){
                $qb = $this->getQB()->andWhere("profesor.id not in (:ids)")->setParameter('ids',$r);
                $r = $this->filterQB($qb, $this->filterGlobal , ResultType::IDSType, $order);
            }

        }
        // ld( $r);
        // ldd( $qb->getQuery()->getDQL());
        //  ldd( $contexto2);
        return array($r,$contexto2);
    }
    public function contexto4(&$filters,$order)
    {
        $contexto4=false;
        $filtro_periodo_grupo=null;
        $aula = null;
        $grupo=null;
        $hora_grupo=null;
        $dia_grupo=null;
        $this->joinedProfePeriodo = false;
        $this->joinedProfePeriodoHorario = false;

        $qb = $this->getQB();
        $r4=array();

        if(array_key_exists('filtro_periodo_grupo',$filters) && $filters['filtro_periodo_grupo'] != null && $filters['filtro_periodo_grupo'] != "" ){
            $filtro_periodo_grupo = $filters['filtro_periodo_grupo'];
            unset($filters['filtro_periodo_grupo']);
            $contexto4=true;
        }
        if(array_key_exists('hora_grupo',$filters) && $filters['hora_grupo'] != null && $filters['hora_grupo'] != "" ){
            $hora_grupo = $filters['hora_grupo'];
            unset($filters['hora_grupo']);
            $contexto4=true;
        }
        if(array_key_exists('dia_grupo',$filters) && $filters['dia_grupo'] != null && $filters['dia_grupo'] != "" ){
            $dia_grupo = $filters['dia_grupo'];
            unset($filters['dia_grupo']);
            $contexto4=true;
        }
        if(array_key_exists('grupo',$filters) && $filters['grupo'] != null && $filters['grupo'] != "" ){
            $grupo= $filters['grupo'];
            unset($filters['grupo']);
            $contexto4=true;
        }

        if(array_key_exists('aula',$filters)  && $filters['aula'] != null && $filters['aula'] != "" ){
            $aula = $filters['aula'];
            unset($filters['aula']);
            $contexto4=true;
        }

        if($filtro_periodo_grupo !== null ){
            $qb->join('profesor.profePeriodo', 'profePeriodo');
            $qb->andWhere('profePeriodo.periodo = :filtro_periodo')->setParameter('filtro_periodo',$filtro_periodo_grupo);
            $this->joinedProfePeriodo = true;
            $contexto4=true;
        }
        if($hora_grupo !== null ){
            if(! $this->joinedProfePeriodo)
                $qb->join('profesor.profePeriodo', 'profePeriodo');
            if(! $this->joinedProfePeriodoHorario)
                $qb->join('profePeriodo.profePeriodoHorario','profePeriodoHorario');
            $qb->join('profePeriodoHorario.hora','hora');
            $qb->andWhere("hora.nombre = :hora_clase")->setParameter('hora_clase',$hora_grupo);
            $this->joinedProfePeriodo = true;
            $this->joinedProfePeriodoHorario = true;
            $contexto4=true;
        }
        if($dia_grupo)
        {
            if(! $this->joinedProfePeriodo)
                $qb->join('profesor.profePeriodo', 'profePeriodo');
            if(! $this->joinedProfePeriodoHorario)
                $qb->join('profePeriodo.profePeriodoHorario','profePeriodoHorario');
            $qb->andWhere("profePeriodoHorario.dia = :dia")->setParameter('dia',$dia_grupo);
            $this->joinedProfePeriodo = true;
            $this->joinedProfePeriodoHorario = true;
            $contexto4=true;
        }

        if($grupo != null ){
            if(!$this->joinedProfePeriodo)
                $qb->join('profesor.profePeriodo', 'profePeriodo');
            if(!$this->joinedProfePeriodoHorario)
                $qb->join('profePeriodo.profePeriodoHorario','profePeriodoHorario');
            $qb->andWhere("profePeriodoHorario.grupo = :grupo")->setParameter('grupo',$grupo);
            $this->joinedProfePeriodoHorario=true;
            $this->joinedProfePeriodo=true;
            $contexto4=true;
        }
        if($aula !== null){
            if(! $this->joinedProfePeriodo)
                $qb->join('profesor.profePeriodo', 'profePeriodo');
            if(! $this->joinedProfePeriodoHorario) {
                $qb->join('profePeriodo.profePeriodoHorario','profePeriodoHorario');
            }
            $qb->join('profePeriodoHorario.grupo','grupo');
            $qb->andWhere("grupo.aula = :aula")->setParameter('aula',$aula);
            $this->joinedProfePeriodo = true;
            $this->joinedProfePeriodoHorario = true;
            $contexto4=true;
        }
  if (array_key_exists('bilingue',$filters)  && $filters['bilingue'] != null && $filters['bilingue'] != ""){
        if ($filters["bilingue"]!=-1){
            if(! $this->joinedProfePeriodo)
                $qb->join('profesor.profePeriodo', 'profePeriodo');
            if(!$this->joinedProfePeriodoHorario)
                $qb->join('profePeriodo.profePeriodoHorario','profePeriodoHorario');
            if ($grupo == null)
                $qb->join("profePeriodoHorario.grupo","grupo");
            $grupo=true;
            if ($filters["bilingue"]==1)
                $qb->andWhere("grupo.bilingue = :bilingue")->setParameter('bilingue',"true");
            else
                $qb->andWhere("grupo.bilingue = :bilingue")->setParameter('bilingue',"false");
            $contexto4=true;
            $this->joinedProfePeriodo = true;
            $this->joinedProfePeriodoHorario = true;
        }
        unset($filters['bilingue']);
    }
        //ldd($filters);
        if (array_key_exists('terceros',$filters)  && $filters['terceros'] != null && $filters['terceros'] != ""){
            if ($filters["terceros"]!=-1){
                if(! $this->joinedProfePeriodo)
                    $qb->join('profesor.profePeriodo', 'profePeriodo');
                if(!$this->joinedProfePeriodoHorario)
                    $qb->join('profePeriodo.profePeriodoHorario','profePeriodoHorario');
                if ($grupo == null)
                    $qb->join("profePeriodoHorario.grupo","grupo");
                if ($filters["terceros"]==1)
                    $qb->andWhere("grupo.terceros = :terceros")->setParameter('terceros',"true");
                else
                    $qb->andWhere("grupo.terceros = :terceros")->setParameter('terceros',"false");
                $contexto4=true;
                $this->joinedProfePeriodo = true;
                $this->joinedProfePeriodoHorario = true;
            }
            unset($filters['terceros']);
        }
        if($contexto4) {
            $r4 = $this->filterQB($qb, $filters, ResultType::IDSType, $order);
        }

        return array($r4,$contexto4);
    }
    public function clearFilterContexto4(&$filters)
    {
        $rfilters = array();
        if (array_key_exists('filtro_periodo_grupo', $filters) && $filters['filtro_periodo_grupo'] != null) {
            $rfilters['filtro_periodo_grupo'] = $filters['filtro_periodo_grupo'];
            unset($filters['filtro_periodo_grupo']);
        }
        if (array_key_exists('bilingue', $filters) && $filters['bilingue'] != null) {
            $rfilters['bilingue'] = $filters['bilingue'];
            unset($filters['bilingue']);
        }
        if (array_key_exists('terceros', $filters) && $filters['terceros'] != null) {
            $rfilters['terceros'] = $filters['terceros'];
            unset($filters['terceros']);
        }
        if (array_key_exists('aula', $filters) && $filters['aula'] != null) {

            $rfilters['aula'] = $filters['aula'];
            unset($filters['aula']);
        }

        if (array_key_exists('grupo', $filters) && $filters['grupo'] != null && $filters['grupo'] != "") {
            $rfilters['grupo'] = $filters['grupo'];
            unset($filters['grupo']);
        }
        if (array_key_exists('hora_grupo', $filters) && $filters['hora_grupo'] != null && $filters['hora_grupo'] != "") {
            $rfilters['hora_grupo'] = $filters['hora_grupo'];
            unset($filters['hora_grupo']);
        }
        if (array_key_exists('dia_grupo', $filters) && $filters['dia_grupo'] != null && $filters['dia_grupo'] != "") {
            $rfilters['dia_grupo'] = $filters['dia_grupo'];
            unset($filters['dia_grupo']);
        }
        return $rfilters;
    }
    public function clearFilterContexto2(&$filters)
    {
        $rfilters=array();
        if(array_key_exists('libre_ocupado',$filters) && $filters['libre_ocupado'] != null){
            $rfilters['libre_ocupado']=$filters['libre_ocupado'];
            unset($filters['libre_ocupado']);
        }

        if(array_key_exists('filtro_descarga',$filters) && $filters['filtro_descarga'] != null ){

            $rfilters['filtro_descarga']=$filters['filtro_descarga'];
            unset($filters['filtro_descarga']);
        }
        if(array_key_exists('filtro_periodo',$filters) && $filters['filtro_periodo'] != null ){

            $rfilters['filtro_periodo']=$filters['filtro_periodo'];
            unset($filters['filtro_periodo']);
        }

        if(array_key_exists('hora_clase',$filters) &&  $filters['hora_clase'] != null &&  $filters['hora_clase'] != "" ){
            $rfilters['hora_clase']=$filters['hora_clase'];
            unset($filters['hora_clase']);
        }
        if(array_key_exists('dia_clase',$filters)  &&  $filters['dia_clase'] != null &&  $filters['dia_clase'] != ""){
            $rfilters['dia_clase']=$filters['dia_clase'];
            unset($filters['dia_clase']);
        }

        if(array_key_exists('filtro_turno',$filters) && $filters['filtro_turno'] != null ){

            $rfilters['filtro_turno']=$filters['filtro_turno'];
            unset($filters['filtro_turno']);
        }



        return $rfilters;
    }
    public function clearFilterContexto1(&$filters)
    {
        //ldd($filters);
        $rfilters=array();
        if(array_key_exists('filtro_periodo_materia',$filters) && $filters['filtro_periodo_materia'] != null && $filters['filtro_periodo_materia'] != ""){
            $rfilters['filtro_periodo_materia'] = $filters['filtro_periodo_materia'];
            unset($filters['filtro_periodo_materia']);
        }
        if(array_key_exists('materia_imparte',$filters) && $filters['materia_imparte']!=null && $filters['materia_imparte'] != ""){

            $rfilters['materia_imparte']=$filters['materia_imparte'];
//            if(count($filters['materia_imparte'][1]) > 0)
//                $rfilters['materia_imparte']=$filters['materia_imparte'][1];
            unset($filters['materia_imparte']);
        }
        if(array_key_exists('hora_clase_materia',$filters) &&  $filters['hora_clase_materia'] != null &&  $filters['hora_clase_materia'] != ""){

            $rfilters['hora_clase_materia'] = $filters['hora_clase_materia'];

//            if( count($filters['hora_clase_materia'][1]) > 0)
//                $rfilters['hora_clase_materia'] = $filters['hora_clase_materia'][1];

            unset($filters['hora_clase_materia']);
        }
        if(array_key_exists('dia_clase_materia',$filters)&& $filters['dia_clase_materia'] != null ){
            $rfilters['dia_clase_materia'] = $filters['dia_clase_materia'];
//            if(count($filters['dia_clase_materia']) > 0)
//                $rfilters['dia_clase_materia'] = $filters['dia_clase_materia'][1];
            unset($filters['dia_clase_materia']);
        }
        return $rfilters;
    }
    public function getFitlersContexto3(&$filters){
        $rfilters=array();
        if(array_key_exists('materia_pref',$filters) && $filters['materia_pref'] != null && $filters['materia_pref'] != ""){
            $rfilters['materia_pref'] = $filters['materia_pref'];
            unset($filters['materia_pref']);
        }
        if(array_key_exists('orden_materia',$filters) && $filters['orden_materia'] != null && $filters['orden_materia'] != ""){
            $rfilters['orden_materia'] = $filters['orden_materia'];
            unset($filters['orden_materia']);
        }
        if(array_key_exists('hora_pref',$filters) && $filters['hora_pref']!=null && $filters['hora_pref'] != ""){

            $rfilters['hora_pref']=$filters['hora_pref'];
//            if(count($filters['materia_imparte'][1]) > 0)
//                $rfilters['materia_imparte']=$filters['materia_imparte'][1];
            unset($filters['hora_pref']);
        }

        if(array_key_exists('dia_pref',$filters) && $filters['dia_pref']!=null && $filters['dia_pref'] != ""){

            $rfilters['dia_pref']=$filters['dia_pref'];
//            if(count($filters['materia_imparte'][1]) > 0)
//                $rfilters['materia_imparte']=$filters['materia_imparte'][1];
            unset($filters['dia_pref']);
        }
        if(array_key_exists('hora_orden',$filters) &&  $filters['hora_orden'] != null &&  $filters['hora_orden'] != "" ){

            if($filters['hora_orden'] != -1)
                $rfilters['hora_orden'] = $filters['hora_orden'];

//            if( count($filters['hora_clase_materia'][1]) > 0)
//                $rfilters['hora_clase_materia'] = $filters['hora_clase_materia'][1];

            unset($filters['hora_orden']);
        }
        return $rfilters;
    }
    public function contexto3(&$rfilters)
    {
        $contexto3=false;
       $qb = $this->getQB();
//        $rfilters = $this->getFitlersContexto3($filters);

        if(array_key_exists('materia_pref',$rfilters) ){
            $qb->join('profesor.preferenciaMateria','preferenciaMateria');
            $qb->andWhere('preferenciaMateria.materia = :materia')->setParameter('materia',$rfilters['materia_pref']);

            if(array_key_exists('orden_materia',$rfilters)){
                $qb->andWhere('preferenciaMateria.ordenPreferencia = :materia2')->setParameter('materia2',$rfilters['orden_materia']);
//                $qb->andWhere('preferenciaMateria.ordenPreferencia = :ordenMateria')->setParameter('ordenMateria ',$rfilters['orden_materia']);
            }
            $contexto3=true;
        }

        if(array_key_exists('hora_pref',$rfilters)){
            $qb->join('profesor.preferenciaHora','preferenciaHora');
            if(array_key_exists('dia_pref',$rfilters)){
                $qb->andWhere('preferenciaHora.dia = :dia')->setParameter('dia',$rfilters['dia_pref']);

            }
                $qb->andWhere('preferenciaHora.hora = :horaP')->setParameter('horaP',$rfilters['hora_pref']);

            if(array_key_exists('hora_orden',$rfilters) ){
                $qb->andWhere('preferenciaHora.ordenPreferencia = :orden')->setParameter('orden',$rfilters['hora_orden']);
            }
            $contexto3=true;
        }

      //  return $this->filterQB($qb, array(), ResultType::IDSType);
        $r3=$this->filterQB($qb,$this->filterGlobal , ResultType::IDSType);
        return array($r3,$contexto3);
    }



    public function byCategory($filters,$resultType=ResultType::ArrayType){
        $qb = $this->getQB();
       /*  //  $qb->andWhere('select count()')->setParameter('categoria', $filters['categoria']);
             $a = array();
              $response= $this->filterQB($qb,array(),$resultType);
      foreach ($response as $value) {
         // ldd($value);
            $preferenciaMaterias = $this->getRepo("PlaneacionAdminBundle:Profesor")->find($value["id"])->getPreferenciaMateria();
          if (count($preferenciaMaterias)>0)
          {
              $a[]=$value;
          }
              
          
      }
   
        return $a;*/
        return $this->filterQB($qb,$filters,$resultType);
    }
     public function byPreferenciaMateriasAndCategory($filters,$resultType=ResultType::ArrayType){
            $qb = $this->getQB();
          $qb->join('profesor.preferenciaMateria','preferencia');
           $qb->join('profesor.categoria','categoria');
          //  $qb->addGroupBy('profePeriodo');
           if (isset($filters['licenciatura']))
            $qb->andWhere('profesor.categoria = :categoria')->setParameter('categoria', $filters['categoria']);
      $response= $this->filterQB($qb,array(),$resultType);
      return $response;
      $a = array();
      foreach ($response as $value) {
          if (count($value->getPreferenciaMateria()))
          {
              $a[]=$value;
          }
              
          
      }
        return $a;
    }
}
