<?php
//src/Tk/ListBundle/Services/Shopping.php

namespace Tk\ListBundle\Services;

class Shopping {

	protected $em;

	public function __construct(\Doctrine\ORM\EntityManager $em)
	{
		$this->em = $em;
	}

	public function getAllShoppingItems($user)
    {
        $shopping_repository = $this->em->getRepository('TkListBundle:ShoppingItem');
        return $all_items = $shopping_repository->findAll();
    }
}