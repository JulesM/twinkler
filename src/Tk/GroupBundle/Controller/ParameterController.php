<?php

namespace Tk\GroupBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ParameterController extends Controller
{
    public function indexAction()
    {
        return $this->render('TkGroupBundle:Parameters:index.html.twig');
    }
}