<?php

namespace Tk\ListBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Tk\ListBundle\Entity\Todo;

class ListController extends Controller
{
    public function indexAction()
    {
        if(!$this->getUser()->getCurrentMember()){
            return $this->redirect($this->generateUrl('tk_user_homepage'));
        }else{
            return $this->render('TkListBundle::index.html.twig');
        }
    }

    private function getAllTodosAction()
    {
    	$todos_service = $this->container->get('tk_list.todos');
    	return $todos_service->getAllTodos($this->getUser()->getCurrentMember()->getTGroup());
    }

    private function getAllShoppingItemsAction()
    {
    	$shopping_service = $this->container->get('tk_list.shopping');
    	return $shopping_service->getAllShoppingItems($this->getUser()->getCurrentMember()->getTGroup());
    }
}