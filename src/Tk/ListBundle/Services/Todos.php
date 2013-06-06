<?php
//src/Tk/ListBundle/Services/Todos.php

namespace Tk\ListBundle\Services;

class Todos {

	protected $em;

	public function __construct(\Doctrine\ORM\EntityManager $em)
	{
		$this->em = $em;
	}

	public function getAllTodos($user)
    {
        $todos_repository = $this->em->getRepository('TkListBundle:Todo');
        return $all_todos = $todos_repository->findAll();
    }
}