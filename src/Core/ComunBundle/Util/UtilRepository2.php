<?php

namespace Core\ComunBundle\Util;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;

/**
 * Filtrado de tablas y QueryBuilder
 *
 * @author Franklin Rivero <frrivero@uci.cu>
 */
class UtilRepository2 {
    public static function createFiltersFromRequest(\Symfony\Component\HttpFoundation\Request $request)
    {
        $keys = $request->request->keys();
        $r = array();
        foreach($keys as $key)
            $r[$key]=$request->get($key);

        return $r;
    }
    public static function getRoute($route)
    {
        return UtilRepository2::getContainer()->get('router')->generate($route);
    }
    /**
     *
     * @return \Symfony\Component\HttpFoundation\Session\Session
     */
    public static function getSession()
    {
        return UtilRepository2::getContainer()->get('request')->getSession();
    }
    /**
     *
     * @return Request
     */
    public static function getRequest()
    {
        return UtilRepository2::getContainer()->get('request');
    }
    /**
     *
     * @return \Symfony\Component\HttpFoundation\Session\Session
     */
    public static function getParameter($key,$default=null)
    {
        return UtilRepository2::getContainer()->get('request')->get($key,$default);
    }
    /**
     *
     * @return \Symfony\Component\HttpFoundation\Session\Session
     */
    public static function getTotalElements()
    {
        return UtilRepository2::getContainer()->get('request')->getSession()->get('total');
    }
    public static function getEnumIds($class_name)
    {
        $obj = new \ReflectionClass($class_name);
        $vars = $obj->getConstants();
        $ids = array();
        foreach($vars as $key => $value)
            $ids[] = $value;
        return $ids;
    }
    public static function getPoderJudicialLoged($obj = false)
    {
        $repo = UtilRepository2::getRepo('BaseBundle:Configuracion');
        $conf = UtilRepository2::getRepo('BaseBundle:Configuracion')->findAll();
        if(count($conf) == 0 && $obj == false)
            return 14;
        if(count($conf) == 0 && $obj == true)
            return $repo->find(14);
        $row =  $conf[0];
        if($obj)
            return $row->getPoderJudicial();
        return $row->getPoderJudicial()->getId();
//        return \Core\ComunBundle\Util\UtilRepository2::getContainer()->get('request')->getSession()->get('poderJudicial');
    }
    public static function getUsuarioLogged($object = false)
    {

        if($object == false)
            return 2;
        else
            return UtilRepository2::getRepo('MySecurityBundle:Usuario')->find(2);
        if($object)
            return \Core\ComunBundle\Util\UtilRepository2::getContainer()->get('security.context')->getToken()->getUser();
        return \Core\ComunBundle\Util\UtilRepository2::getContainer()->get('security.context')->getToken()->getUser()->getId();
    }
//    public static function getPersonaLogged($object = false)
//    {
//        $idUser = \Core\ComunBundle\Util\UtilRepository2::getContainer()->get('security.context')->getToken()->getUser()->getId();
//        if($object)
//            return \Core\ComunBundle\Util\UtilRepository2::getEntityManager()->find('SeguridadBundle:Usuario',$idUser)->getPersonanatural();
//        return \Core\ComunBundle\Util\UtilRepository2::getEntityManager()->find('SeguridadBundle:Usuario',$idUser)->getPersonanatural()->getId();
//    }

    /**
     * @return EntityManager
     */
    public static function getEntityManager()
    {
        return \Core\ComunBundle\Util\UtilRepository2::getContainer()->get('doctrine.orm.entity_manager');
    }
    /**
     * @return NomencladoresRepository
     */
    public static function getRepo($entity)
    {
        return \Core\ComunBundle\Util\UtilRepository2::getContainer()->get('doctrine.orm.entity_manager')->getRepository($entity);
    }
    /**
     * @return Container
     */
    public static function getContainer()
    {
        $container = $GLOBALS['kernel']->getContainer();
        return $container;
    }
    public function generateRandomString()
    {
        return uniqid(mt_rand().time(), true);
    }
    /**
     * @author Franlin Rivero Grcia <frrivero@uci.cu>
     * @param EntityManager $em
     * @param string $class
     * @param string $id
     * @param ResultType $resulType
     * @return array
     */
    public static function getDetalles(EntityManager $em ,$class,$id,$resulType = ResultType::SingleObjectType)
    {
        $qb = UtilRepository2::getQBTable($em, $class, array());
        $meta = $em->getClassMetadata($class);

        $identifier = $meta->getIdentifier();
        //var_dump($qb->getDQL());die;
        $alias = UtilRepository2::createAlias($class);
        foreach($identifier as $idName)
        {
            $qb->andWhere("$alias.$idName = :$idName");
            $qb->setParameter($idName, $id);
        }
//        print($qb->getQuery()->getSQL());die;
        return UtilRepository2::doResult($qb,$resulType,$alias);
    }
    /**
     * @author Franlin Rivero Grcia <frrivero@uci.cu>
     * @param EntityManager $em
     * @param string $class
     * @param array $exclude
     * @return QueryBuilder
     */
    public  static function getQBTableWithAsociations(EntityManager $em ,$class,$exclude=array())
    {
        if(!is_array($exclude));
        $exclude = array($exclude);
        $meta  = $em->getClassMetadata($class);
        $qb = $em->createQueryBuilder();
        $alias = UtilRepository2::createAlias($class);
        $qb->select($alias)->from($class, $alias);
        $asocnames = $meta->getAssociationNames();
        foreach($asocnames as $asocname)
        {
            if(!in_array($asocname, $exclude))
            {
                $qb->addSelect($asocname);
                $join = UtilRepository2Config::$defaultJoinType;
                $qb->$join("$alias.$asocname", $asocname);
            }
        }
//       print($qb->getDQL());die;
        return $qb;
    }
    /**
     * @author Franlin Rivero Grcia <frrivero@uci.cu>
     * @param EntityManager $em
     * @param string $class
     * @param array $include
     * @return QueryBuilder
     */
    public  static function getQB2(EntityManager $em ,$class,$include,$select=false)
    {
        $qb = $em->createQueryBuilder();
        $alias = UtilRepository2::createAlias($class);
        $qb->select($alias)->from($class, $alias);

        $joinType = UtilRepository2Config::$defaultJoinType;
        $array = explode(".",$include);
        $beforeJoin = $alias;
        foreach($array as $join)
        {
            $qb->$joinType("$beforeJoin.$join", $join);
            if($select)
                $qb->addSelect ($join);
            $beforeJoin = $join;
        }
        return $qb;
    }
    /**
     * @author Franlin Rivero Grcia <frrivero@uci.cu>
     * @param EntityManager $em
     * @param string $class
     * @param array $include
     * @return QueryBuilder
     */
    public  static function getQBTable(EntityManager $em ,$class,$include = array(),$select=false)
    {
        $qb = $em->createQueryBuilder();
        $alias = UtilRepository2::createAlias($class);
        $qb->select($alias)->from($class, $alias);

        $joinType = UtilRepository2Config::$defaultJoinType;

        if(is_array($include) && count($include) > 0)
        {
            foreach($include as $join)
            {
                $pointPos = strpos($join, '.');
                if($pointPos === false)
                {
                    $alias = UtilRepository2::createAlias($class);
                    $qb->$joinType("$alias.$join", $join);
                    if($select)
                        $qb->addSelect ($join);
                }
                else
                {
                    $alias = substr($join, $pointPos+1);
                    $qb->$joinType($join, $alias);
                    if($select)
                        $qb->addSelect ($alias);
                }
            }
        }
        else
        {
            if(!is_array($include) && !is_null($include) )
            {
                $qb->$joinType("$alias.$include", $include);
            }
        }
        return $qb;
    }
    /**
     * @author Franlin Rivero Grcia <frrivero@uci.cu>
     * @param EntityManager $em
     * @param string $class
     * @param array $filters Arreglo asociativo campo => valor
     * @param ResultType $resultType
     * @param type $order
     * @param type $page
     * @return array
     */
    public  static function filterRecordsTable(EntityManager $em ,$class ,$filters = array(), $order = null,$resultType = ResultType::ArrayType, $page=null)
    {
        $qb = $em->createQueryBuilder();

        $alias = UtilRepository2::createAlias($class);
        $qb->select($alias)->from($class, $alias);

        $meta  = $em->getClassMetadata($class);
        $fields = $meta->getFieldNames();
        $asoc = $meta->getAssociationNames();

        UtilRepository2::fieldFilter($alias, $filters, $fields, $asoc, $meta, $qb);
        UtilRepository2::putOrder($alias, $fields, $order, $qb);
//       echo $qb->getQuery()->getSQL();die;
        return UtilRepository2::doResult($qb, $resultType,$alias);
    }
    /**
     * @author Franlin Rivero Grcia <frrivero@uci.cu>
     * @param EntityManager $em
     * @param QueryBuilder $qb
     * @param array $filters Arreglo asociativo campo => valor
     * @param ResultType $resultType
     * @param type $order
     * @param type $page
     * @return array
     */
    public  static function filterRecordsQB(EntityManager $em, QueryBuilder $qb,  $filters = array(), $order = null,$resultType = ResultType::ObjectType,$all=null)
    {
        $rootEntityA = $qb->getRootEntities();
        $rootEntity = $rootEntityA[0];

        $meta  = $em->getClassMetadata($rootEntity);
//        $meta  = $em->getClassMetadata($class);
        $alias = UtilRepository2::createAlias($rootEntity);
        $fields = $meta->getFieldNames();
        $asoc = $meta->getAssociationNames();
//        if(count($qb->getDQLPart('groupBy')) > 0)
//            foreach($fields as $field )
//                $qb->addGroupBy($alias.".$field");
        UtilRepository2::fieldFilter($alias, $filters, $fields, $asoc, $meta, $qb,$all);
        UtilRepository2::putOrder($alias, $fields, $order, $qb);
//        print $qb->getQuery()->getSQL()."<br/>";
//        die;
        return UtilRepository2::doResult($qb, $resultType,$alias);
    }
    /**
     * @author Franlin Rivero Grcia <frrivero@uci.cu>
     * @param EntityManager $em
     * @param string $class
     * @param array $filters Arreglo asociativo campo => valor
     * @param array $foreignFilters Arreglo asociativo asociationName.campo => valor
     * @param ResultType $resultType
     * @param type $order
     * @param type $page
     * @return array
     */
    public  static function filterRecordsTableWithAsociations(EntityManager $em ,$class ,$filters = array(),$order = null,$resultType = ResultType::ObjectType, $page=null)
    {
        $meta = $em->getClassMetadata($class);
        //$fields = $meta->getFieldNames();
        $asocnames = $meta->getAssociationNames();
        $alias = UtilRepository2::createAlias($class);
        $qb = $em->createQueryBuilder()->select($alias)->from($class, $alias);
        $i = 0;
        foreach($asocnames as $asocname)
        {
            $qb->addSelect($asocname);
            $join = UtilRepository2Config::$defaultJoinType;
            $qb->$join("$alias.$asocname", $asocname);
        }

        $fields = $meta->getFieldNames();

        UtilRepository2::fieldFilter($alias,$filters, $fields, $asocnames, $meta, $qb);
        UtilRepository2::putOrder($alias, $fields, $order, $qb);
//       echo $qb->getQuery()->getSQL();die;
        return UtilRepository2::doResult($qb, $resultType,$alias);
    }
    public static function putOrder($alias,&$fields,&$order,&$qb)
    {
//        if(in_array('activo', $fields))
//            $qb->addOrderBy("$alias.activo", "desc");
//        elseif(in_array('activa', $fields))
//            $qb->addOrderBy("$alias.activa", "desc");

        if($order != null)
        {
            if(!is_array($order) && in_array($order,$fields))
            {
                $qb->addOrderBy("$alias.$order", "asc");
            }
            elseif(is_array($order))
            {
                foreach($order as $key => $value)
                {
                    if(in_array($key,$fields))
                        $qb->addOrderBy("$alias.".$key, $value);
                    else
                        $qb->addOrderBy($key, $value);
                }
            }
            else
            {
                $qb->addOrderBy($order,'asc');
            }
        }
//        elseif(in_array('denominacion', $fields))
//            $qb->addOrderBy("$alias.denominacion", "asc");
//        elseif(in_array('nombre', $fields))
//            $qb->addOrderBy("$alias.nombre", "asc");
    }
    private static function getTotalResult(QueryBuilder $qb,$class)
    {
        if(UtilRepository2::getSession()->get("total") === false)
        {
            return 0;
        }
        $select = $qb->getDQLPart("select");
        $qb->select("count(distinct $class.id)");
//        print $qb->getQuery()->getSQL();die;
        $r = $qb->getQuery()->getSingleScalarResult();
        $qb->resetDQLPart("select");
        foreach ($select as $expr)
            $qb->add("select", $expr);

        return $r;
        //Esto es para si por esta via no se puede obtener un unico resultado en la consulta(esto pasa a veces con group by a queries con leftJoin)
//        if(UtilRepository2::getSession()->get("total") !== false) {
//
//            $select = $qb->getDQLPart("select");
//            $qb->select("count($class.id)");
//            $r = $qb->getQuery()->getSingleScalarResult();
//            $qb->resetDQLPart("select");
//            foreach ($select as $expr)
//                $qb->add("select", $expr);
//
//            return $r;
//        }
//        else
//        {
//            $select = $qb->getDQLPart("select");
//            $qb->select("$class.id");
//
//            $r = count($qb->getQuery()->getScalarResult());
//            $qb->resetDQLPart("select");
//            foreach ($select as $expr)
//                $qb->add("select", $expr);
//
//            return $r;
//        }
    }
    /**
     * @author Franlin Rivero Grcia <frrivero@uci.cu>
     * @param string $key
     * @param type $fields
     * @param \Doctrine\ORM\Mapping\ClassMetadata $meta
     * @param QueryBuilder $qb
     * @param type $asoc
     */

    public  static function fieldFilter($class,&$filters,&$fields,&$asoc,&$meta,&$qb,$all=null)
    {
        if(array_key_exists('select', $filters))
        {
            $qb->select($filters['select']);
            unset($filters['select']);
        }
        $fTemp = json_decode(UtilRepository2::getContainer()->get('request')->get('filters'));
        if( is_array($fTemp))
        {
            if(!( (is_array($filters) &&  count($filters)>0) || (!is_array($filters) && $filters != null)) )
                $filters = $fTemp;

        }
        if($filters == null)
            $filters =array();
        if(!is_array($filters))
            $filters = array($filters);
        foreach($filters as $key => $value)
        {
            if($value !== null && $value !== '')
            {
                if(in_array($key,$fields))
                {
                    $map = $meta->getFieldMapping($key);
                    if( $map['type'] =='string' || $map['type'] =='text' || $map['type'] =='varchar')
                    {
                        if(UtilRepository2Config::$defaultStringComparer == 'like')
                        {
                            $qb->andWhere("lower($class.$key) like :$key");
//                            ld(strtolower($value));
                            if(strpos($value, '%') === false)
                                $qb->setParameter($key,"%".mb_convert_case($value, MB_CASE_LOWER, "UTF-8")."%");
                            else
                                $qb->setParameter($key,mb_convert_case($value, MB_CASE_LOWER, "UTF-8"));
                        }
                        else
                        {
                            if(is_array($value))
                            {
                                $op = $value[0];
                                $qb->andWhere("lower($class.$key) $op :$key");
                                $qb->setParameter($key, mb_convert_case($value[1], MB_CASE_LOWER, "UTF-8"));
                            }
                            else
                            {
                                $qb->andWhere("lower($class.$key) = :$key");
                                $qb->setParameter($key, mb_convert_case($value, MB_CASE_LOWER, "UTF-8"));
                            }
                        }
                    }
                    else
                    {
                        if(is_array($value))
                        {
                            $op = $value[0];
                            if($op == 'in')
                            {
                                $qb->andWhere("$class.$key $op (:$key)");
                                $qb->setParameter($key, $value[1]);
                            }
                            elseif($op == 'is')
                                $qb->andWhere("$class.$key is null");
                            else
                            {
                                $qb->andWhere("$class.$key $op :$key");
                                $qb->setParameter($key, mb_convert_case($value[1], MB_CASE_LOWER, "UTF-8"));
                            }

                        }
                        else
                        {
                            $qb->andWhere("$class.$key = :$key");
                            $qb->setParameter($key, $value);
                        }
                    }
                }
                elseif (in_array($key,$asoc))
                {
                    if(is_array($value))
                    {
                        $op = $value[0];
                        if($op == 'is')
                            $qb->andWhere("$class.$key is null");
                    }
                    else{
                        $qb->andWhere("$class.$key = :$key");
                        $qb->setParameter($key, $value);
                    }
                }
                else
                {
                    $op = UtilRepository2Config::$defaultForeignCompareOperator;
                    $param = str_replace(".", '',$key);
                    if(!is_array($value))
                    {
                        if($op == 'like')
                            $qb->andWhere("lower($key) $op :$param");
                        else
                            $qb->andWhere("$key $op :$param");

                        if($op == 'like')
                        {
                            if(strpos($value, '%') === false)
                                $qb->setParameter($param,"%".mb_convert_case($value, MB_CASE_LOWER, "UTF-8")."%");
                            else
                                $qb->setParameter($param,mb_convert_case($value, MB_CASE_LOWER, "UTF-8"));
                        }
                        else
                            $qb->setParameter($param, $value);
                    }
                    else
                    {
                        if($value[0] == 'like')
                            $qb->andWhere("lower($key) $value[0] :$param");
                        elseif($value[0] == 'in')
                            $qb->andWhere("$key $value[0] (:$param)");
                        else
                            $qb->andWhere("$key $value[0] :$param");

                        if($value[0] == 'like')
                        {
                            if(strpos($value[1], '%') === false)
                                $qb->setParameter($param,"%".mb_convert_case($value[1], MB_CASE_LOWER, "UTF-8")."%");
                            else
                                $qb->setParameter($param,mb_convert_case($value[1], MB_CASE_LOWER, "UTF-8"));
                        }
                        else
                            $qb->setParameter($param, $value[1]);
                    }
                }

            }
        }

        if(array_key_exists('start', $filters) && array_key_exists('limit', $filters) && $filters['start']!= null && $filters['limit']!=null &&UtilRepository2Config::$paginate != false)
        {
            $total = UtilRepository2::getTotalResult($qb, $class);
            $start = $filters['start'];
            $limit = $filters['limit'];

            $limit = $limit == -1 ? $total : $limit;

            unset($filters['start']);
            unset($filters['limit']);

            UtilRepository2::getSession()->set("total", $total);

            $qb->setFirstResult($start);
            $qb->setMaxResults($limit);

        }
        elseif($all!=null)
        {

        }
        elseif(  UtilRepository2Config::$paginate!=false)
        {
            $start = UtilRepository2::getContainer()->get('request')->get('iDisplayStart');
            $size = UtilRepository2::getContainer()->get('request')->get('iDisplayLength');
            if($start !== null && $size !== null) {
                $total = UtilRepository2::getTotalResult($qb, $class);
                $size = $size == -1 ? $total : $size;

                if ($start != null && $size != null) {

                    UtilRepository2::getSession()->set("total", $total);
                    $qb->setFirstResult($start);
                    $qb->setMaxResults($size);
                }
            }

        }
    }
    public static function doQueryResult(\Doctrine\ORM\Query $query,  $resultType)
    {
        switch ($resultType)
        {
            case ResultType::ArrayType:
                return $query->getArrayResult();
                break;
            case ResultType::ObjectType:
                return $query->getResult();
                break;
            case ResultType::SingleObjectType:
                return $query->getSingleResult();
                break;
            case ResultType::SingleArrayType:
                return $query->getSingleResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
                break;
            default:
                throw new \Exception("Not a valid ResultType.");
        }
    }
    public static function doResult(QueryBuilder $qb,  $resultType = ResultType::ObjectType,$alias=null)
    {
        switch ($resultType)
        {
            case ResultType::QueryBuilderType:
                return $qb;
                break;
            case ResultType::QueryType:
                return $qb->getQuery();
                break;
            case ResultType::ArrayType:
                return $qb->getQuery()->getArrayResult();
                break;
            case ResultType::ObjectType:
                return $qb->getQuery()->getResult();
                break;
            case ResultType::SingleObjectType:
                return $qb->getQuery()->getOneOrNullResult();
                break;
            case ResultType::SingleArrayType:
                return $qb->getQuery()->getOneOrNullResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
                break;
            case ResultType::FirsResult:
                $r =$qb->getQuery()->setMaxResults(1)->getResult();
                if(count($r) > 0)
                    return $r[0];
                else
                    return null;
                break;
            case ResultType::OneResult:
                return $qb->getQuery()->setMaxResults(1)->getResult();
                break;
            case ResultType::IDSType:
                $qb->select("$alias.id");
                $r = $qb->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_SCALAR);
                $result = array();
                foreach($r as $val)
                    $result[]=$val['id'];
                return $result;
                break;
            default:
                throw new \Exception("Not a valid ResultType.");
        }
    }
    public static function createAlias($class)
    {
        $array = explode(":",$class);
        if(count($array)>0)
            $class = $array[count($array)-1];
        $returnString = '';
        $len = strlen($class) ;
        for($i = $len - 1;$i >= 0 && $class[$i] != '\\'; $i--)
        {
            $returnString = $class[$i].$returnString;
        }
        return lcfirst($returnString);
    }
    /**
     * @author Franlin Rivero Grcia <frrivero@uci.cu>
     */
    public static function getFields($em,$class)
    {
        $meta  = $em->getClassMetadata($class);
        return $meta->getFieldNames();
    }
    /**
     * @author Franlin Rivero Grcia <frrivero@uci.cu>
     */
    public static function getAsociations($em,$class)
    {
        $meta  = $em->getClassMetadata($em,$class);
        return $meta->getAssociationNames();
    }
    /**
     * @author Franlin Rivero Grcia <frrivero@uci.cu>
     */
    public static function getIds($em,$class)
    {
        $meta  = $em->getClassMetadata($class);
        $ids = $meta->getIdentifier();
        if(!is_array($ids))
            return UtilRepository2::doResult (UtilRepository2::getQBTable($em, $class)->select($ids), ResultType::ArrayType);
        else
        {
            $qb = UtilRepository2::getQBTable($em, $class);
            foreach ($ids as $id)
                $qb->addSelect ($id);
            return UtilRepository2::doResult ( $qb, ResultType::ArrayType);
        }
        return $meta->getAssociationNames();
    }
    /**
     * NO USAR, ESTO NO SE DBE USAR
     *
     * @deprecated since version 2
     * @author Franlin Rivero Grcia <frrivero@uci.cu>
     * @param EntityManager $em
     * @param QueryBuilder $qb
     * @param array $filters Arreglo asociativo campo => valor
     * @param ResultType $resultType
     * @param type $order
     * @param type $page
     * @return array
     */
    public  static function filterRecordsQueryString(EntityManager $em, $dql,  $filters = array(),$order = null,$resultType = ResultType::ArrayType,$page = null)
    {
        $op = UtilRepository2Config::$defaultQueryStringCompareOperator;
        $query = $dql;
        if(is_array($dql))
        {
            $query = $dql[0];
            $query.= " ".$dql[1];
        }
        $i = 0;
        foreach($filters as $key => $value)
        {
            $param = str_replace(".", '',$key);
            if($i== 0 && !is_array($dql))
            {

                if(is_array($value))
                {
                    $query.= " where $key $value[0] :$param";
                }
                else
                    $query.= " where $key $op :$param";
            }
            else
            {
                if(is_array($value))
                    $query.= " and $key $value[0] :$param";
                else
                    $query.= " and $key $op :$param";
            }
            $i++;
        }
        if($order != null)
            $query.= " order by $order";
        $query = $em->createQuery($query);
        foreach($filters as $key => $value)
        {
            $param = str_replace(".", '',$key);
            if(!is_array($value))
            {
                if($op == 'like')
                    $query->setParameter ($param, "%$value%");
                else
                    $query->setParameter ($param, $value);;
            }
            elseif($value[0] == 'like')
                $query->setParameter ($param, "%".strtolower ($value[1])."%");
            else
            {
                $query->setParameter ($param, $value[1]);
            }

        }
        return UtilRepository2::doQueryResult($query, $resultType);
    }
}

?>
