<?php

namespace Tk\ListBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Tk\ListBundle\Entity\ShoppingItem;
use Tk\ListBundle\Form\ShoppingItemType;

class ShoppingController extends Controller
{
    public function newAction()
    {
    	$user = $this->getUser();
    	$item = new ShoppingItem();
    	$item->setAuthor($user);
        $item->setGroup($user->getCurrentTGroup());
    	$item->setAddedDate(new \Datetime('now'));
    	$item->setState(true);

    	$form = $this->createForm(new ShoppingItemType(), $item);

    	$request = $this->get('request');

        if ($request->isMethod('POST')) {
            
            $form->bind($request);

            if ($form->isValid()) {          
        
    		$em = $this->getDoctrine()->getEntityManager();
    		$em->persist($item);
    		$em->flush();

        	return $this->redirect($this->generateUrl('tk_list_homepage'));
    	}}

    	return $this->render('TkListBundle:Shopping:new.html.twig', array(
    		'form' => $form->createView(),
    	));
    }

    public function removeAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $item = $em->getRepository('TkListBundle:ShoppingItem')->find($id);

        $em->remove($item);
        $em->flush();

        return $this->redirect($this->generateUrl('tk_list_homepage'));
    }
}