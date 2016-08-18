<?php

namespace Core\Planeacion\AdminBundle\TableDescription;


use Core\ComunBundle\tableDescription\architecture\GridColumn;
use Core\ComunBundle\tableDescription\architecture\ReportField;
use Core\ComunBundle\tableDescription\architecture\RutasGrid;
use Core\ComunBundle\tableDescription\architecture\SelectFilterColumn;
use Core\ComunBundle\tableDescription\architecture\TableModel;
use Doctrine\ORM\Mapping as ORM;

class EstudianteTable extends TableModel
{
    function __construct() {
        parent::__construct();
        $this->entity = 'Core\Planeacion\AdminBundle\Entity\Estudiante';
        $this->name="Estudiantes";
        $this->editTitle="estudiante";
        $this->expandable=true;
        $this->hasExport=true;
        $this->hasEmailExport=true;
        $this->hasXlsExport=true;
        $this->advancedSearchView = "planeacion_admin_crud_estudiante_filtro_avanzado_view";
        $this->setIcon('fa fa-list-ul');
    }
    public function getReportFields()
    {
        $nombre= new ReportField(true,'Nombre y apellidos');
        $correo = new ReportField(false,'Correo');
        $genero = new ReportField(false,'Género');
        $celular = new ReportField(false,'Celular');
        $facebook = new ReportField(false,'Facebook');

        $r=array();
        $r['nombre']=$nombre;
        $r['correo']=$correo;
        $r['generoString']=$genero;
        $r['telCelular']=$celular;
        $r['facebook']=$facebook;
        return $r;
    }

    public function actionsWidth()
    {
        return 20;
    }
    public function detailData(){

        $result = array();
//        return $result;

        return $result;
    }
    public function defineColumns() {

        $name = new GridColumn("Nombre y apellidos", '25%','fullname');
        $genero = new GridColumn("Género", '8%','genero');
        $correo = new GridColumn("Correo", '8%','correo');
        $facebook = new GridColumn("Facebook", '8%','facebook');
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
        $this->columns[] = $genero;
        $this->columns[] = $correo;
        $this->columns[] = $facebook;

    }
    public function defineRutas()
    {
        $rutas =new RutasGrid();
        $rutas->setNew('planeacion_admin_crud_estudiante_new');
        $rutas->setDelete('planeacion_admin_crud_estudiante_delete');
//        $rutas->setDetails('planeacion_admin_crud_materia_details');
        $rutas->setEdit('planeacion_admin_crud_estudiante_edit');
        $rutas->setList('planeacion_admin_crud_estudiante_listAjax');
        $rutas->setActivar('planeacion_admin_crud_estudiante_activar');
        $rutas->setDesactivar('planeacion_admin_crud_estudiante_desactivar');
        return $rutas;
    }
    public function defineActions()
    {
        $actions = parent::defineActions();
        return $actions;
    }
    public function getFilters(&$filters)
    {
//        $filters = UtilRepository2::getRequest()->request->all();
     //   ldd($filters);
        $contextoBase=Array();
        $contextoBase['Fecha']= FechaUtil::toString(FechaUtil::getFechaActual());
        if(array_key_exists('lic',$filters) && $filters['lic']!=null)
        {
            if($filters['lic'] == ELicenciatura::Criminologia) {
                $contextoBase['Licenciatura']='Criminología';
            }
            if($filters['lic'] == ELicenciatura::Derecho) {
                $contextoBase['Licenciatura']='Derecho';
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
        $this->datos= $this->getRepo()->filterObjects($this->getTableFiltersByRquest(),$order);
        $result = array();
//        $ids=array();
        foreach ($this->datos as $row) {

            $tmpArray=array();
            $tmpArray[] = $row->getNombres()."    ".$row->getApellidos();
            if ($row->getGenero()=="2")
            $tmpArray[] = "Masculino";
            else
                $tmpArray[] = "Femenino";

            $tmpArray[] = $row->getCorreo();
            $tmpArray[] = $row->getFacebook();
            $result[]=$tmpArray;
        }

        return $result;

    }

    public function mapSorts()
    {
        return array('nombres');
    }
}
