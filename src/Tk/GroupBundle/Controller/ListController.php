<?php

namespace Tk\GroupBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ListController extends Controller
{
    public function indexAction()
    {
        return $this->render('TkGroupBundle:Lists:index.html.twig');
    }
}