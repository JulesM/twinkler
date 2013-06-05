<?php

namespace Tk\GroupBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SettingController extends Controller
{
    public function indexAction()
    {
        return $this->render('TkGroupBundle:Settings:index.html.twig');
    }
}