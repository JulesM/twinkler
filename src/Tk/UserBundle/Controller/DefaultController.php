<?php

namespace Tk\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('TkUserBundle:Default:index.html.twig');
    }
}
