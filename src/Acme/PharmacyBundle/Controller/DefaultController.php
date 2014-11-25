<?php

namespace Acme\PharmacyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AcmePharmacyBundle:Default:index.html.twig', array('name' => $name));
    }
}
