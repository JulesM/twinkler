<?php
//src/Tk/ListBundle/Services/Todos.php

namespace Tk\ListBundle\Services;

class Todos {

	protected $em;

	public function __construct(\Doctrine\ORM\EntityManager $em)
	{
		$this->em = $em;
	}

	public function getAllTodos($group)
    {
        return $all_todos = $group->getTodos();
    }
}