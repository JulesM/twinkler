<?php

namespace Tk\ListBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Tk\ListBundle\Entity\Todo;
use Tk\ListBundle\Form\TodoType;

class TodosController extends Controller
{
    public function newAction()
    {
    	$member = $this->getUser()->getCurrentMember();
    	$todo = new Todo();
        $todo->setAuthor($member);
        $todo->setGroup($member->getTGroup());
    	$todo->setDate(new \Datetime('now'));

        $group = $member->getTGroup();

    	$form = $this->createForm(new TodoType($group), $todo);

    	$request = $this->get('request');

        if ($request->isMethod('POST')) {
            
            $form->bind($request);

            if ($form->isValid()) {          
        
    		$em = $this->getDoctrine()->getEntityManager();
    		$em->persist($todo);
    		$em->flush();

        	return $this->redirect($this->generateUrl('tk_list_homepage'));
    	}}

    	return $this->render('TkListBundle:Todos:new.html.twig', array(
    		'form' => $form->createView(),
    	));
    }

    public function editAction($id)
    {
        $member = $this->getUser()->getCurrentMember();
        $group = $member->getTGroup();

        $em = $this->getDoctrine()->getEntityManager();
        $todo = $em->getRepository('TkListBundle:Todo')->find($id);

        $form = $this->createForm(new TodoType($group), $todo);

        $request = $this->get('request');

        if ($request->isMethod('POST')) {
            
            $form->bind($request);

            if ($form->isValid()) {          
        
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($todo);
            $em->flush();

            return $this->redirect($this->generateUrl('tk_list_homepage'));
        }}

        return $this->render('TkListBundle:Todos:edit.html.twig', array(
            'form' => $form->createView(),
            'id'   => $todo->getId(),
        ));
    }

    public function checkAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $todo = $em->getRepository('TkListBundle:Todo')->find($id);

        $todo->setActive(false);
        $em->flush();

        return $this->redirect($this->generateUrl('tk_list_homepage'));
    }

    public function removeAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $todo = $em->getRepository('TkListBundle:Todo')->find($id);

        $em->remove($todo);
        $em->flush();

        return $this->redirect($this->generateUrl('tk_list_homepage'));
    }
}