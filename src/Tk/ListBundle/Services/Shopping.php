<?php
//src/Tk/ListBundle/Services/Shopping.php

namespace Tk\ListBundle\Services;

class Shopping {

	protected $em;

	public function __construct(\Doctrine\ORM\EntityManager $em)
	{
		$this->em = $em;
	}

	public function getAllShoppingItems($group)
    {
        return $all_items = $group->getShoppingItems();
    }
}