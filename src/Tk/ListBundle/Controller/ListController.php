<?php

namespace Tk\ListBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Tk\ListBundle\Entity\Todo;

class ListController extends Controller
{
    public function indexAction()
    {
        return $this->render('TkListBundle::index.html.twig', array(
        	'all_todos' => $this->getAllTodosAction(),
        	'all_items' => $this->getAllShoppingItemsAction(),
        	));
    }

    private function getAllTodosAction()
    {
    	$todos_service = $this->container->get('tk_list.todos');
    	return $todos_service->getAllTodos($this->getUser());
    }

    private function getAllShoppingItemsAction()
    {
    	$shopping_service = $this->container->get('tk_list.shopping');
    	return $shopping_service->getAllShoppingItems($this->getUser());
    }
}