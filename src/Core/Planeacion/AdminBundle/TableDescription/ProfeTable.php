<?php

namespace Core\Planeacion\AdminBundle\TableDescription;


use Core\ComunBundle\tableDescription\architecture\GridColumn;
use Core\ComunBundle\tableDescription\architecture\ReportField;
use Core\ComunBundle\tableDescription\architecture\SelectFilterColumn;
use Core\ComunBundle\tableDescription\architecture\TableModel;
use Core\ComunBundle\Util\FechaUtil;
use Core\ComunBundle\Util\Util;
use Core\ComunBundle\Util\UtilRepository2Config;
use Core\Planeacion\AdminBundle\Entity\Profesor;
use Core\Planeacion\AdminBundle\Enums\ELicenciatura;
use Core\Planeacion\AdminBundle\TableDescription\Rutas\RutasProfesor;
use Doctrine\ORM\Mapping as ORM;

class ProfeTable extends TableModel
{
    function __construct() {
        parent::__construct();
        $this->entity = 'Core\Planeacion\AdminBundle\Entity\Profesor';
        $this->name="Profesores";
        $this->editTitle="profesor";
        $this->extraActions = "horarios_asignados,registro_materias,exportar_hoja";
        $this->modal=false;
        $this->expandable=true;
        $this->hasExport=true;
        $this->hasEmailExport=true;
        $this->hasXlsExport=true;
        $this->advancedSearchView = "planeacion_admin_crud_profesor_filtro_avanzado_view";
        $this->setIcon('fa fa-list-ul');
    }
    public function getReportFields()
    {
        $foto= new ReportField(false,'Foto');
        $nombre= new ReportField(true,'Nombre y apellidos');
        $numeroEmpleado = new ReportField(true,'Nro. de empleado');
        $correo = new ReportField(false,'Correo');
        $genero = new ReportField(false,'Género');
        $telparticular = new ReportField(false, 'Tel. Particular');
        $celular = new ReportField(false,'Celular');
        $facebook = new ReportField(false,'Facebook');
        $domicilio = new ReportField(false,'Domicilio');
        $dirLabora = new ReportField(false,'Lugar labora');
        $telLugarLabora = new ReportField(false,'Tel. Labora');
        $categoria = new ReportField(false,'Categoría');
        $inactivo = new ReportField(false,'Inactivo');

        $r=array();
        $r['fotopic']=$foto;
        $r['nombre']=$nombre;
        $r['numeroEmpleado']=$numeroEmpleado;
        $r['correo']=$correo;
        $r['generoString']=$genero;
        $r['telparticular']=$telparticular;
        $r['telCelular']=$celular;
        $r['facebook']=$facebook;
        $r['domicilio']=$domicilio;
        $r['dirLabora']=$dirLabora;
        $r['telLugarLabora']=$telLugarLabora;
        $r['categoria']=$categoria;
        $r['InactivoText'] = $inactivo;
        return $r;
    }

    public function actionsWidth()
    {
        return 20;
    }
    public function detailData(){

        $result = array();
//        return $result;
        foreach($this->datos as $row)
        {
            /**
             * @var $row Profesor
             */
            $detailData = array();

            $datosS = array();
            $datosS['Foto'] = $row->getFotoPic();
            if($row->getFechaIngresoFac() != null)
                $datosS['Fecha ingreso Facultad'] = $row->getFechaIngresoFac()->format(FechaUtil::getDateFormat());
            else
                $datosS['Fecha ingreso Facultad'] = "";
            if($row->getFechaIngresoUanl() != null)
                $datosS['Fecha ingreso Universidad'] = $row->getFechaIngresoUanl()->format(FechaUtil::getDateFormat());
            else
                $datosS['Fecha ingreso Universidad'] = "";

            $datosS['Género'] = $row->getGeneroString();
            $datosS['Nombre'] = $row->getFullName();

            $datosS['Carrera'] = $row->getCarrera();
            $MDs = $row->getGradoAcademico();
            foreach($MDs as $md)
            {
                $tmp = $md->getDetailArray();
//                ld($tmp['key']);
//                ld($tmp['value']);
                $datosS[$tmp['key']]=$tmp['value'];
            }
            $datosS['numeroEmpleado'] = $row->getNumeroEmpleado();
            $datosS['Teléfono particular'] = $row->getTelParticular();
            $datosS['Teléfono celular'] = $row->getTelCelular();
            $datosS['Correo'] = $row->getCorreo();
            $datosS['Facebook'] = $row->getFacebook();


            $datosS['Idiomas'] = $row->getIdiomasString();
            $datosS['Domicilio'] = $row->getDomicilio();
            $datosS['Lugar donde labora'] = $row->getLugarLabora();
            $datosS['Teléfono donde labora'] = $row->getTelLugarLabora();
            $datosS['Dirección donde labora'] = $row->getDirLabora();
            if($row->getFechaNacimiento() != null)
                $datosS['Fecha de nacimiento'] = $row->getFechaNacimiento()->format(FechaUtil::getDateFormat());
            $datosS['Estado civil'] = $row->getEstadoCivil() != false ? $row->getEstadoCivil()->getNombre():'';
            $datosS['Nombre cónyugue'] = $row->getNombreConyugue();
            $datosS['Habilidades y competencias'] = $row->getPerfil();
            $habilidades = $row->getPerfil();

            $datosC = array();
//            $repoHora = $this->getEm()->getRepository('PlaneacionAdminBundle:Hora')->filterObjects(array(),array('hora'=>'asc'));
            $tmp =  $this->getEm()->getRepository('PlaneacionAdminBundle:PreferenciaProfeHora')->getPreferenciasByProfe($row->getId());
            if (count($tmp['1'])>0)
            $datosC['horas1']=$tmp['1'];
            if (count($tmp['2'])>0)
            $datosC['horas2']=$tmp['2'];
            if (count($tmp['3'])>0)
            $datosC['horas3']=$tmp['3'];
            if (count($tmp['4'])>0)
            $datosC['horas4']=$tmp['4'];
            $repo = $this->getEm()->getRepository('PlaneacionAdminBundle:Materia');
            $materias = $repo->getByProfePreferencia($row->getId());

            $detailData[] = array('name'=>'#twig','value'=>$this->container->get('templating')->render('@PlaneacionAdmin/Profesor/profe_detail.twig',array(
                'datosS'=>$datosS,
                'datosC'=>$datosC,
                'materias'=>$materias
            )));
            $result[]=$detailData;
        }
        return $result;
    }
    public function defineColumns() {

        $name = new GridColumn("Nombre y apellidos", '25%','fullname');
        $numeroEmpleado = new GridColumn("Nro. empleado", '10%','numeroEmpleado');
//        $numeroEmpleado->setSortable(false);
//        $correo = new GridColumn("Correo", '15%','correo');
//        $facebook = new GridColumn("Facebook", '10%','facebook');
//        $telParticular = new GridColumn("Teléfono particular", '8%','telParticular');
//        $telParticular->setSortable(false);
//        $telCelular = new GridColumn("Teléfono celular", '8%','telCelular');
//        $telCelular->setSortable(false);
//        $telNextel = new GridColumn("Teléfono Nextel", '8%','telNextel');
//        $telNextel->setSortable(false);
        $categoría = new GridColumn("Categoría", '18%','categoria');
        $categoría->setFilterType('select');
        $filterData = new SelectFilterColumn();
        $filterData->setData($this->getEm()->getRepository("PlaneacionAdminBundle:Categoria")->findAll());
        $categoría->setFilterData($filterData);

        $licColumn = new GridColumn("Imparte", '10%','lic','select');
        $licColumn->setSortable(false);
        $filterData = new SelectFilterColumn();
        $filterData->setData($this->getEm()->getRepository("PlaneacionAdminBundle:Carrera")->findAll());
        $licColumn->setFilterData($filterData);

        $estado = new GridColumn('Inactivo','%1','inactivo');
        $e_filter = new SelectFilterColumn();
        $e_filter->setData(array(
                array('id'=>1,'nombre'=>'Sí'),
                array('id'=>0,'nombre'=>'No')
            )
        );
        $estado->setFilterType('select');
        $estado->setFilterData($e_filter);

//        $activoColumn = new GridColumn("Género", '8%','genero');
//
//        $filter = new SelectFilterColumn();
//        $filter->setData(array(
//                array('id'=>EGenero::Masculino,'nombre'=>"Masculino"),
//                array('id'=>EGenero::Femenino,'nombre'=>"Femenino")
//            )
//        );
//        $activoColumn->setFilterType('select');
//        $activoColumn->setFilterData($filter);

        $this->columns[] = $name;
        $this->columns[] = $numeroEmpleado;
        $this->columns[] = $licColumn;
//        $this->columns[] = $activoColumn;
//        $this->columns[] = $correo;
//        $this->columns[] = $facebook;
//        $this->columns[] = $telParticular;
//        $this->columns[] = $telCelular;
//        $this->columns[] = $telNextel;
        $this->columns[] = $categoría;
        $this->columns[] = $estado;

    }
    public function defineRutas()
    {
        $rutas =new RutasProfesor();
        $rutas->setNew('planeacion_admin_crud_profesor_new');
        $rutas->setDelete('planeacion_admin_crud_profesor_delete');
//        $rutas->setDetails('planeacion_admin_crud_materia_details');
        $rutas->setEdit('planeacion_admin_crud_profesor_edit');
        $rutas->setList('planeacion_admin_crud_profesor_listAjax');
        $rutas->setExportPDF('planeacion_admin_crud_profesor_export_pdf');
        $rutas->setExportXLS('planeacion_admin_crud_profesor_export_xls');

        $rutas->setExportEmail('planeacion_admin_crud_profesor_export_correo');
        return $rutas;
    }
    public function defineActions()
    {
        $actions = parent::defineActions();
        $actions[] = "HorariosAsignados";
        $actions[] = "RegistroMaterias";
        $actions[] = "ExportarHoja";
        return $actions;
    }
    public function getFilters(&$filters)
    {
//        $filters = UtilRepository2::getRequest()->request->all();
     //   ldd($filters);
        $contextoBase=Array();
        $contextoBase['Fecha']= FechaUtil::toString(FechaUtil::getFechaActual());
        if(array_key_exists('carrera',$filters) && $filters['carrera']!=null)
        {
            if($filters['carrera'] == ELicenciatura::Criminologia) {
                $contextoBase['Carrera']='Criminología';
            }
            if($filters['carrera'] == ELicenciatura::Derecho) {
                $contextoBase['Carrera']='Derecho';
            }
        }

//        if(array_key_exists('categoria',$filters) && $filters['categoria']!=null){
//            $contextoBase['Categoría']=$this->getRepo("PlaneacionAdminBundle:Categoria")->find($filters['categoria'])->getNombre();
//        }
        if(array_key_exists('categoria',$filters) && $filters['categoria']!=null){
            $contextoBase['Categoría']=$this->getRepo("PlaneacionAdminBundle:Categoria")->find($filters['categoria'])->getNombre();
        }
        if(array_key_exists('fullname',$filters) && $filters['fullname']!=null && $filters['fullname']!=""){
            $contextoBase['Nombre']='Contiene "'.$filters['fullname'].'"';
        }
        if(array_key_exists('numeroEmpleado',$filters) && $filters['numeroEmpleado']!=null && $filters['numeroEmpleado']!=""){
            $contextoBase['Número de empleado']='Contiene "'.$filters['numeroEmpleado'].'"';
        }
        $contextoPreferencia=array();
        if(array_key_exists('materia_pref',$filters) && $filters['materia_pref'] != null && $filters['materia_pref'] != ""){
            $contextoPreferencia['Materia preferida'] = $this->getEm()->getRepository('PlaneacionAdminBundle:Materia')->find($filters['materia_pref'])->getTextoSinLicenciatura();
        }
        if(array_key_exists('orden_materia',$filters) && $filters['orden_materia'] != null && $filters['orden_materia'] != "")
            if(array_key_exists('Materia preferida', $contextoPreferencia)){
                $contextoPreferencia['Orden de preferencia de la materia'] = $filters['orden_materia'];
        }
        if(array_key_exists('hora_pref',$filters) && $filters['hora_pref']!=null && $filters['hora_pref'] != ""){
            $contextoPreferencia['Hora de preferencia'] = $this->getEm()->getRepository('PlaneacionAdminBundle:Hora')->find($filters['hora_pref'])->getNombre(); ;
        }
        if(array_key_exists('hora_orden',$filters) &&  $filters['hora_orden'] != null &&  $filters['hora_orden'] != "" && $filters['hora_orden'] != -1){
            if(array_key_exists('Hora de preferencia', $contextoPreferencia))
                $contextoPreferencia['Orden de preferencia de la hora'] = $filters['hora_orden'];
        }

        $contextoDisponibilidad=array();
        if(array_key_exists('filtro_periodo',$filters) && $filters['filtro_periodo'] != null ){
            $contextoDisponibilidad['Período'] = $this->getEm()->getRepository('PlaneacionAdminBundle:Periodo')->find($filters['filtro_periodo'])->getAbreviado();
        }
        if(array_key_exists('dia_clase',$filters)  &&  $filters['dia_clase'] != null &&  $filters['dia_clase'] != ""){
            $contextoDisponibilidad['Día'] = $filters['dia_clase'];
        }
        if(array_key_exists('hora_clase',$filters) &&  $filters['hora_clase'] != null &&  $filters['hora_clase'] != "" ){
            $contextoDisponibilidad['Hora'] = $filters['hora_clase'];
        }

        if(array_key_exists('libre_ocupado',$filters) && $filters['libre_ocupado'] != null &&  $filters['libre_ocupado'] != ""){
            if( (array_key_exists('filtro_periodo',$filters) && $filters['filtro_periodo'] != null &&  $filters['filtro_periodo'] != "" )||
                (array_key_exists('dia_clase',$filters) && $filters['dia_clase'] != null &&  $filters['dia_clase'] != "") ||
                (array_key_exists('hora_clase',$filters) && $filters['hora_clase'] != null &&  $filters['hora_clase'] != "") )
                $contextoDisponibilidad['Se encuentran'] = $filters['libre_ocupado']==1?"Disponibles":"Ocupados";
        }
        $contextoGrupo=array();
        if(array_key_exists('filtro_periodo_grupo',$filters) && $filters['filtro_periodo_grupo'] != null ){
            $contextoGrupo['Período'] = $this->getEm()->getRepository('PlaneacionAdminBundle:Periodo')->find($filters['filtro_periodo_grupo'])->getAbreviado();
        }
        if(array_key_exists('dia_grupo',$filters)  &&  $filters['dia_grupo'] != null &&  $filters['dia_grupo'] != ""){
            $contextoGrupo['Día'] = $filters['dia_grupo'];
        }
        if(array_key_exists('hora_grupo',$filters) &&  $filters['hora_grupo'] != null &&  $filters['hora_grupo'] != "" ){
            $contextoGrupo['Hora'] = $filters['hora_grupo'];
        }
        if(array_key_exists('aula',$filters) &&  $filters['aula'] != null &&  $filters['aula'] != "" ){
            $contextoGrupo['Aula'] = $filters['aula'];
        }
        if(array_key_exists('grupo',$filters) &&  $filters['grupo'] != null &&  $filters['grupo'] != "" ){
            $contextoGrupo['Grupo'] = $filters['grupo'];
        }


        $contextoHistoricoMateria=array();
        if(array_key_exists('filtro_periodo_materia',$filters) && $filters['filtro_periodo_materia'] != null && $filters['filtro_periodo_materia'] != ""){
            $contextoHistoricoMateria['Período'] = $this->getEm()->getRepository('PlaneacionAdminBundle:Periodo')->find($filters['filtro_periodo_materia'])->getAbreviado();
        }
        if(array_key_exists('dia_clase_materia',$filters)&& $filters['dia_clase_materia'] != null ) {
            $contextoHistoricoMateria['Día'] = $this->getEm()->getRepository('PlaneacionAdminBundle:Dia')->find($filters['dia_clase_materia'])->getNombre();
        }
        if(array_key_exists('hora_clase_materia',$filters) &&  $filters['hora_clase_materia'] != null &&  $filters['hora_clase_materia'] != ""){
            $contextoHistoricoMateria['Hora'] = $filters['hora_clase_materia'];
        }
        if(array_key_exists('materia_imparte',$filters) && $filters['materia_imparte']!=null && $filters['materia_imparte'] != ""){
            $contextoHistoricoMateria['Materia'] = $this->getEm()->getRepository('PlaneacionAdminBundle:Materia')->find($filters['materia_imparte'])->getTextoSinLicenciatura();
        }
        $r=array();
        if(count($contextoBase))
            $r['base']=$contextoBase;
        if(count($contextoHistoricoMateria))
            $r['Han impartido']=$contextoHistoricoMateria;
        if(count($contextoDisponibilidad))
            $r['Disponibilidad']=$contextoDisponibilidad;
        if(count($contextoPreferencia))
            $r['Preferencias']=$contextoPreferencia;
        if(count($contextoGrupo))
            $r['Aula-Grupo']=$contextoPreferencia;
        return $r;
    }
    public function constructReportData($filters=Array(),$order=null)
    {
//        $order = $this->getTableSortByRequest();
//            $filters = UtilRepository2::getRequest()->request->all();
        if(count($order) > 0){
           unset($filters['iSortCol_0']);
            unset($filters['sSortDir_0']);
        }
        UtilRepository2Config::$paginate=false;
        $objs = $this->getRepo()->listTable($filters,$order);
      //  ldd($objs);
        return $objs;
    }
    public function constructData()
    {
        $order = $this->getTableSortByRequest();
     //   ldd($order);
        if(count($order) == 0)
            $order['id']='desc';
        $filters = $this->getTableFiltersByRquest();
//        UtilRepository2::getSession()->set('save',null);
        $this->datos= $this->getRepo()->listTable($filters,$order);
        $result = array();
//        $ids=array();
        foreach ($this->datos as $row) {
//            if($this->hasExport)
//                $ids[]=$row->getId();
            /**
             * @var $row Profesor
             */
            $tmpArray=array();
            $tmpArray[] = $row->getNombre();
            $tmpArray[] = $row->getNumeroEmpleado();
            $tmpArray[] = $row->getCarreraImparteString();
//            $tmpArray[] = $row->getGeneroString();
//            $tmpArray[] = $row->getCorreo();
//            $tmpArray[] = $row->getFacebook();
//            $tmpArray[] = $row->getTelParticular();
//            $tmpArray[] = $row->getTelCelular();
//            $tmpArray[] = $row->getTelNextel();
            $tmpArray[] = $row->getCategoria()->getNombre();
            $tmpArray[] = Util::boolean($row->getInactivo());

            $result[]=$tmpArray;
        }

        return $result;

    }
    public function getBotonHorariosAsignados($text = "Registro de horarios")
    {
        return $this->makeButton($text,"fa-calendar-o","horarios_asignados","planeacion_admin_crud_profesor_horario");
//        return '<a class="btn btn-large gestionar_permisos tooltips"  style="padding-bottom: 0px; padding-top: 0px"  action="gestionar_permisos" data-original-title="Gestioanr permisos" data-placement="top"> <i class="fa fa-lock" style="text-decoration: underline" action="gestionar_permisos"></i> </a>';
    }
    public function getBotonExportarHoja($text = "Exportar hoja de datos")
    {
        return $this->makeButtonNoEvent($text,"fa-file","exportar_hoja");
//        return '<a class="btn btn-large gestionar_permisos tooltips"  style="padding-bottom: 0px; padding-top: 0px"  action="gestionar_permisos" data-original-title="Gestioanr permisos" data-placement="top"> <i class="fa fa-lock" style="text-decoration: underline" action="gestionar_permisos"></i> </a>';
    }
    public function getBotonRegistroMaterias($text = "Registro de materias")
    {
        return $this->makeButton($text,"fa-table","registro_materias");
//        return '<a class="btn btn-large gestionar_permisos tooltips"  style="padding-bottom: 0px; padding-top: 0px"  action="gestionar_permisos" data-original-title="Gestioanr permisos" data-placement="top"> <i class="fa fa-lock" style="text-decoration: underline" action="gestionar_permisos"></i> </a>';
    }
    public function mapSorts()
    {
        return array('nombre','profesor.numeroEmpleado', 'profesor.categoria', 'profesor.categoria');
    }
}
