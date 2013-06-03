<?php

namespace Tk\WelcomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('TkWelcomeBundle:Default:index.html.twig');
    }
}
