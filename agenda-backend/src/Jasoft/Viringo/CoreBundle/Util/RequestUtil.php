<?php

namespace Jasoft\Viringo\CoreBundle\Util;

/**
 * Description of RequestUtil
 *
 * @author lvercelli
 */
class RequestUtil {
    
    /**
     * @var \JMS\Serializer\Serializer
     */
    private $serializer;
    
    public function getSerializer() {
        return $this->serializer;
    }

    public function setSerializer($serializer) {
        $this->serializer = $serializer;
    }

        
    public function getListRequestData(\Symfony\Component\HttpFoundation\Request $request) {
        $result=array('active'=>null, 'filter'=>null, 'sort'=>null, 'pageNumber'=>null, 'pageSize'=>null);
        $params=$this->getParameterBag($request);
        
        $active=$this->readBooleanValue($params->get('active'));
        $result['active']=$active;
        
        $filter=$params->get('filter');
        $result['filter']=json_decode($filter);
        $sort=$params->get('sort');
        $result['sort']=json_decode($sort);
        
        $pageNumber=$params->get('page');
        $result['pageNumber']=$pageNumber;
        $pageSize=$params->get('limit');
        $result['pageSize']=$pageSize;
        
        return $result;
    }
    
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\ParameterBag
     */
    private function getParameterBag(\Symfony\Component\HttpFoundation\Request $request) {
        $method=$request->getMethod();
        if ('GET' === $method) {
            return $request->query;
        } else {
            return $request->request;
        }
    }
    
    /**
     * 
     * @param string $value
     * @return boolean
     */
    private function readBooleanValue($value) {
        if ('true'===$value) { return true; }
        elseif ('false'===$value) { return false; }
        return null;
    }
    
    public function defaultJsonResponse($data) {
        $json=$this->serializer->serialize($data, 'json');
        $res=new \Symfony\Component\HttpFoundation\Response($json);
        $res->headers->set('content-type', \Jasoft\Viringo\CoreBundle\Controller\Domain\ContentTypes::JSON);
        
        return $res;
    }
    
    public function defaultErrorMessage($message) {
        return $this->defaultSuccessJsonResponse(false, array(
            'message'=>$message
        ));
    }
    
    public function defaultSuccessJsonResponse($success=true, array $extraData=null) {
        $result=array('success'=>$success);
        if (!empty($extraData)) {
            foreach ($extraData as $key=>$value) {
                $result[$key]=$value;
            }
        }
        return $this->defaultJsonResponse($result);
    }
    
    public function defaultListJsonResponse($entities, $total, $success=true) {
        $data=array(
            'data'=>$entities,
            'total'=>$total,
            'success'=>$success
        );
        return $this->defaultJsonResponse($data);
    }
    
    /**
     * Busca todos los métodos que empiezan con set en "$entity" y trata de llenarlos con valores del request
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param type $entity
     */
    public function populateEntityFromRequest(\Symfony\Component\HttpFoundation\Request $request, $entity) {
        $requestBag=$this->getParameterBag($request);
        $methods=get_class_methods($entity);
        foreach ($methods as $methodName) {
            if (substr($methodName, 0, 3)==='set') {
                $attrName=lcfirst(substr($methodName, 3));
                if ($requestBag->has($attrName)) {
                    $value=$requestBag->get($attrName);
                    $entity->$methodName($value);
                }
            }
        }
    }
    
    /**
     * Busca todos los métodos que empiezan con set en "$entity" y trata de llenarlos con valores del array
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param type $entity
     */
    public function populateEntity($data, $entity) {
        $methods=get_class_methods($entity);
        foreach ($methods as $methodName) {
            if (substr($methodName, 0, 3)==='set') {
                $attrName=lcfirst(substr($methodName, 3));
                if (array_key_exists($attrName, $data)) {
                    $value=$data[$attrName];
                    $entity->$methodName($value);
                }
            }
        }
    }
    
    /**
     * @return string
     */
    public function getRemoteIpAddress() {
        if (array_key_exists('REMOTE_ADDR', $_SERVER)) {
            return $_SERVER['REMOTE_ADDR'];
        }
        else {
            return null;
        }
    }
    
    /**
     * 
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Jasoft\Viringo\CoreBundle\Util\PageRequestData
     */
    public function getPageRequestDataFrom(\Symfony\Component\HttpFoundation\Request $request) {
        $pageRequestData=new PageRequestData();
        
        $data=$this->getListRequestData($request);
        $pageRequestData->setActive($data['active'])
                ->setPageNumber($data['pageNumber'])
                ->setPageSize($data['pageSize']);
        
        if (!empty($data['filter']) && is_array($data['filter']) && count($data['filter'])>0) {
            $filters=array();
            foreach ($data['filter'] as $filter) {
                $comparison=null;
                $value=$filter->value;
                if (!empty($filter->type)) {
                    if ('date'===$filter->type) {
                        $value=DateUtil::parseClientFormatToDate($value);
                    }
                }
                if (!empty($filter->comparison)) { $comparison=$filter->comparison; }
                $comparator=\Jasoft\Viringo\CoreBundle\Repository\Util\SearchFilter::getComparatorFromStr($comparison);
                $filters[]=new \Jasoft\Viringo\CoreBundle\Repository\Util\SearchFilter($filter->field, $comparator, $value);
            }
            $pageRequestData->setFilters($filters);
        }
        
        if (!empty($data['sort']) && is_array($data['sort']) && count($data['sort'])>0) {
            $sorting=array();
            foreach ($data['sort'] as $sort) {
                $sorting[]=new \Jasoft\Viringo\CoreBundle\Repository\Util\Sort($sort->property, $sort->direction);
            }
            $pageRequestData->setSorting($sorting);
        }
        
        return $pageRequestData;
    }
}
