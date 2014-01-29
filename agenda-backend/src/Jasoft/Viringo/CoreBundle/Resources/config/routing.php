<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('jasoft_viringo_core_homepage', new Route('/hello/{name}', array(
    '_controller' => 'JasoftViringoCoreBundle:Default:index',
)));

return $collection;
