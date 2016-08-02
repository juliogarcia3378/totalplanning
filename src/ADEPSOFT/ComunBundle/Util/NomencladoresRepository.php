<?php

/**
 * @author Franklin Rivero Garcia
 */

namespace ADEPSOFT\ComunBundle\Util;

use Doctrine\ORM\QueryBuilder;

/**
 * @author Franlin Rivero Garcia <frrivero@uci.cu>
 */
class NomencladoresRepository extends \Doctrine\ORM\EntityRepository{
    protected function getEnumIds($class_name)
    {
        $obj = new \ReflectionClass($class_name);
        $vars = $obj->getConstants();
        $ids = array();
        foreach($vars as $key => $value)
            $ids[] = $value;
        return $ids;
    }

    public function obtenerTodos($filters=array(), $resultType=  ResultType::ObjectType)
    {
        $qb = $this->getQB($filters);
        return $this->filterQB($qb, $filters, $resultType);
    }

    protected function getConstNameByValue($class_name,$id)
    {
        $obj = new \ReflectionClass($class_name);
        $vars = $obj->getConstants();
        foreach($vars as $key => $value)
            if($value == $id)
                return $key;
        return false;
    }
    public function generateEnumFromCollection($objs,$enumName, $nameMethod='getDenominacion', $overwrite = false)
    {
        $class = "ADEPSOFT\\ComunBundle\\Enums\\".$enumName;
        $enumsIds = array();
        if($overwrite === false && class_exists($class))
            $enumsIds = $this->getEnumIds ($class);
        
        $file ="$enumName.php";
        $kernel = UtilRepository2::getContainer()->get('kernel');
         $dir =  $kernel->locateResource("@ComunBundle/Enums/".$file);
        $enum = "<?php \n namespace ADEPSOFT\ComunBundle\Enums;\n class $enumName {\n";
         foreach($objs as $obj)
         {
             if($overwrite === false)
             {
                 if(in_array($obj->getId(), $enumsIds))
                      $row = $this->createRowFromExisting (
                                                            $this->getConstNameByValue($class, $obj->getId()),
                                                            $obj->getId()); 
                 else
                     $row = $this->createRow($obj, null,$nameMethod );
                      $enum.=$row;
             }
             else
             {
                $row = $this->createRow($obj, null,$nameMethod );
                $enum.=$row;
             }
         }
        $enum .= "} \n ?>";
//         ldd($dir);
         $r = file_put_contents($dir, $enum);
         return $r;
    }
     public function generateEnumToEntity($nameMethod = null,$overwrite = false)
     {
         $entity =  $this->getEntityName();
         
         $array = explode('\\',$entity);
         $file ='E'.$array[count($array)-1].'.php';
//         $dir = __DIR__."/Enums/$file";
         $kernel = UtilRepository2::getContainer()->get('kernel');
         $dir =  $kernel->locateResource("@ComunBundle/Enums/".$file);
//         ldd($dir);
         $objs = $this->findAll();
         $enum = "<?php \n namespace ADEPSOFT\ComunBundle\Enums;\n class ".'E'.$array[count($array)-1]."{\n";
         
         $class = "ADEPSOFT\\ComunBundle\\Enums\\".$array[count($array)-1];
          $enumsIds = array();
        if($overwrite === false && class_exists($class))
            $enumsIds = $this->getEnumIds ($class);
        
         foreach($objs as $obj)
         {
             if($overwrite === false)
             {
                 if(in_array($obj->getId(), $enumsIds))
                      $row = $this->createRowFromExisting (
                                                            $this->getConstNameByValue($class, $obj->getId()),
                                                            $obj->getId()); 
                 else
                     $row = $this->createRow($obj, null,$nameMethod );
                      $enum.=$row;
             }
             else
             {
                $row = $this->createRow($obj,$array[count($array)-1], $nameMethod );
                $enum.=$row;
             }
         }
         $enum .= "} \n ?>";
         $r = file_put_contents($dir, $enum);
         return $r;
     }
     protected function createRowFromExisting($name,$value)
     {
         $row = "\t const ";
         $row .= "\t".$name;    
         $row .=" = ".$value.";\n";
         return $row;
     }
     protected function createRow($obj,$entityName=null,$nameMethod = null)
     {
         $name = "get".substr($entityName, 4);
        if($nameMethod == null)
            $name = $obj->getDenominacion();
        else
            $name = $obj->$nameMethod();
        $name = str_replace('ñ', 'nn', $name);
        $name = str_replace('á', 'a', $name);
        $name = str_replace('í', 'i', $name);
        $name = str_replace('é', 'e', $name);
        $name = str_replace('ó', 'o', $name);
        $name = str_replace('ú', 'u', $name);
        $name = str_replace('-', '_', $name);
        $name = str_replace('.', '_', $name);
        $name = str_replace('\n', '', $name);
        $name = str_replace('\r', '', $name);
        $name = str_replace('(', '', $name);
        $name = str_replace(')', '', $name);
        $name = str_replace('+', '', $name);
        $name = str_replace('*', '', $name);
        $name = str_replace('__', '_', $name);
        $name = str_replace('__', '_', $name);
        $name = str_replace('/', '', $name);
        $name = str_replace(',', '', $name);
        
        $parts = explode(' ',$name);
        
         $row = "\t const ";
         $first = true;
         foreach($parts as $part)
         {
             if(!in_array(strtolower($part), array('al','de','la','y','las','el','los','en','del','desde','hasta','por','para','los')))
             {
                if(!$first)
                    $row .= "_".ucfirst ($part);
                else
                    $row .= "\t".ucfirst ($part);    
                $first = false;
             }
         }
         $row .=" = ".$obj->getId().";\n";
         return $row;
     }
    public function getRepo($entity)
    {
        return $this->getEntityManager()->getRepository($entity);
    }

    public function getTreeRoots($filters=array(),$resultType=ResultType::ObjectType,$order=null)
    {
        $qb = $this->getQB();
        $filters['padre'] = -1;
        $filters['id'] = array('!=',-1);
        return $this->filterQB($qb,$filters,$resultType,$order);
    }
    /**
     * El id puede ser null para en caso de que sea una nueva entidad
     * @param Array $fields
     * @param type $idObject
     */
    public function validarCamposUnicos($fields, $idObject = null)
    {
        $qb = $this->getQB();
        if($idObject != null)
            $fields['id'] = array('!=',$idObject);
        
        $tmp = UtilRepository2Config::$defaultStringComparer;
        UtilRepository2Config::$defaultStringComparer = '=';
        
        $r = $this->filterQB($qb, $fields, ResultType::ArrayType);
        
        UtilRepository2Config::$defaultStringComparer = $tmp;
        
        return count($r) == 0;
    }
    /**
     * @author Franlin Rivero Grcia <frrivero@uci.cu>
     * @param array $filters Arreglo asociativo campo => valor
     * @param ResultType $resultType
     * @param type $order Campo por  el que se va a ordenar (El orden por denominacion y activo es por defecto)
     * @param type $page
     * @return type
     */
    public  function filterWithAsociations($filters = array(),$order = null,$resultType = ResultType::ObjectType,$page = null)
    {
        $em = $this->getEntityManager();
        $class = $this->getEntityName();
        $r = UtilRepository2::filterRecordsTableWithAsociations($em, $class,$filters,$order,$resultType,$page);
        return $r;
    }
        /**
     * @author Franlin Rivero Grcia <frrivero@uci.cu>
     * @param array $filters Arreglo asociativo campo => valor
     * @param ResultType $resultType
     * @param type $order Campo por  el que se va a ordenar (El orden por denominacion y activo es por defecto)
     * @param type $page
     * @return type
     */
    public  function filter($filters = array(),$order = null,$resultType = ResultType::QueryBuilderType,$page = null)
    {
        $em = $this->getEntityManager();
        $class = $this->getEntityName();
        $r = UtilRepository2::filterRecordsTable($em, $class,$filters,$order,$resultType,$page);
        return $r;
    }
        /**
     * @author Franlin Rivero Grcia <frrivero@uci.cu>
     * @param array $filters Arreglo asociativo campo => valor
     * @param ResultType $resultType
     * @param type $order Campo por  el que se va a ordenar (El orden por denominacion y activo es por defecto)
     * @param type $page
     * @return type
     */
    public  function filterObjects($filters = array(),$order = null)
    {
        $em = $this->getEntityManager();
        $class = $this->getEntityName();
        $r = UtilRepository2::filterRecordsTable($em, $class,$filters,$order,  ResultType::ObjectType);
        return $r;
    }
    /**
     * @author Franlin Rivero Grcia <frrivero@uci.cu>
     * @param array $filters Arreglo asociativo campo => valor
     * @param ResultType $resultType
     * @param type $order Campo por  el que se va a ordenar (El orden por denominacion y activo es por defecto)
     * @param type $page
     * @return type
     */
    public  function filterObjectsActivo($filters = array(),$order = null)
    {
//        $filters['activo']=true;
        $em = $this->getEntityManager();
        $class = $this->getEntityName();
        $r = UtilRepository2::filterRecordsTable($em, $class,$filters,$order,  ResultType::ObjectType);
        return $r;
    }
        /**
     * @author Franlin Rivero Grcia <frrivero@uci.cu>
     * @param array $filters Arreglo asociativo campo => valor
     * @param ResultType $resultType
     * @param type $order Campo por  el que se va a ordenar (El orden por denominacion y activo es por defecto)
     * @param type $page
     * @return type
     */
    public  function filterArray($filters = array(),$order = null)
    {
        $em = $this->getEntityManager();
        $class = $this->getEntityName();
        $r = UtilRepository2::filterRecordsTable($em, $class,$filters,$order,  ResultType::ArrayType);
        return $r;
    }
        /**
     * @author Franlin Rivero Grcia <frrivero@uci.cu>
     * @param \Doctrine\ORM\QueryBuilder 
     * @param array $filters Arreglo asociativo campo => valor
     * @param ResultType $resultType
     * @param  $order Campo por  el que se va a ordenar (El orden por denominacion y activo es por defecto)
     * @param type $page
     * @return type
     */
    public  function filterQB(\Doctrine\ORM\QueryBuilder $qb, $filters = array(),$resultType = ResultType::ObjectType,$order = null,$all=null)
    {
        $em = $this->getEntityManager();
//        $class = $this->getClassName();
        $r = UtilRepository2::filterRecordsQB($em, $qb,$filters,$order,$resultType,$all);
        return $r;
    }
        /**
     * @author Franlin Rivero Grcia <frrivero@uci.cu>
     * @param \Doctrine\ORM\QueryBuilder 
     * @param array $filters Arreglo asociativo campo => valor
     * @param ResultType $resultType
     * @param type $order Campo por  el que se va a ordenar (El orden por denominacion y activo es por defecto)
     * @param type $page
     * @return type
     */
    public  function filterQBLikeOP(\Doctrine\ORM\QueryBuilder $qb, $filters = array(),$resultType = ResultType::ObjectType,$order = null,$page = null)
    {
        $op = UtilRepository2Config::$defaultForeignCompareOperator;
        UtilRepository2Config::$defaultForeignCompareOperator = 'like';
        $em = $this->getEntityManager();
//        $class = $this->getClassName();
        $r = UtilRepository2::filterRecordsQB($em, $qb,$filters,$order,$resultType,$page);
        UtilRepository2Config::$defaultForeignCompareOperator = $op;
        return $r;
    }
    /**
     * @author Franlin Rivero Grcia <frrivero@uci.cu> 
     * @param string $id
     * @param ResultType $resulType
     * @return array
     */    
    public  function  getDetalles($id,$resultType = ResultType::SingleObjectType)
    {        
        $em = $this->getEntityManager();
        $class = $this->getEntityName();
        return UtilRepository2::getDetalles($em, $class, $id,$resultType);
    }
    public function buscarTodos(){
        return $this->findAll();
    }
    /**
     * @author Franlin Rivero Grcia <frrivero@uci.cu>
     * @param string $id
     * @return type
     */    
    public function getInstance($id){
        return $this->find($id);
    }
    public function buscarPorId($id) {
            return $this->find($id);
    }    
    public function buscar($id) {
            return $this->find($id);
    }
    /**
     * @author Franlin Rivero Grcia <frrivero@uci.cu>
     * @param array $exclude
     * @return QueryBuilder
     */
    public  function getQBTableWithAsociations($exclude=array())
    {
        $em = $this->getEntityManager();
        $class = $this->getEntityName();
        return UtilRepository2::getQBTableWithAsociations($em, $class,$exclude);
    }
    /**
     * @author Franlin Rivero Garcia <frrivero@uci.cu>
     * @param array $include
     * @param type $order
     * @return QueryBuilder
     */
    public  function getQB($include = array(),$select=false)
    {
        $em = $this->getEntityManager();
        $class = $this->getEntityName();
        return UtilRepository2::getQBTable($em, $class,$include,$select);
    }
    /**
     * @author Franlin Rivero Garcia <frrivero@uci.cu>
     * @param array $include
     * @param type $order
     * @return QueryBuilder
     */
    public  function getQB2($include,$select=false)
    {
        $em = $this->getEntityManager();
        $class = $this->getEntityName();
        return UtilRepository2::getQB2($em, $class,$include,$select);
    }
    /**
     * @author Franlin Rivero Garcia <frrivero@uci.cu>
     * @param array $include
     * @param type $order
     * @return QueryBuilder
     */
    public  function getQBSelect($include = array())
    {
        $em = $this->getEntityManager();
        $class = $this->getEntityName();
        return UtilRepository2::getQBTable($em, $class,$include,true);
    } 
    /**
     * @author Franlin Rivero Garcia <frrivero@uci.cu>
     * @param array $include
     * @param type $order
     * @return QueryBuilder
     */
    public  function getQBCustomJoin($join='innerJoin',$include = array())
    {
        $joinType = UtilRepository2Config::$defaultJoinType;
        UtilRepository2Config::$defaultJoinType =$join;
        $em = $this->getEntityManager();
        $class = $this->getEntityName();
        $r = UtilRepository2::getQBTable($em, $class,$include);
        UtilRepository2Config::$defaultJoinType = $joinType;
        return $r;
    } 
    /**
     * @author Franlin Rivero Grcia <frrivero@uci.cu> 
     */
    public function getFields()
    {
        $em = $this->getEntityManager();
        $class = $this->getEntityName();
        $meta  = $em->getClassMetadata($class);
        return $meta->getFieldNames();
    }    
    /**
     * @author Franlin Rivero Grcia <frrivero@uci.cu> 
     */
    public function getAsociations()
    {
        $em = $this->getEntityManager();
        $class = $this->getEntityName();
        $meta  = $em->getClassMetadata($class);
        return $meta->getAssociationNames();
    }

    /**
     * @param array $ids
     * @return QueryBuilder
     */
    public function convertirAQueriBuilderXIds($ids = array())
    {
        if(count($ids) > 0)
            return $this->createQueryBuilder('t')->where('t.id in (:ids)')->setParameter('ids',$ids);
        else
            throw new \Exception('convertirAQueriBuilderXIds no puede recibir arreglo vac&iacute;o.');
    }
    public function obtenerXArrayId($ids,$resultType = ResultType::ObjectType,$order=null,$alias=null)
    {
        if(is_null($alias))
            $alias='t';
        $qb = $this->createQueryBuilder($alias)->andWhere("$alias.id in (:ids)")->setParameter('ids',$ids);
        return $this->filterQB($qb,array(),$resultType,$order);
//        return $qb->getQuery()->execute();
    }
    public function eliminarPorArregloDeIds($ids)
    {
        $meta  = $this->getClassMetadata();
        $id = $meta->getIdentifier();
        $id=$id[0];
        $class = $this->getEntityName();
//        $idName = UtilRepository2::createAlias($this->getEntityName()).".$id";//        $idName = UtilRepository2::createAlias($this->getEntityName()).".$id";
        $this->getEntityManager()->createQuery("delete from $class t where  t.$id in (:ids)")->setParameter("ids",$ids)->execute();
        return true;

    }

}

?>
