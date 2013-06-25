<?php

namespace Tk\WelcomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('TkWelcomeBundle:Default:index.html.twig');
    }

    public function registerAction()
    {
    	return $this->render('TkWelcomeBundle:Links:register.html.twig');
    }

    public function testAction()
    {
    	return $this->render('::test.html.twig');
    }
}
