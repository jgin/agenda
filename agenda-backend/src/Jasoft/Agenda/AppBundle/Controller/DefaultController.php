<?php

namespace Jasoft\Agenda\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/hello/{name}")
     * @Template()
     */
    public function indexAction($name)
    {
        return array('name' => $name);
    }
    
    /**
     * @Route("/contacts/list")
     * @Template()
     */
    public function listContactsAction()
    {
        $res=new \Symfony\Component\HttpFoundation\Response();
        $data=array(
            array(
                'name'=>'Luis Vercelli',
                'email'=>'lvercelli@gmail.com'
            ),
            array(
                'name'=>'Clauia Tirado',
                'email'=>'ctirado@gmail.com'
            ),
        );
        $res->setContent(json_encode($data));
        $res->headers->set('content-type', 'application/json');
        return $res;
    }
    
    
}
